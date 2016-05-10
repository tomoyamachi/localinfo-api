<?php
/**
 * Treasure\Models\Model
 */
namespace Treasure\Models\Model;

use \Treasure\Models\ApiConnector;

// 投稿データの共通処理部分
class PostDataAbstract extends \Treasure\Models\Model\UserAbstract
{
    const STATUS_VALID = 'valid';
    const STATUS_INVALID = 'invalid';

    public static $statusLabel = [self::STATUS_VALID => '有効',
                                  self::STATUS_INVALID => '無効',];


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


    // キャッシュがあればキャッシュから取得
    public function findFirstById($id)
    {
        $conditions = ['id' => $id];
        return $this->findOrCreateCache($conditions);
    }

    /**
     * 指定されたパラメータの中のconditionにstatus = validを追加
     * @param array $params
     * @return array
     */
    private function getConditionWithStatusValid($params)
    {
        $condition = isset($params['conditions']) ? $params['conditions'] : [];
        $condition['status'] = self::STATUS_VALID;
        return $condition;
    }


    /**
     * 有効なもののみ取得
     * @param array $params
     * @return resultset
     */
    public function findStatusValid($params)
    {
        $params['conditions'] = $this->getConditionWithStatusValid($params);
        return self::findByParams($params);
    }

    /**
     * 指定した検索条件で有効な件数を表示
     * @param array $params
     * @return int
     */
    public function getTotalStatusValid($params)
    {
        $condition = $this->getConditionWithStatusValid($params);
        return self::countByParams(['conditions' => $condition]);
    }

    /**
     * 投稿者名を取得
     * @return string
     */
    protected function getAccountName()
    {
        $account = ApiConnector::getAccount($this->account_id);
        if ($account) {
            return $account['nickname'];
        }
        return '';
    }

    public function delete()
    {
        $this->status = self::STATUS_INVALID;
        if ($this->update()) {
            return true;
        }
        return false;
    }
}
