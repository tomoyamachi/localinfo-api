<?php
namespace Treasure\V1\Controllers;

class GetUserController extends \Api\Controllers\Api\AbstractController
{
    protected $account;
    protected $withoutAccountActions;

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
        if ($this->account === null && $this->requireAccount()) {
            $this->responseAuthorizeError();
            exit;
        }

        // 他の人の投稿も見ることができるのでdispatcher内のaccount_idと違っていてもOK
        /* $paramId = $this->dispatcher->getParam('account_id'); */
        /* if (!empty($paramId) && $this->account['account_id'] != $paramId) { */
        /*     $this->responseAuthorizeError(); */
        /*     exit; */
        /* } */
    }

    /**
     * アカウント情報を取得している必要があるか確認
     * @return bool
     */
    private function requireAccount()
    {
        $action = $this->router->getActionName();
        $validActions = $this->withoutAccountActions;
        if (isset($validActions[$action])) {
            return false;
        }
        return true;
    }
}
