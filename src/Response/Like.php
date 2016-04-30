<?php
namespace Treasure\Response;

class Like extends \Treasure\Response\AbstractModel
{
    protected static $defaultFields = ['id', 'treasure_id', 'account_id', 'created_at', 'updated_at'];
}
