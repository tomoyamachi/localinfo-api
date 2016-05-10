<?php
namespace Treasure\Tool\Controllers;

class MemberController extends \Phalcon\Mvc\Controller
{
    const VALID_USERNAME = 'gochipon';
    const VALID_PASSWORD = 'treasure';
    /**
     * ログイン画面
     */
    public function indexAction()
    {
        if ($this->session->has('login')) {
            return $this->response->redirect('/tool');
        }
    }

    /**
     * ログインアクション
     */
    public function loginAction()
    {
        $req = $this->request;
        if ($req->isPost()) {
            if (($req->getPost('loginId') === self::VALID_USERNAME) && ($req->getPost('password') === self::VALID_PASSWORD)) {
                $this->session->set('login', true);
            }
        }
        $this->response->redirect('/member/index?m=失敗しました');
    }

    /**
     * ログアウトアクション
     */
    public function logoutAction()
    {
        $this->session->destroy();
        $this->response->redirect('/member/index');
    }
}
