<?php
namespace Lapi\Response;

class Like extends \Api\Response\AbstractModel
{
    protected static $defaultFields = ['id', 'localinfo_id', 'account_id', 'created_at', 'updated_at'];
}
