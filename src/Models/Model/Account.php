<?php
/**
 * Lapi\Models\Model
 */
namespace Lapi\Models\Model;

/**
 * Account
 */
class Account extends \Lapi\Models\Model\UserAbstract
{
    protected static $defaultData = [
                                     'id' => null,
                                     'nickname' => null,
                                     'comment_count' => 0,
                                     'localinfo_count' => 0,
                                     'like_count' => 0,
                                     'status' => 'valid',
                                     'created_at' => 'now',
                                     'updated_at' => 'now'
                                     ];
    protected static $instance = null;

    // {{{ public static function getInstance()
    /**
     * 呼び出し元のinstanceを返却
     */
    public static function getInstance()
    {
        if (is_null(static::$instance)) {
            static::$instance = new static();
        }
        return static::$instance;
    }
    // }}}

    public function initializeByFirst()
    {
        foreach (static::$defaultData as $column => $default) {
            if ($default === 'now') {
                $default = date('Y-m-d h:i:s');
            }
            $this->set($column, $default);
        }
    }

    // キャッシュがあればキャッシュから取得
    public function findFirstById($id)
    {
        $conditions = ['id' => $id];
        return $this->findOrCreateCache($conditions);
    }
}
