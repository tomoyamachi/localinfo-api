<?php
namespace Treasure\Response;

/**
 * 配送情報を配列にして返す
 */
class ShipManagement extends \Treasure\Response\AbstractModel
{
    protected static $defaultFields = ['id', 'product_id', 'product_name', 'reference_type', 'account_id', 'account_address_id', 'begin_delivery_date', 'end_delivery_date'];
}
