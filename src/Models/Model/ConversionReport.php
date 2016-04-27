<?php
/**
 * Treasure\Models\Model
 */
namespace Treasure\Models\Model;

/**
 * ConversionReport
 */
class ConversionReport extends \Treasure\Models\Model\UserAbstract
{
    protected static $defaultData = ['id' => null,
                                     'current_value' => 0
                                     ];

    public function initializeByFirst($conversionId, $conversionTag)
    {
        $this->set('product_conversion_id', $conversionId);
        $this->set('product_conversion_tag', $conversionTag);
        foreach (static::$defaultData as $column => $default) {
            $this->set($column, $default);
        }
    }

    /**
     * コンバージョン回数をプラス
     * @param int $value
     * @return void
     */
    public function addValue($value = 1)
    {
        $this->current_value += $value;
    }
}
