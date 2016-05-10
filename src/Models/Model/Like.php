<?php
/**
 * Treasure\Models\Model
 */
namespace Treasure\Models\Model;

/**
 * Like
 */
class Like extends \Treasure\Models\Model\ReactionAbstract
{
    protected static $defaultData = [
                                     'id' => null,
                                     'account_id' => null,
                                     'status' => 'valid',
                                     'created_at' => 'now',
                                     'updated_at' => 'now'
                                     ];
    protected static $instance = null;
}
