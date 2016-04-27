<?php
/**
 * Papi\Models\Model
 */
namespace Papi\Models\Model;

use \Papi\Models\ApiConnector;

/**
 * UProductReview
 */
class UProductReview extends \Papi\Models\Model\UserAbstract
{
    /**
     * 作成時のほげほげ
     * @param  array $postData
     * @param array $config
     * @return boolean 成功/失敗
     */
    public function addFirstData($postData, $config)
    {
        $from = false;
        return \Api\Models\Validator::setAndValidatePostData($this, $postData, $config, $from);
    }

    /**
     * レポート画面用に配列でデータを返す
     * @param int $productId
     * @return array
     */
    public static function findToolReportByProductId($productId)
    {
        if (empty($productId)) {
            throw new \Exception("Invalid productId");
        }
        $result = [];

        $conditions = ['product_id' => $productId];
        $reviews = self::findByParams(['conditions' => $conditions]);
        foreach ($reviews as $review) {
            $result[$review->id]['comment'] = $review->comment;
        }
        return $result;
    }

    /**
     * 商品名を取得
     * @param void
     * @return mixed
     */
    public function getProductName()
    {
        $product = Product::findFirstByIdStrict($this->product_id);
        if ($product) {
            return $product->name;
        }
        return null;
    }

    /**
     * アカウント名を取得
     * @param void
     * @return mixed
     */
    public function getAccountName()
    {
        // TODO : 複数件取得する場合はまとめて獲得するほうがいい
        $account = ApiConnector::getAccount($this->account_id);
        if ($account) {
            return $account['nickname'];
        }
        return null;
    }
}
