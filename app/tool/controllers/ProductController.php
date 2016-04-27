<?php
/**
 *  ProductControllerクラス
 */
namespace Treasure\Tool\Controllers;

use \Treasure\Models\ApiConnector;
use \Treasure\Models\Model\Customer;
use \Treasure\Models\Model\Product;
use \Treasure\Models\Model\ProductReferenceAbstract;
use \Treasure\Models\Model\ProductConversion;
use \Treasure\Models\Model\ProductLottery;
use \Treasure\Models\Model\ProductAchievement;
use \Api\Models\Validator;
use \Api\Models\Paginator;
use \Api\Models\Tool\Label;

class ProductController extends \Treasure\Tool\Controllers\AbstractController
{
    protected $customerActions = ['edit' => 1, 'editReference' => 1,]; // 顧客
    protected $employeeActions = ['index' => 1, 'edit' => 1, 'editReference' => 1,]; // 社内バイト

    /**
     * 顧客を選択して賞品を作成
     */
    public function indexAction()
    {
        $req = $this->request;
        $this->createOrUpdate($req);

        $this->view->hiddenColumn = ['id','category_id', ];
        $this->view->unnecessaryColumn = [ 'created_at', 'customer_id', 'updated_at'];

        $this->view->pageCustomerId = $req->getPost('product_customer_id');
        $customerNames = ['' => '--未選択--'];
        foreach (Customer::find() as $customer) {
            $customerNames[$customer->id] = $customer->name;
        }
        $this->view->customerNames = $customerNames;
    }


    /**
     * 商品データの作成/編集
     */
    public function editAction()
    {
        $req = $this->request;
        $customerId = $req->get('customer_id');
        $this->createOrUpdate($req);
        $this->view->customer = Customer::findFirstByIdStrict($customerId);
        $this->view->hiddenColumn = ['id','category_id', 'customer_id'];
        $this->view->unnecessaryColumn = [ 'created_at', 'updated_at'];
    }

    /**
     * 新規作成などの共通処理部分
     * @param Request $req
     * @return boolean
     */
    private function createOrUpdate($req)
    {
        $errorMessages = []; // POST時のエラーメッセージがあれば保存
        $productId = $req->get('product_id');
        $product = Product::findFirstByIdStrictOrCreate($productId);
        $config = new \Api\Models\Tool\Config('product');
        $this->view->edit_create_label = Label::EDIT;

        // POSTデータがあれば編集された項目があったとみなす
        if ($req->isPost()) {
            $addData = $product->addFirstData($req->getPost(), $config);
            if (! $addData) {
                $errorMessages = Validator::changeMassagesToHash($product->getMessages());
            } else {
                $product->save();
                $this->view->flash = Label::MESSAGE_UPDATED;
            }
        } elseif (! property_exists($product, 'id')) {
            // 編集データがない場合
            $customerId = $req->get('customer_id');
            $product->initializeByFirst($customerId);
            $this->view->edit_create_label = Label::CREATE;
        }
        $this->view->editModel = $product;
        $form = new \Treasure\Forms\Model\Product();
        if ($this->member->isAdmin()) {
            $form->add($form->configureStatus(Product::$statusLabel));
        }

        $this->view->form = $form;
        $this->view->modelName = 'product';
        $this->view->config = $config;
        $this->view->errorMessages = $errorMessages;
    }

    /**
     * 商品関連データを作成/編集
     */
    public function editReferenceAction()
    {
        $req = $this->request;
        $productId = $req->get('product_id');
        $reference = $req->get('reference');
        $referenceId = $req->get('reference_id');
        $product = Product::findFirst($productId);
        $this->view->productConfig = new \Api\Models\Tool\Config('product');
        $this->view->product = $product;
        $namespace = '\\Treasure\\Models\\Model\\Product'.\Gcl\Util\Inflector::upperCamel($reference);
        $config = new \Api\Models\Tool\Config('product_'.$reference);
        $errorMessages = []; // POST時のエラーメッセージがあれば保存

        $this->view->edit_create_label = Label::EDIT;
        $referenceModel = $namespace::findFirstByIdStrictOrCreate($referenceId);

        // POSTデータがあればデータを検証して更新。エラーがあればメッセージを取得
        if ($req->isPost()) {
            $addData = $referenceModel->addFirstData($req->getPost(), $config);
            if (! $addData) {
                $errorMessages = Validator::changeMassagesToHash($referenceModel->getMessages());
            } else {
                $referenceModel->save();
                $this->view->flash = Label::MESSAGE_UPDATED;
            }
        } elseif (! property_exists($referenceModel, 'id')) {
                $referenceModel->initializeByFirst($productId);
                $this->view->edit_create_label = Label::CREATE;
        }

        $this->view->editModel = $referenceModel;
        $mApplications = ApiConnector::getApplications();
        $this->view->apps = $mApplications;
        $this->view->appDeliveryRate = $referenceModel->getDeliveryRateData();
        // 新データ用のForm
        $formNamespace = '\\Treasure\\Forms\\Model\\Product'.
            \Gcl\Util\Inflector::upperCamel($reference);
        $form = new $formNamespace();
        if ($this->member->isAdmin()) {
            $form->add($form->configureStatus(ProductReferenceAbstract::$statusLabel));
        }

        $this->view->form = $form;
        $this->view->modelName = 'product_'.$reference;
        $this->view->hiddenColumn = ['id','product_id'];
        $this->view->unnecessaryColumn = ['product_delivery_rate_group_id', 'tag'];
        $this->view->config = $config;
        $this->view->errorMessages = $errorMessages;
    }
}
