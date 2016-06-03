<?php
/**
 * Lapi\Config\ProjectConfiguration
 */
namespace Lapi\Config\ProjectConfiguration;

use Gpl\Config\ProjectConfiguration\Base;

/**:
 * Tool
 */
class Tool extends Base
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
        parent::__construct('tool', $env);
    }

    protected function initialize()
    {
        $this->di->set('tag', new \Api\Helper\AppTag());
        //$this->di->set('tag', new \Lapi\Helper\AppTag());
    }
}
