<?php
/**
 * Lapi\Models\Model
 */
namespace Lapi\Models\Model;

/**
 * Comment
 */
class Comment extends \Lapi\Models\Model\ReactionAbstract
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
