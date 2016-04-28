<?php
namespace Treasure\Response;

class Treasure extends \Treasure\Response\AbstractModel
{
    protected static $defaultFields = ['id', 'title', 'account_id', 'account_name',
                                       'prefecture_id', 'prefecture_name',
                                       'area_id', 'area_name',
                                       'comment', 'image_url', 'created_at', 'updated_at'];
}
