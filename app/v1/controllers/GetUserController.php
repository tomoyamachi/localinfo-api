<?php
namespace Treasure\V1\Controllers;

class GetUserController extends \Api\Controllers\Api\AbstractController
{
    protected $account;

    /**
     * セッションを管理
     *
     * @SuppressWarnings(PHPMD)
     */
    public function initialize()
    {
        $this->account = null;
        if ($this->session->has("account")) {
            $this->account = $this->session->get("account");
        }

        //アカウントがなければエラー
        if ($this->account === null) {
            $this->responseAuthorizeError();
            exit;
        }

        $paramId = $this->dispatcher->getParam('account_id');
        if (!empty($paramId) && $this->account['account_id'] != $paramId) {
            $this->responseAuthorizeError();
            exit;
        }
    }

    /**
     * validation エラーを返す
     *
     * @SuppressWarnings(PHPMD)
     */
    protected function responseAuthorizeError()
    {
        $result = ['error' => ['code' => 403,'message' => 'Not authorize user']];
        $this->response->setOnlyStatusCode(403);
        $this->response->setOnlyJsonContent($result);
        exit;
    }
}
