<?php
/**
 * Lapi\Models\Model
 */
namespace Lapi\Models\Model;

use Lapi\Models\Validator as OwnValidator;

/**
 * Localinfo
 */
class Localinfo extends \Lapi\Models\Model\PostDataAbstract
{
    protected static $defaultData = [
                                     'id' => null,
                                     'title' => null,
                                     'account_id' => null,
                                     'prefecture_id' => null,
                                     'area_id' => null,
                                     'comment_count' => 0,
                                     'like_count' => 0,
                                     'main_image_id' => null,
                                     'comment' => null,
                                     'image' => null,
                                     'status' => 'valid',
                                     'created_at' => 'now',
                                     'updated_at' => 'now'
                                     ];
    const STATUS_VALID = 'valid';
    const STATUS_INVALID = 'invalid';
    public static $statusLabel = [self::STATUS_VALID => '有効',
                                  self::STATUS_INVALID => '無効',];
    protected static $instance = null;

    public function initializeByFirst()
    {
        foreach (static::$defaultData as $column => $default) {
            if ($default === 'now') {
                $default = date('Y-m-d h:i:s');
            }
            $this->set($column, $default);
        }
    }

    /**
     * 作成時のほげほげ
     * @param  array $postData
     * @param array $config
     * @return boolean 成功/失敗
     */
    public function addFirstData($postData, $config)
    {
        $from = false;
        // prefecture_id, area_id以外の情報をチェック && postdataから各種IDを設定
        \Api\Models\Validator::setAndValidatePostData($this, $postData, $config, $from);

        // prefecture_idをチェック
        $condition = ['field' => 'prefecture_id'];
        $this->checkValidate(new OwnValidator\PrefectureIdValidator($condition));

        // area_idをチェック
        $condition = ['field' => 'area_id'];
        $this->checkValidate(new OwnValidator\AreaIdValidator($condition));

        return $this->validationHasFailed() ? false : true;
    }

    /**
     * コメント数を追加
     * @param int $addNum
     * @return bool
     */
    public function addCommentCount($addNum = 1)
    {
        if ($addNum < 1) {
            return false;
        }
        $this->comment_count += $addNum;
        return true;
    }

    /**
     * コメント数を追加
     * @param int $addNum
     * @return bool
     */
    public function removeCommentCount($removeNum = 1)
    {
        if ($removeNum < 1 || $removeNum > $this->comment_count) {
            return false;
        }
        $this->comment_count -= $removeNum;
        return true;
    }

    /**
     * いいね数を追加
     * @param int $addNum
     * @return bool
     */
    public function addLikeCount($addNum = 1)
    {
        if ($addNum < 1) {
            return false;
        }
        $this->like_count += $addNum;
        return true;
    }

    /**
     * いいね数を追加
     * @param int $addNum
     * @return bool
     */
    public function removeLikeCount($removeNum = 1)
    {
        if ($removeNum < 1 || $removeNum > $this->like_count) {
            return false;
        }
        $this->like_count -= $removeNum;
        return true;
    }

    /**
     * 件名を取得
     * @return string
     */
    protected function getPrefectureName()
    {
        $prefecture = MPrefecture::findFirst($this->prefecture_id);
        if ($prefecture) {
            return $prefecture->name;
        }
        return '';
    }

    /**
     * エリア名を取得
     * @return string
     */
    protected function getAreaName()
    {
        $area = MArea::findFirst($this->area_id);
        if ($area) {
            return $area->name;
        }
        return '';
    }

    /**
     * 画像URLを取得
     * @return string
     */
    protected function getImageUrl()
    {
        $image = LocalinfoImage::findFirstByIdStrict($this->main_image_id);
        if ($image instanceof LocalinfoImage) {
            return $image->getImageUrl();
        }
        return null;
    }

    /**
     * サムネURLを取得
     * @return string
     */
    protected function getThumbnailUrl()
    {
        $image = LocalinfoImage::findFirstByIdStrict($this->main_image_id);
        if ($image instanceof LocalinfoImage) {
            return $image->getThumbnailUrl();
        }
        return null;
    }

    /**
     * ランダムでn件取得
     * @return resultset
     */
    public static function getRandom($limit, $condition = [])
    {
        // 全件取得すると、using indexできないので、一回idのみ取得
        $params = ['columns' => 'id','limit' => $limit,'order' => 'RAND()'];
        $params['conditions'] = $condition;
        $random = Localinfo::findByParams($params);
        $ids = [];
        foreach ($random as $data) {
            $ids[] = $data->id;
        }
        // 獲得したidで検索
        $condition = ['id in' => $ids];
        return Localinfo::findByParams(['conditions' => $condition]);
    }

    /**
     * 近くのものからランダムでn件取得
     * @return resultset
     */
    public function getNearBy($limit)
    {
        $condition = ['prefecture_id' => $this->prefecture_id];
        return self::getRandom($limit, $condition);
    }
}
