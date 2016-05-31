<?php
namespace Treasure\Main\Controllers;

use \Treasure\Models\Model\Account;
use \Treasure\Models\Model\Treasure;
use \Treasure\Models\ApiConnector;

class TreasureController extends \Phalcon\Mvc\Controller
{

    public function onConstruct()
    {
        $config = $this->di->get('config')->config;
        $params = ['callback' => $config->domain, 'app_code' => APP_CODE];
        $this->view->loginURL = $config->login_url.'?'.http_build_query($params);
    }

    public function indexAction()
    {
        $config = $this->di->get('config')->config;
        if(strpos($this->request->getHTTPReferer(), $config->login_url) !== false) {
            $loginToken = $this->request->get('login_token');

            // 指定されたログイントークンのユーザー情報を取得
            $result = ApiConnector::authenticate($loginToken, APP_CODE);
            $accountId = $result['account_id'];
            $nickname = $result['account_name'];

            $account = Account::findFirst($accountId);
            if (!($account instanceof Account)) {
                $account = new Account();
                $account->initializeByFirst();
                $account->set('id', $accountId);
                $account->set('nickname', $nickname);
                $account->set('login_token', $loginToken);
                $account->save();
            }
            $this->session->start();
            $this->session->set('account', $account);
        }

        $this->view->apiURL = $config->treasure_api_domain.'/treasures';
        $this->view->limitPerConnect = 5;
    }

    /**
     * 詳細ページ
     */
    public function detailAction()
    {
        $config = $this->di->get('config')->config;
        $treasureId = $this->dispatcher->getParam('id');
        $this->view->treasure = Treasure::getInstance()->findFirstById($treasureId);
        $this->view->checkVoteFlag = false;

        $this->view->user = (object) ['id' => 1];
        $this->view->checkBadFlag = false;

        // いいね/いいね取り消しに用いるURL
        $this->view->postLikeApiURL = sprintf('%s/treasures/%d/likes', $config->treasure_api_domain, $treasureId);
        // 一度に読み込むコメント数
        $this->view->limitPerConnect = 5;

        $params = ['callback' => $config->domain, 'app_code' => APP_CODE];
        $this->view->loginURL = $config->login_url.'?'.http_build_query($params);
    }
}
