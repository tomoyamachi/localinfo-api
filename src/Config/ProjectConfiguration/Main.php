<?php
/**
 * Lapi\Config\ProjectConfiguration
 */
namespace Lapi\Config\ProjectConfiguration;

use Gpl\Config\ProjectConfiguration\Base;

/**
 * Main : お宝情報のまとめサイト
 */
class Main extends Base
{

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
        parent::__construct('main', $env);
    }

    protected function initialize()
    {
        $this->di->set('tag', new \Api\Helper\AppTag());
        //$this->di->set('tag', new \Lapi\Helper\AppTag());
    }
}
