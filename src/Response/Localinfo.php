<?php
namespace Lapi\Response;

class Localinfo extends \Api\Response\AbstractModel
{
    protected static $defaultFields = ['id', 'subkey', 'title', 'account_id',
                                       'prefecture_id', 'prefecture_name',
                                       'comment_count', 'like_count',
                                       'area_id', 'area_name','status',
                                       'comment', 'image_url', 'created_at', 'updated_at'];
}
