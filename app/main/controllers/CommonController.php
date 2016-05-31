<?php
namespace Treasure\Main\Controllers;

use \Treasure\Models\Model\Account;
use \Treasure\Models\Model\Treasure;
use \Treasure\Models\ApiConnector;

class CommonController extends \Phalcon\Mvc\Controller
{

    public function popup_loginAction()
    {
        $config = $this->di->get('config')->config;
        $params = ['callback' => $config->domain, 'app_code' => APP_CODE];
        $this->view->loginURL = $config->login_url.'?'.http_build_query($params);
    }


}
