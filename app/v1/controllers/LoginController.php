<?php
namespace Treasure\V1\Controllers;

use \Treasure\Models\ApiConnector;

class LoginController extends \Api\Controllers\Api\AbstractController
{
    /**
     * トークンでのログイン
     */
    public function loginAction()
    {
        $req = $this->request;
        $loginToken = $req->getPost('login_token');
        $appCode = $req->getPost('app_code');
        $auth = ApiConnector::authenticate($loginToken, $appCode);

        if ($auth === false) {
            return $this->responseParameterError('No exist user');
        }

        $this->session->start();
        $this->session->set('account', $auth);

        $auth['session'] = $this->session->getId();
        return $this->responseValidStatus($auth);
    }

    /**
     * ログアウト
     */
    public function logoutAction()
    {
        if ($this->session->destroy()) {
            $result = ['success' => true];
            return $this->responseValidStatus($result);
        }
        return $this->responseParameterError('Session destroy failed');
    }
}
