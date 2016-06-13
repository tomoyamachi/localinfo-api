<?php
namespace Lapi\Response;

class Comment extends \Api\Response\AbstractModel
{
    protected static $defaultFields = ['id', 'localinfo_id', 'account_id', 'comment', 'created_at', 'updated_at'];
}
