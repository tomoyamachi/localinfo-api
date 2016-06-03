<?php
namespace Lapi\Main\Controllers;

use \Lapi\Models\Model\Account;
use \Lapi\Models\Model\Localinfo;
use \Lapi\Models\ApiConnector;

class CommonController extends \Phalcon\Mvc\Controller
{

    public function popup_loginAction()
    {
        $config = $this->di->get('config')->config;
        $params = ['callback' => $config->domain, 'app_code' => APP_CODE];
        $this->view->loginURL = $config->login_url.'?'.http_build_query($params);
    }


}
