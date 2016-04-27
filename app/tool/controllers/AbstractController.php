<?php
namespace Treasure\Tool\Controllers;

use \Treasure\Models\Model\CustomerMember;

class AbstractController extends \Phalcon\Mvc\Controller
{
    protected $strangerActions = []; // ログインしていない人
    protected $customerActions = []; // 顧客
    protected $employeeActions = []; // 社内バイト
    protected $member; // ログイン者情報

    /**
     * セッションにcustomer_memberが実装されていればOK
     */
    public function initialize()
    {
        $this->view->error = $this->request->get('m');

        if (! $this->session->has('customer_member_id')) {
            if ($this->confirmAuthority('stranger') === false) {
                return $this->response->redirect('/member?m=権限がありません');
            }
            return; // sessionがなければこれ以上の処理はしない
        }

        $memberId = $this->session->get('customer_member_id');
        $member = CustomerMember::findFirst($memberId);
        if ($this->confirmAuthority($member->authority) === false) {
            return $this->response->redirect('/customer?m=権限がありません');
        }
        $this->member = $member;
    }

    /**
     * そのアクションにアクセスする権限があるか確認
     * @param  $authority
     * @return bool
     */
    private function confirmAuthority($authority)
    {
        // 管理者は全ページ見れる
        if ($authority === CustomerMember::AUTHORITY_ADMIN) {
            return true;
        }

        // それ以外は権限によって変わる
        $validPropertyName = $authority.'Actions';
        if (! isset($this->$validPropertyName)) {
            return false;
        }

        $action = $this->router->getActionName();
        $validActions = $this->$validPropertyName;
        if (isset($validActions[$action])) {
            return true;
        }
        return false;
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
        return $search;
    }

    /**
     * requestからpaginatorに必要な処理を行ってからpaginatorを返す
     * @param Models/Model/Xxxx $model
     * @param Request $req
     * @param array $httpParam
     * @param int $limit
     * @return Paginator
     */
    public function returnPaginatorByModel($model, $req, $httpParam = [], $limit = 10)
    {
        $page = $req->get('page');
        $search = $this->getSearchHash($req);
        $this->view->searchDatas = $search;

        $andFlag = false;
        foreach ($search as $field => $data) {
            if ($data) {
                if (strpos($data, ' ') === false) {
                    $query = sprintf('%s LIKE "%%%s%%"', $field, $data);
                } else {
                    $query = sprintf('%s %s', $field, $data);
                }
                $andFlag ? $model->andWhere($query) : $model->where($query);
                $andFlag = true;
            }
        }
        $paginator = \Api\Models\Paginator::factory($model)->init($page, $limit);

        $search = ['search' => $search];
        $paginator->setUrl('?'.http_build_query(array_merge($httpParam, $search)));

        return $paginator;
    }
}
