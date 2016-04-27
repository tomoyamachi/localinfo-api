<?php
namespace Treasure\Response;

/**
 * Reviewの情報を配列にして返す
 */
class Review extends \Treasure\Response\AbstractModel
{
    protected static $defaultFields = ['id', 'product_id', 'product_name', //賞品情報
                                       'account_id', 'account_name', //投稿者情報
                                       'comment', 'created_at', 'updated_at']; //投稿情報
}
