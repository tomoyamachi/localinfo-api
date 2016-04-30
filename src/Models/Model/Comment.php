<?php
/**
 * Treasure\Models\Model
 */
namespace Treasure\Models\Model;

use Treasure\Models\Validator as OwnValidator;

/**
 * Comment
 */
class Comment extends \Treasure\Models\Model\UserAbstract
{
    protected static $defaultData = [
                                     'id' => null,
                                     'account_id' => null,
                                     'comment' => null,
                                     'status' => 'valid',
                                     'status_limit_date' => 'now',
                                     'status_updated_at' => 'now'
                                     ];
    const STATUS_VALID = 'valid';
    const STATUS_INVALID = 'invalid';
    public static $statusLabel = [self::STATUS_VALID => '有効',
                                  self::STATUS_INVALID => '無効',];
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


    // キャッシュがあればキャッシュから取得
    public function findFirstById($id)
    {
        $conditions = ['id' => $id];
        return $this->findOrCreateCache($conditions);
    }

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

    /**
     * 投稿者名を取得
     * @return string
     */
    protected function getAccountName()
    {
        return 'ほげ';
    }
}