<?php
namespace Lapi\Models\Tool\Import;

class MArea extends \Api\Models\Tool\ImportAbstract
{
    /**
     * スキーマ情報
     * @var array
     */
    protected $config= array(
        'primary' => ['id'],
        'table'   => 'm_area',
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
