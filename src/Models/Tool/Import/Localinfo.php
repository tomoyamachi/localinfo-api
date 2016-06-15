<?php
namespace Lapi\Models\Tool\Import;

class Localinfo extends \Api\Models\Tool\ImportAbstract
{
    /**
     * スキーマ情報
     * @var array
     */
    protected $config= array(
        'primary' => ['subkey'],
        'table'   => 'localinfo',
        'schema'  => []
    );

    /**
     * バリデーション
     */
    protected function checkValidate()
    {
        // TODO : バリデーションを追加
    }
}
