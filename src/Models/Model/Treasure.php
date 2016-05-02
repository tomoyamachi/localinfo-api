<?php
/**
 * Treasure\Models\Model
 */
namespace Treasure\Models\Model;

use Treasure\Models\Validator as OwnValidator;

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
                                     'comment_count' => 0,
                                     'like_count' => 0,
                                     'comment' => null,
                                     'image' => null,
                                     'thumbnail' => null,
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
     * 投稿者名を取得
     * @return string
     */
    protected function getAccountName()
    {
        return 'HOGESampleName';
    }


    /**
     * 件名を取得
     * @return string
     */
    protected function getPrefectureName()
    {
        return 'HOGEPREFEC';
    }

    /**
     * エリア名を取得
     * @return string
     */
    protected function getAreaName()
    {
        return 'HOGEAREA';
    }

    /**
     * 画像URLを取得
     * @return string
     */
    protected function getImageUrl()
    {
        if ($this->image) {
            $config = require APP_DIR.'/v1/config/config.d/config.php';
            $imageDomain = $config[APPLICATION_ENV]['image_domain'];
            return $imageDomain.$this->image;
        }
        return '';
    }

    /**
     * サムネURLを取得
     * @return string
     */
    protected function getThumbnailUrl()
    {
        if ($this->image) {
            $config = require APP_DIR.'/v1/config/config.d/config.php';
            $imageDomain = $config[APPLICATION_ENV]['image_domain'];
            return $imageDomain.$this->thumbnail;
        }
        return '';
    }
}