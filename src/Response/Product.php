<?php
namespace Treasure\Response;

/**
 * Productの情報を配列にして返す
 */
class Product extends \Treasure\Response\AbstractModel
{
    protected static $defaultFields = ['id', 'name', 'status'];
}
