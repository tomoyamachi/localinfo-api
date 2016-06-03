<?php
namespace Lapi\Tool\Controllers;

class AbstractController extends \Phalcon\Mvc\Controller
{

    /**
     * セッションにcustomer_memberが実装されていればOK
     */
    public function initialize()
    {
        $this->view->error = $this->request->get('e');
        $this->view->flash = $this->request->get('f');
        if (! $this->session->has('login')) {
            return $this->response->redirect('/member?e=権限がありません');
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
