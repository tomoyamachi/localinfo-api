<?php
namespace Lapi\Models\Tool\Import;

class MPrefecture extends \Api\Models\Tool\ImportAbstract
{
    /**
     * スキーマ情報
     * @var array
     */
    protected $config= array(
        'primary' => ['id'],
        'table'   => 'm_prefecture',
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
