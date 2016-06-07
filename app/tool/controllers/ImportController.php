<?php
namespace Lapi\Tool\Controllers;

/**
 * インポート管理コントローラクラス　
 */
class ImportController extends \Api\Controllers\Tool\ImportController
{
    /**
     * モード一覧
     * @var array
     */
    protected static $selfNameSpace = 'Lapi';
    protected static $defaultImporter = 'Localinfo';

    public $servers = array(
        parent::SERVER_DEV => array('name' => '開発', 'ip' => '52.196.86.117'),
        parent::SERVER_STG => array('name' => 'ステージング', 'ip' => ''),
    );

    protected $apcs = array('www');
}
