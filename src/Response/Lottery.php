<?php
namespace Treasure\Response;

/**
 * ふくびきの情報を配列にして返す
 */
class Lottery extends \Treasure\Response\AbstractModel
{
    protected static $defaultFields = ['id', 'product_id', 'product_name', 'status', 'begin_date', 'end_date'];
}
