<?php
namespace Treasure\Tool\Controllers;

use \Treasure\Models\ApiConnector;
use \Treasure\Models\Model\Customer;
use \Treasure\Models\Model\CustomerMember;
use \Treasure\Models\Model\SalesHistory;
use \Api\Paginator;
use \Api\Models\Tool\Label;
use \Gcl\Util\GDate;

class CallController extends \Treasure\Tool\Controllers\AbstractController
{
    protected $customerActions = []; // 顧客
    protected $employeeActions = ['index' => 1]; // 社内バイト

    protected $columns = [
                          "再コール日" => ["model" => "sales_history", "column" => "recall_date"],
                          "再コール担当者" => ["model" => "sales_history", "column" => "tool_recaller_name"],
                          "前回コール内容" => ["model" => "sales_history", "column" => "detail"],
                          "会社名" => ["model" => "customer", "column" => "name"],
                          "先方担当者名" => ["model" => "customer", "column" => "responser_name"],
                          "先方TEL" => ["model" => "customer", "column" => "responser_phone"],

                          "県" => ["model" => "customer", "column" => "prefecture"],
                          "市" => ["model" => "customer", "column" => "city"],
                          "営業担当" => ["model" => "customer", "column" => "support"],
                          "企業リンク先" => ["model" => "customer", "column" => "url"],
                          "前回コール日" => ["model" => "sales_history", "column" => "sales_date"],
                          "コール担当者" => ["model" => "sales_history", "column" => "tool_caller_name"],
                          "会社ページ" => ["model" => "customer", "column" => "tool_edit_button"],
                          ];

    /**
     * 再コールが近い日一覧
     */
    public function indexAction()
    {
        $req = $this->request;
        $page = $req->get('page');
        $limit = 50;

        //表示する項目
        $this->view->columns = $this->columns;

        $searchFilter = [
                         'recall_date' => '再コール日',
                         'sales_date' => '前回コール日',
                         'customer_id' => '顧客',
                         'sales_member_id' => '担当者',
                         'recall_member_id' => '再コール担当者',
                         ];

        $now = new GDate(time());

        $page = $req->get('page');
        $search = $this->getSearchHash($req);
        if (isset($search['recall_date']) && !empty($search['recall_date'])) {
            //特に指定しない
        } else {
            $search['recall_date'] = '<= "'.$now->today().' 23:59:59"';
        }
        $search['recall_status'] = SalesHistory::RECALL_STATUS_INIT;

        $model = SalesHistory::query();
        $andFlag = false;
        foreach ($search as $field => $data) {
            if ($data) {
                if (strpos($data, ' ') === false) {
                    $query = sprintf('%s = "%s"', $field, $data);
                } else {
                    $query = sprintf('%s %s', $field, $data);
                }
                $andFlag ? $model->andWhere($query) : $model->where($query);
                $andFlag = true;
            }
        }

        $paginator = \Api\Models\Paginator::factory($model)->init($page, $limit);
        $paginator->setUrl('?'.http_build_query($search));
        $this->view->paginator = $paginator;

        $this->view->searchFilter = $searchFilter;
        $this->view->httpParam = [];
        $this->view->searchDatas = $search;

        // 担当者などをselectで選択させる
        $memberNames = ['' => '--未選択--'];
        foreach (CustomerMember::find() as $member) {
            $memberNames[$member->id] = $member->name;
        }
        $this->view->memberNames = $memberNames;

        // 顧客をselectで選択させる
        $customerNames = ['' => '--未選択--'];
        foreach (Customer::find() as $customer) {
            $customerNames[$customer->id] = $customer->name;
        }
        $this->view->customerNames = $customerNames;
    }
}
