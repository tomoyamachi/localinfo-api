<?php
namespace Treasure\Tool\Controllers;

use \Treasure\Models\Model\Customer;
use \Treasure\Models\Model\Product;
use \Treasure\Models\Model\ProductConversion;
use \Treasure\Models\Model\SalesHistory;
use \Api\Paginator;
use \Api\Models\Tool\Label;
use \Gcl\Util\Inflector;

class SalesController extends \Treasure\Tool\Controllers\AbstractController
{
    protected $customerActions = []; // 顧客
    protected $employeeActions = ['index' => 1]; // 社内バイト


    protected $columns = [
                          "NO" => ["model" => "product", "column" => "id"],
                          "企業詳細" => ["model" => "customer", "column" => "tool_edit_button"],
                          "賞品詳細" => ["model" => "customer", "column" => "tool_products_button"],
                          "大エリア" => ["model" => "customer", "column" => "region"],
                          "県" => ["model" => "customer", "column" => "prefecture"],
                          "市区町村" => ["model" => "customer", "column" => "city"],
                          "タイプ" => ["model" => "product", "column" => "label_by_type"],
                          "ご提供商品" => ["model" => "product", "column" => "name"],
                          "賞品状況" => ["model" => "product", "column" => "label_by_status"],
                          "応募確認日" => ["model" => "customer", "column" => "updated_at"],
                          "営業担当" => ["model" => "customer", "column" => "support"],
                          "会社名" => ["model" => "customer", "column" => "name"],
                          "担当者名" => ["model" => "customer", "column" => "responser_name"],
                          "メールアドレス" => ["model" => "customer", "column" => "mail"],
                          "掲載開始日" => ["model" => "latest_conversion", "column" => "begin_date"],


                          "商品内容" => ["model" => "product", "column" => "detail"],
                          //"商品上限個数" => ["model" => "productConversion", "column" => "max_limit_num"],
                          "アピール内容" => ["model" => "product", "column" => "introduction"],
                          "提供商品数" => ["model" => "latest_conversion", "column" => "max_product_quantity"],
                          "必要PV" => ["model" => "latest_conversion", "column" => "warranty_conversion"],

                          //"大カテゴリ" => ["model" => "dummy", "column" => "dummy"],
                          //"中カテゴリ" => ["model" => "dummy", "column" => "dummy"],
                          //"小カテゴリ" => ["model" => "dummy", "column" => "dummy"],
                          "サムネ画像" => ["model" => "product", "column" => "thumbnail_image_tag"],
                          //"継続確定日" => ["model" => "dummy", "column" => "dummy"],
                          "応募日" => ["model" => "product", "column" => "created_at"],
                          //"修正変更内容" => ["model" => "dummy", "column" => "dummy"],
                          //"データ対応済み" => ["model" => "dummy", "column" => "dummy"],
                          //"修正対応済み" => ["model" => "dummy", "column" => "dummy"],
                          //"メモ" => ["model" => "dummy", "column" => "dummy"],
                          //"変更操作内容" => ["model" => "dummy", "column" => "dummy"],
                          ];

    // 検索できるカラム
    protected $searchColumns = [
                          "NO" => ["model" => "product", "column" => "id"],
                          "県" => ["model" => "customer", "column" => "prefecture"],
                          "任意地域" => ["model" => "customer", "column" => "city"],
                          "応募確認日" => ["model" => "customer", "column" => "updated_at"],
                          "会社名" => ["model" => "customer", "column" => "name"],
                          "メールアドレス" => ["model" => "customer", "column" => "mail"],
                          "ご提供商品" => ["model" => "product", "column" => "name"],
                          "商品内容" => ["model" => "product", "column" => "detail"],
                          "アピール内容" => ["model" => "product", "column" => "introduction"],
                          ];


    /**
     * 一覧ページ
     */
    public function indexAction()
    {
        $req = $this->request;
        $model = Product::query();
        $httpParam = [];

        $this->returnPaginatorByModel($model, $req);
        $this->view->form = new \Treasure\Forms\Model\Product();
        $this->view->paginator = $this->returnPaginatorByModel($model, $req, $httpParam, 50);
        $this->view->columns = $this->columns;
        $this->view->searchColumns =$this->searchColumns;
    }

    public function returnPaginatorByModel($model, $req, $httpParam = [], $limit = 10)
    {
        $page = $req->get('page');
        $search = $this->getSearchHash($req);
        $this->view->searchDatas = $search;

        if ($search) {
            $searchHash = [];
            foreach ($search as $formName => $value) {
                list($modelName, $property) = explode('-', $formName);
                $searchHash[$modelName][$property] = $value;
            }

            $customerWhere = $this->getOtherModelsWhere('customer', $searchHash);

            // 顧客検索があれば一緒に追加
            $productSearch = $searchHash['product'];
            if ($customerWhere) {
                $productSearch = $customerWhere + $productSearch;
            }
            $this->setModelToWhere($model, $productSearch);
        }

        $paginator = \Api\Models\Paginator::factory($model)->init($page, $limit);
        $search = ['search' => $search];
        $paginator->setUrl('?'.http_build_query(array_merge($httpParam, $search)));
        return $paginator;
    }

    /**
     * 他のモデルの検索条件から検索すべきIDをまとめて、一緒に返す
     * @param Model $model
     * @param searray $searches
     * @return array
     */
    private function getOtherModelsWhere($modelName, $searchHash)
    {
        $namespace = '\\Treasure\\Models\\Model\\'.Inflector::upperCamel($modelName);
        $model = $namespace::query();

        $model = $this->setModelToWhere($model, $searchHash[$modelName]);
        if (empty($model->getWhere())) {
            return false;
        }

        $ids = [];
        foreach ($model->columns(array('id' => 'id'))->execute() as $model) {
            $ids[$model->id] = $model->id;
        }
        if (count($ids) === 0) {
            return false;
        }

        $idText = implode(',', $ids);
        return [$modelName.'_id' => 'in ('.$idText.')'];
    }

    /**
     * Criteriaにwhere文を追加する
     * @param Criteria $model
     * @param array $wheres
     * @return Model
     */
    private function setModelToWhere($model, $wheres)
    {
        $andFlag = false;
        foreach ($wheres as $field => $data) {
            if (! $data) {
                continue;
            }
            if (strpos($data, ' ') === false) {
                $query = sprintf('%s LIKE "%%%s%%"', $field, $data);
            } else {
                $query = sprintf('%s %s', $field, $data);
            }
            $andFlag ? $model->andWhere($query) : $model->where($query);
            $andFlag = true;
        }
        return $model;
    }

    /**
     * 対象の賞品が過去にどのような経緯を辿ったかを確認するページ
     */
    public function historyAction()
    {

    }
}
