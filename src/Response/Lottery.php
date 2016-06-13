<?php
namespace Lapi\Response;

/**
 * ふくびきの情報を配列にして返す
 */
class Lottery extends \Api\Response\AbstractModel
{
    protected static $defaultFields = ['id', 'product_id', 'product_name', 'status', 'begin_date', 'end_date'];
}
