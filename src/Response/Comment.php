<?php
namespace Lapi\Response;

class Comment extends \Lapi\Response\AbstractModel
{
    protected static $defaultFields = ['id', 'treasure_id', 'account_id', 'comment', 'created_at', 'updated_at'];
}
