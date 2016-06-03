<?php
/**
 * Lapi\Models\Model
 * お宝に1対多で対応するものの抽象クラス
 */
namespace Lapi\Models\Model;

use Lapi\Models\Validator as OwnValidator;

class ReactionAbstract extends \Lapi\Models\Model\PostDataAbstract
{
    protected static $defaultData;

    ///// 以下はLocalinfoモデルのみoverride ////
    public function initializeByFirst($localinfoId)
    {
        $this->set('localinfo_id', $localinfoId);
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
        $condition = ['field' => 'localinfo_id'];
        $this->checkValidate(new OwnValidator\LocalinfoIdValidator($condition));
        return $this->validationHasFailed() ? false : true;
    }
}
