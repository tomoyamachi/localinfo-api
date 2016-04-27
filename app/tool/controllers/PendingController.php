<?php
namespace Papi\Tool\Controllers;

use \Papi\Models\Model\Customer;
use \Api\Paginator;
use \Api\Models\Tool\Label;
use \Gcl\Util\Inflector;

//賞品待ち一覧を表示
class PendingController extends \Papi\Tool\Controllers\AbstractController
{
    protected $customerActions = []; // 顧客
    protected $employeeActions = []; // 社内バイト

    protected $productColumns = [
                          "ご提供商品" => ["model" => "product", "column" => "tool_name_edit_button"],
                          "会社名" => ["model" => "customer", "column" => "name"],
                          "サムネ画像" => ["model" => "product", "column" => "thumbnail_image_tag"],
                          "企業詳細" => ["model" => "customer", "column" => "tool_edit_button"],
                          "賞品詳細" => ["model" => "customer", "column" => "tool_products_button"],
                                  ];

    protected $referenceColumns = [
                          "ご提供商品" => ["model" => "product", "column" => "tool_name_edit_button"],
                          "会社名" => ["model" => "customer", "column" => "name"],
                          "サムネ画像" => ["model" => "product", "column" => "thumbnail_image_tag"],
                          "企業詳細" => ["model" => "customer", "column" => "tool_edit_button"],
                          "賞品詳細" => ["model" => "customer", "column" => "tool_products_button"],
                          "キャンペーン詳細" => ["model" => "own", "column" => "tool_edit_data_button"],
                                  ];

    /**
     * 一覧ページ
     */
    public function indexAction()
    {
        $tables = ['product' => ['column' => 'product', 'label' => '承認待ち賞品'],
                   'product_conversion' => ['column' => 'reference', 'label' => '表示管理キャンペーン'],
                   'product_lottery' => ['column' => 'reference', 'label' => 'ふくびきリスト'],
                   'product_achievement' => ['column' => 'reference', 'label' => '完全当選リスト'],
                   ];

        $this->view->tables = $tables;
        $req = $this->request;
        $table = $req->get('table');
        if ($table) {
            $namespace = '\\Papi\\Models\\Model\\'.\Gcl\Util\Inflector::upperCamel($table);
            $model = $namespace::query();
            $httpParam = ['table' => $table];
            $this->view->paginator = $this->returnPaginatorByModel($model, $req, $httpParam, 50);
            $this->view->table = $table;

            $targetColumns = $tables[$table]['column'].'Columns';
            $this->view->columns = $this->$targetColumns;
        }
    }

    public function getSearchHash($req)
    {
        // 検索パラメータ
        if ($req->isPost()) {
            $search = $req->getPost('search');
        } else {
            $search = $req->get('search');
        }
        if (is_null($search)) {
            $search = [];
        }
        return ['status' => '= "pending"'] + $search;
    }
}
