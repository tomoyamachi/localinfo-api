<?php
namespace Papi\Response;

/**
 * ふくびきの情報を配列にして返す
 */
class Lottery extends \Papi\Response\AbstractModel
{
    protected static $defaultFields = ['id', 'product_id', 'product_name', 'status', 'begin_date', 'end_date'];
}
