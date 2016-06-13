<?php
/**
 * Lapi\Config\ProjectConfiguration
 */
namespace Lapi\Config\ProjectConfiguration;

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

              '/v1/localinfos' => [
                                 'Get' => ['controller' => 'localinfo',
                                           'action' => 'get'],
                                 'Post' => ['controller' => 'localinfo',
                                            'action' => 'create'
                                            ]
                                 ],

              '/v1/localinfos/random' => [
                                 'Get' => ['controller' => 'getrandom',
                                           'action' => 'getLocalinfo'],
                                 ],

              '/v1/localinfos/near/[a-z]?([0-9-]+)' => [
                                 'Get' => ['controller' => 'getrandom',
                                           'action' => 'getNearLocalinfo',
                                           'localinfo_id' => 1],
                                 ],
              '/v1/localinfos/[a-z]?([0-9-]+)' => [
                                      'Get' => ['controller' => 'localinfo',
                                                'action' => 'getTarget',
                                                'localinfo_id' => 1],
                                      'Put' => ['controller' => 'localinfo',
                                                'action' => 'update',
                                                'localinfo_id' => 1],
                                      'Delete' => ['controller' => 'localinfo',
                                                'action' => 'delete',
                                                'localinfo_id' => 1],
                                      ],
              '/v1/accounts/{id}/localinfos' => [
                                           'Get' => ['controller' => 'localinfo',
                                                     'action' => 'getTargetUsers',
                                                     'account_id' => 1
                                                     ],
                                           ],

              '/v1/localinfos/{id}/comments' => [
                                 'Get' => ['controller' => 'comment',
                                           'action' => 'get',
                                           'localinfo_id' => 1],
                                 'Post' => ['controller' => 'comment',
                                            'action' => 'create',
                                            'localinfo_id' => 1,
                                            ],
                                 ],


              '/v1/localinfos/[a-z]?([0-9-]+)/comments/{id}' => [
                                 'Get' => ['controller' => 'comment',
                                           'action' => 'getTarget',
                                           'localinfo_id' => 1,
                                           'comment_id' => 2,
                                           ],
                                 'Put' => ['controller' => 'comment',
                                           'action' => 'update',
                                           'localinfo_id' => 1,
                                           'comment_id' => 2,
                                           ],
                                 'Delete' => ['controller' => 'comment',
                                            'action' => 'delete',
                                            'localinfo_id' => 1,
                                            'comment_id' => 2,
                                            ],
                                 ],


              '/v1/accounts/{id}/comments' => [
                                           'Get' => ['controller' => 'comment',
                                                     'action' => 'getTargetUsers',
                                                     'account_id' => 1
                                                     ],
                                           ],


              '/v1/localinfos/[a-z]?([0-9-]+)/likes' => [
                                 'Get' => ['controller' => 'like',
                                           'action' => 'get',
                                           'localinfo_id' => 1],
                                 'Post' => ['controller' => 'like',
                                            'action' => 'create',
                                            'localinfo_id' => 1,
                                            ],
                                 ],


              '/v1/localinfos/[a-z]?([0-9-]+)/likes/{id}' => [
                                 'Get' => ['controller' => 'like',
                                           'action' => 'getTarget',
                                           'localinfo_id' => 1,
                                           'like_id' => 2,
                                           ],
                                 'Put' => ['controller' => 'like',
                                           'action' => 'update',
                                           'localinfo_id' => 1,
                                           'like_id' => 2,
                                           ],
                                 'Delete' => ['controller' => 'like',
                                            'action' => 'delete',
                                            'localinfo_id' => 1,
                                            'like_id' => 2,
                                            ],
                                 ],


              '/v1/accounts/{id}/likes' => [
                                           'Get' => ['controller' => 'like',
                                                     'action' => 'getTargetUsers',
                                                     'account_id' => 1
                                                     ],
                                           ],


              '/v1/prefectures' => [
                                 'Get' => ['controller' => 'prefecture',
                                           'action' => 'get'],
                                 ],
              '/v1/prefectures/{id}' => [
                                 'Get' => ['controller' => 'prefecture',
                                           'action' => 'getTarget',
                                           'prefecture_id' => 1
                                           ],
                                 ],
              '/v1/prefectures/{id}/localinfos' => [
                                 'Get' => ['controller' => 'localinfo',
                                           'action' => 'getTargetPrefectures',
                                           'prefecture_id' => 1
                                           ],
                                 ],


              '/v1/prefectures/{id}/areas' => [
                                 'Get' => ['controller' => 'area',
                                           'action' => 'get',
                                           'prefecture_id' => 1
                                           ],
                                 ],
              '/v1/prefectures/{id}/areas/{id}' => [
                                 'Get' => ['controller' => 'area',
                                           'action' => 'getTarget',
                                           'prefecture_id' => 1,
                                           'area_id' => 2,
                                           ],
                                 ],
              '/v1/areas/{id}/localinfos' => [
                                 'Get' => ['controller' => 'localinfo',
                                           'action' => 'getTargetAreas',
                                           'area_id' => 1,
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
