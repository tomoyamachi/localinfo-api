<?php
/**
 * Treasure\Config\ProjectConfiguration
 */
namespace Treasure\Config\ProjectConfiguration;

use Gpl\Config\ProjectConfiguration\Base;

use Gcl\Util\GArray;
use Gpl\Config\Init;

/**
 * V1
 */
class V1 extends Base
{

    private $settings = [
              '/v1/login' => [
                                 'Post' => ['controller' => 'login',
                                           'action' => 'login'],
                                 ],
              '/v1/logout' => [
                                 'Post' => ['controller' => 'login',
                                           'action' => 'logout'],
                                 ],

              '/v1/treasures' => [
                                 'Get' => ['controller' => 'treasure',
                                           'action' => 'get'],
                                 'Post' => ['controller' => 'treasure',
                                            'action' => 'create'
                                            ]
                                 ],
              '/v1/treasures/{id}' => [
                                      'Get' => ['controller' => 'treasure',
                                                'action' => 'getTarget',
                                                'treasure_id' => 1],
                                      'Put' => ['controller' => 'treasure',
                                                'action' => 'update',
                                                'treasure_id' => 1],
                                      'Delete' => ['controller' => 'treasure',
                                                'action' => 'delete',
                                                'treasure_id' => 1],
                                      ],
              '/v1/accounts/{id}/treasures' => [
                                           'Get' => ['controller' => 'treasure',
                                                     'action' => 'getTargetUsers',
                                                     'account_id' => 1
                                                     ],
                                           ],

              ];

    /**
     * $configDir
     */
    protected $configDir = CONFIG_DIR;

    /**
     * PhalconやProjectのセットアップ
     *
     * @params string $env 環境
     */
    public function __construct($env)
    {
        parent::__construct('v1', $env);
    }

    // apiの場合、メソッドによって挙動を変えるため、configから設定されたrouterは使用しない。
    protected function initialize()
    {
        $this->di->remove('router');
        $this->di->set('router', $this->getRouter($this->settings));
    }

    /**
     * Routerを返す
     * @param void
     * @return \Palcon\Router\Route
     */
    private function getRouter($settings)
    {
        $router = new \Phalcon\Mvc\Router();
        $router->clear(); // デフォルトでcontroller/actionになるので削除
        $router->setUriSource(\Phalcon\Mvc\Router::URI_SOURCE_SERVER_REQUEST_URI);
        // route設定されてない場合、404ページを表示
        $router->notFound(["controller" => "error", "action" => "page404"]);

        foreach ($settings as $path => $methods) {
            // ID(数値型)の部分を一括置換
            $path = str_replace('{id}', '([0-9-]+)', $path);

            // 正しくないHTTPメソッドを指定された場合、405エラーへ
            $router->add($path, ['controller' => 'error','action' => 'page405']);

            // 指定されたメソッドでのアクセスは指定された場所に移す
            foreach ($methods as $method => $params) {
                $addMethod = 'add'.$method;
                $router->$addMethod($path, $params);
            }
        }

        return $router;
    }
}
