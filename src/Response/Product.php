<?php
namespace Lapi\Response;

/**
 * Productの情報を配列にして返す
 */
class Product extends \Api\Response\AbstractModel
{
    protected static $defaultFields = ['id', 'name', 'status'];
}
