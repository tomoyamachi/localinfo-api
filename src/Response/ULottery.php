<?php
namespace Treasure\Response;

/**
 * 完全当選賞品情報を配列にして返す
 */
class ULottery extends \Treasure\Response\AbstractModel
{
    protected static $defaultFields = ['id', 'product_id', 'product_name', 'shipping_id', 'status', 'created_at'];
}
