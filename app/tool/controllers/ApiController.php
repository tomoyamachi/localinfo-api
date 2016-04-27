<?php
namespace Treasure\Tool\Controllers;

use Phalcon\Http\Request\Method;
use Phalcon\Http\Client\Request;

// 管理ツールからAPIで確認ができるように
class ApiController extends \Treasure\Tool\Controllers\AbstractController
{
    public static $postData = ['host', 'action', 'params', 'os', 'method'];
    public static $router = [];

    public function initialize()
    {
        parent::initialize();
        $router = require_once APP_DIR.'/v1/config/config.d/router.php';
        self::$router = $router['all'];
    }

    public function indexAction()
    {
        $req = $this->request;

        $action = $req->get('action') ? $req->get('action') : key(self::$router);
        $route = self::$router[$action];

        $this->view->host = $this->config->config->api->host;
        $this->view->action = $action;
        $this->view->params = $this->getParams($action);
        $this->view->os = 'ios';
        $this->view->method = $route['method'];
        $this->view->isSubmit = false;
        $this->view->url = '';
        $this->view->requestData = '';
        $this->view->responseData = '';
        $this->view->router = self::$router;
    }

    // {{{ public function sendAction( )
    /**
     * パラメタ送信
     * @SuppressWarnings(PHPMD.UnusedLocalVariable) params host method
     * @param void
     * @return void
     */
    public function sendAction()
    {
        $req = $this->request;

        //phpcs対策として後ほど利用する変数だけ定義

        // POSTで受け取ったデータをローカル変数と、ビューに渡す
        foreach (self::$postData as $column) {
            $$column = $this->view->$column = \Gcl\Util\GText::trimEmpty($req->get($column));
        }

        // http queryをhashに変更
        $parsedParams = [];
        parse_str($params, $parsedParams);

        // curlの準備
        $provider  = Request::getProvider();
        $provider->setBaseUri($host);
        $provider->header->set('Accept', 'application/json');

        $response = $provider->$method($action, $parsedParams);
        $url = $provider->resolveUri($action) . '?' . http_build_query($parsedParams);

        $this->view->isSubmit = true;
        $this->view->url = $url;
        $this->view->requestData  = $parsedParams;

        $message = \Gcl\Util\GJson::unserialize($response->body);
        $this->view->responseData = $message ? $message : $response->body;
        $this->view->router = self::$router;
    }
    // }}}

    /**
     * actionからrouterを参照してparamsを返す
     * @param string アクション
     * @return string queryパラメータ
     */
    protected function getParams($action)
    {
        $route = self::$router[$action];
        $required = $route['required'];

        $params = '';
        foreach ($required as $param) {
            $params .= $param . "=&\n";
        }
        //最後の2文字削除(&と改行)
        $params = substr($params, 0, -2);

        return $params;
    }
}
