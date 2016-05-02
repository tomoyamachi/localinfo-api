<?php
namespace Treasure\Response;

class Treasure extends \Treasure\Response\AbstractModel
{
    protected static $defaultFields = ['id', 'title', 'account_id', 'account_name',
                                       'prefecture_id', 'prefecture_name',
                                       'comment_count', 'like_count',
                                       'area_id', 'area_name','status',
                                       'comment', 'image_url', 'thumbnail_url', 'created_at', 'updated_at'];
}
