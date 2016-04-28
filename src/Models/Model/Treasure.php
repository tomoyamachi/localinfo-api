<?php
/**
 * Treasure\Models\Model
 */
namespace Treasure\Models\Model;

/**
 * Treasure
 */
class Treasure extends \Treasure\Models\Model\UserAbstract
{
    protected static $defaultData = [
                                     'id' => null,
                                     'title' => null,
                                     'account_id' => null,
                                     'prefecture_id' => null,
                                     'area_id' => null,
                                     'comment' => null,
                                     'image' => null,
                                     'status' => 'valid',
                                     'status_limit_date' => 'now',
                                     'status_updated_at' => 'now'
                                     ];
    const STATUS_VALID = 'valid';
    const STATUS_INVALID = 'invalid';
    public static $statusLabel = [self::STATUS_VALID => '有効',
                                  self::STATUS_INVALID => '無効',];


    public function initializeByFirst($accountId)
    {
        $this->set('posted_account_id', $accountId);
        foreach (static::$defaultData as $column => $default) {
            if ($default === 'now') {
                $default = date('Y-m-d h:i:s');
            }
            $this->set($column, $default);
        }
    }

    /**
     * 投稿者名を取得
     * @return string
     */
    protected function getAccountName()
    {
        return 'ほげ';
    }


    /**
     * 件名を取得
     * @return string
     */
    protected function getPrefectureName()
    {
        return 'はげ県';
    }

    /**
     * エリア名を取得
     * @return string
     */
    protected function getAreaName()
    {
        return 'でぶ区';
    }

    /**
     * 画像URLを取得
     * @return string
     */
    protected function getImageUrl()
    {
        return 'http://image.test.com/hoge.png';
    }
}