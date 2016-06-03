<?php
namespace Lapi\Response;

/**
 * Productの情報を配列にして返す
 */
class Product extends \Lapi\Response\AbstractModel
{
    protected static $defaultFields = ['id', 'name', 'status'];
}
