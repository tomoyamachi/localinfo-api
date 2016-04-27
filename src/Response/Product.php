<?php
namespace Papi\Response;

/**
 * Productの情報を配列にして返す
 */
class Product extends \Papi\Response\AbstractModel
{
    protected static $defaultFields = ['id', 'name', 'status'];
}
