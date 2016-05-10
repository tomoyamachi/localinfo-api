<?php
/**
 * Treasure\Models\Model
 * お宝に1対多で対応するものの抽象クラス
 */
namespace Treasure\Models\Model;

use Treasure\Models\Validator as OwnValidator;

class ReactionAbstract extends \Treasure\Models\Model\PostDataAbstract
{
    protected static $defaultData;

    ///// 以下はTreasureモデルのみoverride ////
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
