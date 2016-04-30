<?php
namespace Treasure\Response;

class Comment extends \Treasure\Response\AbstractModel
{
    protected static $defaultFields = ['id', 'treasure_id', 'account_id', 'comment', 'created_at', 'updated_at'];
}
