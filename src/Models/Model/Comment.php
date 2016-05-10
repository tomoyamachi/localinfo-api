<?php
/**
 * Treasure\Models\Model
 */
namespace Treasure\Models\Model;

/**
 * Comment
 */
class Comment extends \Treasure\Models\Model\ReactionAbstract
{
    protected static $defaultData = [
                                     'id' => null,
                                     'account_id' => null,
                                     'comment' => null,
                                     'status' => 'valid',
                                     'created_at' => 'now',
                                     'updated_at' => 'now'
                                     ];
    protected static $instance = null;
}
