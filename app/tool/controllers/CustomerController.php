<?php
namespace Papi\Tool\Controllers;

use \Papi\Models\ApiConnector;
use \Papi\Models\Model\Customer;
use \Papi\Models\Model\CustomerMember;
use \Papi\Models\Model\Product;
use \Papi\Models\Model\ProductConversion;
use \Papi\Models\Model\ProductLottery;
use \Papi\Models\Model\ProductAchievement;
use \Papi\Models\Model\SalesHistory;
use \Api\Models\Validator;
use \Api\Paginator;
use \Api\Models\Tool\Label;

class CustomerController extends \Papi\Tool\Controllers\AbstractController
{
    protected $customerActions = ['index' => 1, 'edit' => 1, 'products' => 1, 'checkProducts' => 1,]; // 顧客
    protected $employeeActions = ['index' => 1, 'edit' => 1, 'products' => 1, 'checkProducts' => 1,]; // 社内バイト

    public function indexAction()
    {
        $req = $this->request;
        $limit = 20;
        $table = 'customer';
        $customer = Customer::query();

        $this->view->paginator = $this->returnPaginatorByModel($customer, $req, [], $limit);

        $config = new \Api\Models\Tool\Config($table);
        $this->view->config = $config;
        $this->view->fields = [
                               'tool_main_info' => '会社概要',
                               'tool_member_list' => '担当者リスト',
                               //'tool_product_count' => '商品数'
                               ];
        $this->view->searchFilter = $config->search_filter;
        $this->view->customer = new Customer();
    }

    /**
     * SalesHistoryを管理
     * @param \SalesHistory $salesHistory
     * @param array $posts
     * @return void
     */
    private function createOrUpdateSalesHistory($salesHistory, $posts)
    {
        $salesHistoryConfig = new \Api\Models\Tool\Config('sales_history');
        $addData = $salesHistory->addFirstData($posts, $salesHistoryConfig);
        if (! $addData) {
            $errorMessages = Validator::changeMassagesToHash($salesHistory->getMessages());
            throw new \Exception(\Gcl\Util\GJson::serialize($errorMessages));
        } else {
            $salesHistory->save();
            $this->view->flash = Label::MESSAGE_UPDATED;

        }
    }

    /**
     * お客さん削除
     */
    public function deleteAction()
    {
        $req = $this->request;
        $customerId = $req->get('customer_id');
        $status = $req->get('status');
        if ($status !== Customer::STATUS_DELETE && $status !== Customer::STATUS_INIT && $status !== Customer::STATUS_CONTINUE) {
            throw new \Exception("INVALID STATUS : ". $status);
        }

        $customer = Customer::findFirstByIdStrict($customerId);
        $this->view->customer = $customer;
        if ($customer) {
            $customer->set('status', $status);
            $customer->update();
            $this->view->flash = ($status === Customer::STATUS_DELETE) ? '削除しました' : '戻しました';
        } else {
            $this->view->error = '失敗しました';
        }
    }

    /**
     * 会社詳細
     */
    public function editAction()
    {
        $req = $this->request;
        $customerId = $req->get('customer_id');
        $this->view->isAdmin = ($this->member->authority === CustomerMember::AUTHORITY_ADMIN);
        $config = new \Api\Models\Tool\Config('customer');
        $this->view->edit_create_label = Label::EDIT;

        $customer = Customer::findFirstByIdStrictOrCreate($customerId);
        if ($req->isPost()) {
            $posts = $req->getPost();
            // 既存の営業履歴を編集
            if (isset($posts['sales_history_id'])) {
                $salesHistory = SalesHistory::findFirstByIdStrict($posts['sales_history_id']);
                $this->createOrUpdateSalesHistory($salesHistory, $posts);
            } else {
                // 顧客情報を編集
                $addData = $customer->addFirstData($req->getPost(), $config);
                if (! $addData) {
                    $errorMessages = Validator::changeMassagesToHash($customer->getMessages());
                    $this->view->error = '顧客情報の更新に失敗しました。フォームをご確認ください。';
                } else {
                    $customer->save();
                    $this->view->flash = Label::MESSAGE_UPDATED;
                }

                if (!empty($posts['sales_history_detail']) && $addData) {
                    $salesHistory = new SalesHistory();
                    $salesHistory->set('sales_member_id', $this->member->id);
                    $salesHistory->set('recall_member_id', $this->member->id);
                    $salesHistory->set('customer_id', $customer->id);
                    $this->createOrUpdateSalesHistory($salesHistory, $posts);
                }
            }
        } elseif (! property_exists($customer, 'id')) {
            $customer->initializeByFirst($this->member);
            $this->view->edit_create_label = Label::CREATE;
        }

        $this->view->config = $config;
        $this->view->customer = $customer;
        $this->view->editModel = $customer;
        $this->view->modelName = 'customer';
        $this->view->hiddenColumn = ['id'];
        $this->view->unnecessaryColumn = ['created_at', 'updated_at'];
        $this->view->errorMessages = $errorMessages;
        $this->view->form = new \Papi\Forms\Model\Customer();
    }

    /**
     * 顧客に紐付いている商品一覧
     */
    public function productsAction()
    {
        $req = $this->request;
        $customerId = $req->get('customer_id');

        $model = Product::query();
        $model->where(sprintf('customer_id = "%d"', $customerId));
        $httpParam = ['customer_id' => $customerId];
        $customer = Customer::findFIrst($customerId);
        $this->view->paginator = $this->returnPaginatorByModel($model, $req, $httpParam);
        $this->view->fields = [
                               'tool_name_edit_button' => '商品名'.$customer->getEditProductPageButtonHtml(),
                               'tool_reference_history' => '各データ',
                               ];

        $config = new \Api\Models\Tool\Config('product');
        $this->view->searchFilter = $config->search_filter;
        $this->view->httpParam = $httpParam;
        $this->view->customer = $customer;
    }

    /**
     * 商品データ管理
     */
    public function checkProductAction()
    {
        $req = $this->request;
        $reference = $req->get('type');
        $productId = $req->get('product_id');
        $product = Product::findFirst($productId);

        $namespace = '\\Papi\\Models\\Model\\Product'.\Gcl\Util\Inflector::upperCamel($reference);

        $model = $namespace::query();
        $query = 'product_id = '.$productId;
        $model->where($query);
        $httpParam = ['product_id' => $productId,
                      'type' => $reference];
        $this->view->paginator = $this->returnPaginatorByModel($model, $req, $httpParam);
        $reference = new $namespace();
        $reference->set('product_id', $productId);
        $this->view->reference = $reference;
        $this->view->productConfig = new \Api\Models\Tool\Config('product');
        $this->view->product = $product;
        $this->view->fields = [
                               'begin_date' => '開始日時',
                               'end_date' => '終了日時',
                               'label_by_status' => '状況',
                               'tool_delivery_ratio' => '表示されるアプリ情報',
                               'tool_edit_data_button' => '編集リンク',
                               ];
    }
}
