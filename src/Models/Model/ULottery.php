<?php
/**
 * Papi\Models\Model
 */
namespace Papi\Models\Model;

use \Papi\Models\Model\ProductLottery;

/**
 * ULottery
 *
 * @SuppressWarnings(PHPMD)
 */
class ULottery extends \Papi\Models\Model\UProductAbstract
{
    const STATUS_INIT = 'init';
    const STATUS_VALID = 'valid';

    // ShipManagementのreference_typeカラムと同じproperty名で取得できるようcamelcaseにしている
    protected $reference_type = 'lottery';
    protected $productIdCache = false;

    /**
     * 対象のproduct_lottery_idですでに応募済みの個数を返す
     * @param int $productLotteryId
     * @return int
     */
    public static function getCountTargetLotteryId($productLotteryId)
    {
        $conditions = ['product_lottery_id' => $productLotteryId];
        $result = self::findFirstByParams(['conditions' => $conditions,
                                           'columns' => ['count' => 'count(*)']]);
        if ($result) {
            return $result->count;
        }
        return 0;
    }

    /**
     * 登録する
     * @param ProductLottery $lottery
     * @param int $accountId
     * @return boolean
     */
    public static function register($lottery, $accountId)
    {
        $ulottery = new self();
        $ulottery->set('account_id', $accountId);
        $ulottery->set('status', self::STATUS_INIT);
        $ulottery->set('product_lottery_id', $lottery->id);

        $relotPlus = "+ ".$lottery->relot_span_hour." hour";
        $ulottery->set('relot_date', date('Y-m-d H:i:s', strtotime($relotPlus)));
        return $ulottery->save();
    }
}
