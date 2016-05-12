<?php
namespace Treasure\Main\Controllers;

use \Treasure\Models\Model\Treasure;

class TreasureController extends \Phalcon\Mvc\Controller
{
    public function indexAction()
    {
        $config = $this->di->get('config')->config;
        if(strpos($this->request->getHTTPReferer(), $config->login_url) !== false) {
            $loginToken = $this->request->get('login_token');




        }

        $ids = Treasure::getSortedTreasureIds();
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

        $params = ['callback' => $config->domain, 'app_code' => APP_NAME];
        $this->view->loginURL = $config->login_url.'?'.http_build_query($params);
    }
}
