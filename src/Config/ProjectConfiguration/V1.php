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

              '/v1/products' => [
                                 'Get' => ['controller' => 'product',
                                           'action' => 'get'],
                                 ],
              '/v1/products/{id}' => [
                                      'Get' => ['controller' => 'product',
                                                'action' => 'getTarget',
                                                'product_id' => 1],
                                      ],

              '/v1/lotteries' => [
                                  'Get' => ['controller' => 'lottery',
                                            'action' => 'get'],
                                  'Post' => ['controller' => 'lottery',
                                             'action' => 'lot'],
                                  ],
              '/v1/lotteries/{id}' => [
                                       'Get' => ['controller' => 'lottery',
                                                 'action' => 'getTarget',
                                                 'lottery_id' => 1],
                                       ],

              '/v1/conversions' => [
                                  'Get' => ['controller' => 'conversion',
                                            'action' => 'get'],
                                  ],
              '/v1/conversions/{id}' => [
                                       'Get' => ['controller' => 'conversion',
                                                 'action' => 'getTarget',
                                                 'conversion_id' => 1],
                                       ],
              '/v1/conversions/{id}/tags/:action' => [
                                       'Put' => ['controller' => 'conversion',
                                                 'action' => 'reach',
                                                 'conversion_id' => 1,
                                                 'tag' => 2],
                                       ],

              '/v1/accounts/{id}/reviews' => [
                                           'Get' => ['controller' => 'review',
                                                     'action' => 'getTargetUsers',
                                                     'account_id' => 1
                                                     ],
                                           ],
              '/v1/products/{id}/reviews' => [
                                              'Get' => ['controller' => 'review',
                                                        'action' => 'get',
                                                        'product_id' => 1
                                                        ],
                                              'Post' => ['controller' => 'review',
                                                         'action' => 'create',
                                                         'product_id' => 1
                                                         ],
                                              ],
              '/v1/products/{id}/reviews/{id}' => [
                                                   'Get' => ['controller' => 'review',
                                                             'action' => 'getTarget',
                                                             'product_id' => 1,
                                                             'review_id' => 2
                                                             ],
                                                   'Put' => ['controller' => 'review',
                                                             'action' => 'update',
                                                             'product_id' => 1,
                                                             'review_id' => 2
                                                             ],
                                                   'Delete' => ['controller' => 'review',
                                                                'action' => 'delete',
                                                                'product_id' => 1,
                                                                'review_id' => 2
                                                                ],
                                                   ],

              '/v1/achievements' => [
                                  'Get' => ['controller' => 'achievement',
                                            'action' => 'get'],
                                  ],
              '/v1/achievements/{id}' => [
                                       'Get' => ['controller' => 'achievement',
                                                 'action' => 'getTarget',
                                                 'achievement_id' => 1],
                                       'Post' => ['controller' => 'achievement',
                                                 'action' => 'regist',
                                                 'achievement_id' => 1],
                                       ],


              '/v1/accounts/{id}/achievements' => [
                                  'Get' => ['controller' => 'account',
                                            'action' => 'getAchievements',
                                            'account_id' => 1],
                                  ],
              '/v1/accounts/{id}/lotteries' => [
                                  'Get' => ['controller' => 'account',
                                            'action' => 'getLotteries',
                                            'account_id' => 1],
                                  ],

              '/v1/accounts/{id}/shippings' => [
                                  'Get' => ['controller' => 'shipping',
                                            'action' => 'get',
                                            'account_id' => 1],
                                  ],
              '/v1/accounts/{id}/shippings/{id}' => [
                                  'Get' => ['controller' => 'shipping',
                                            'action' => 'getTarget',
                                            'account_id' => 1,
                                            'shipping_id' => 2],
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
