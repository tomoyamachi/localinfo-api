<?php
/**
 * Treasure\Models\Model
 */
namespace Treasure\Models\Model;

use Treasure\Models\Validator as OwnValidator;

/**
 * Comment
 */
class Comment extends \Treasure\Models\Model\PostDataAbstract
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

    // {{{ public static function getInstance()
    /**
     * 呼び出し元のinstanceを返却
     */
    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new static();
        }
        return self::$instance;
    }
    // }}}

    public function initializeByFirst($treasureId)
    {
        $this->set('treasure_id', $treasureId);
        foreach (static::$defaultData as $column => $default) {
            if ($default === 'now') {
                $default = date('Y-m-d h:i:s');
            }
            $this->set($column, $default);
        }
    }

    /**
     * データ作成時のバリデーション
     * @param  array $postData
     * @param array $config
     * @return boolean 成功/失敗
     */
    public function addFirstData($postData, $config)
    {
        $from = false;
        \Api\Models\Validator::setAndValidatePostData($this, $postData, $config, $from);
        // prefecture_idをチェック
        $condition = ['field' => 'treasure_id'];
        $this->checkValidate(new OwnValidator\TreasureIdValidator($condition));
        return $this->validationHasFailed() ? false : true;
    }
}
