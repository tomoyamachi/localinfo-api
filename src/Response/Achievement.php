<?php
namespace Treasure\Response;

/**
 * 完全当選賞品情報を配列にして返す
 */
class Achievement extends \Treasure\Response\AbstractModel
{
    protected static $defaultFields = ['id', 'product_id', 'product_name', 'point', 'status', 'begin_date', 'end_date'];
}
