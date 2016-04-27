<?php
/**
 * Treasure\Models\Model
 */
namespace Treasure\Models\Model;

use \Treasure\Models\Model\Product;
use \Treasure\Models\Model\ULottery;
use \Treasure\Response\Lottery as RLottery;
use \Gcl\Util\Lot;

/**
 * ProductLottery
 */
class ProductLottery extends \Treasure\Models\Model\ProductReferenceAbstract
{
    const LOT_SUCCESS_PERCENTAGE = 30;

    protected $referenceLabel = 'lottery';
    protected static $defaultData = ['id' => null,
                            'status' => parent::STATUS_VALID_NEW,
                            'product_delivery_rate_group_id' => null,
                            'total_limit' => null,
                            'personal_limit' => 1,
                            'relot_span_hour' => 3,
                            'weight' => null,
                            'begin_date' => 'now',
                            'end_date' => 'now',
                            ];

    protected $toolColumnLabels = [
                         'tool_start_end_date_visible' => '表示期間',
                         'label_by_status' => '状態',
                         'tool_delivery_ratio' => '配信比率',
                         'weight' => '当選ウェイト',
                         'tool_current_conversion_degree' => '進捗',
                         ];

    /**
     * ふくびきの抽選
     * @return array
     */
    public static function lot($accountId)
    {
        $result = ['success' => false];

        // まずはふくびきにあたるかの処理
        if (self::passedFirstStep() === false) {
            return $result;
        }

        // そのあと有効なふくびきだけで重み付けし、その中から選ぶ
        $lotted = self::lotFromValid();
        if ($lotted === false) {
            return $result;
        }

        // 当選したものを登録する
        if (ULottery::register($lotted, $accountId)) {
            $result = RLottery::getContent($lotted);
            $result['success'] = true;
        }

        return $result;
    }

    /**
     * 最初の当選
     * @return boolean
     */
    public static function passedFirstStep()
    {
        return true;
        // TODO : 本番では以下のコードを利用する
        //return (rand(0,100) > self::LOT_SUCCESS_PERCENTAGE);
    }

    /**
     * 実際の抽選部分
     * @return \ProductLottery
     */
    public static function lotFromValid()
    {
        $entry = [];
        $lotteries = self::findByParamsInValidTerm(['conditions' => []]);
        foreach ($lotteries as $lottery) {
            if ($lottery->canLot()) {
                $entry[] = ['weight' => $lottery->weight,
                            'lottery' => $lottery];
            }
        }

        $lot = new Lot($entry);
        $result = $lot->choose('weight');
        $lotted = $result['lottery'];
        if ($lotted instanceof self) {
            return $lotted;
        }

        return false;
    }

    /**
     * まだのこりのものがあるかを確認
     * @param void
     * @return boolean
     */
    public function canLot()
    {
        $currentUsed = ULottery::getCountTargetLotteryId($this->id);
        return ($this->total_limit > $currentUsed);
    }


    /**
     * 最大受け渡し個数とすでに渡してしまった個数。
     * @return string
     */
    public function getToolCurrentConversionDegree()
    {
        $currentUsed = ULottery::getCountTargetLotteryId($this->id);
        $rate = floor(($currentUsed * 100)/$this->total_limit);
        return sprintf('%d / %d 個消費 (%d%%)', $currentUsed, $this->total_limit, $rate);
    }
}
