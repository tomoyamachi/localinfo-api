<?php
namespace Treasure\Tool\Controllers;

use \Treasure\Models\Model\Customer;
use \Api\Models\Validator;
use \Treasure\Models\Model\CustomerMember;
use \Api\Models\Tool\Label;

// 管理ツールからAPIで確認ができるように
class MemberController extends \Treasure\Tool\Controllers\AbstractController
{
    protected $strangerActions = ['index' => 1, 'login' => 1, ];
    protected $customerActions = ['logout' => 1, 'edit' => 1,]; // 顧客
    protected $employeeActions = ['logout' => 1, 'edit' => 1,]; // 社内バイト

    /**
     * ログイン画面
     */
    public function indexAction()
    {
        if ($this->session->has('customer_member_id')) {
            return $this->response->redirect('/customer/index');
        }
    }

    /**
     * ログインアクション
     */
    public function loginAction()
    {
        $req = $this->request;
        if ($req->isPost()) {
            $mail = $req->getPost('loginId');
            $password = $req->getPost('password');
            //メールとパスワードで認証
            $member = CustomerMember::getMemberMailAndPassword($mail, $password);
            if ($member instanceof CustomerMember) {
                $this->session->set('customer_member_id', $member->id);
                $this->response->redirect('/customer/index');
            }
        }
        $this->response->redirect('/member/index?m=fail');
    }

    /**
     * ログアウトアクション
     */
    public function logoutAction()
    {
        $this->session->destroy();
        $this->response->redirect('/member/index');
    }



    /**
     * 商品データの作成/編集
     */
    public function editAction()
    {
        $req = $this->request;
        $customerId = $req->get('customer_id');
        if (empty($customerId)) {
            throw new \Exception("member should has customer_id");
        }

        $this->view->customer = Customer::findFirst($customerId);
        $memberId = $req->get('member_id');
        $errorMessages = []; // POST時のエラーメッセージがあれば保存

        $this->view->modelName = 'customer_member';
        $config = new \Api\Models\Tool\Config($this->view->modelName);

        if ($req->isPost()) {
            $posts = $req->getPost();
            if ($posts['customer_member_id'] != $memberId) {
                throw new \Exception("member_id is invalid!");
            }

            if ($memberId) {
                $customerMember = CustomerMember::findFirst($memberId);
                $this->view->edit_create_label = Label::EDIT;
            } else {
                $customerMember = new CustomerMember();
            }
            $addData = $customerMember->addFirstData($req->getPost(), $config);

            if (! $addData) {
                $errorMessages = Validator::changeMassagesToHash($customerMember->getMessages());
            } else {
                $customerMember->save();
                $this->view->flash = Label::MESSAGE_UPDATED;
            }

            $this->view->edit_create_label = Label::EDIT;
        } else {
            if ($memberId) {
                $customerMember = CustomerMember::findFirst($memberId);
                $this->view->edit_create_label = Label::EDIT;
            } else {
                $customerMember = new CustomerMember();
                $customerMember->initializeByFirst($customerId);
                $this->view->edit_create_label = Label::CREATE;
            }
        }

        $this->view->editModel = $customerMember;
        $this->view->form = new \Treasure\Forms\Model\CustomerMember();
        $this->view->hiddenColumn = ['id','customer_id'];
        $this->view->unnecessaryColumn = ['created_at', 'updated_at'];
        $this->view->config = $config;
        $this->view->errorMessages = $errorMessages;
    }
}
