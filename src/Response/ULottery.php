<?php
namespace Lapi\Response;

/**
 * 完全当選賞品情報を配列にして返す
 */
class ULottery extends \Api\Response\AbstractModel
{
    protected static $defaultFields = ['id', 'product_id', 'product_name', 'shipping_id', 'status', 'created_at'];
}
