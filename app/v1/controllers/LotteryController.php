<?php
namespace Papi\V1\Controllers;

use \Papi\Models\Model\Product;
use \Papi\Models\Model\ProductLottery as Lottery;
use \Papi\Response\Lottery as RLottery;

class LotteryController extends \Papi\V1\Controllers\GetUserController
{
    /**
     * 全データを返却
     */
    public function getAction()
    {
        $params = $this->checkLimitOffsetParameter();
        if ($params instanceof \Gpl\Http\Response) {
            return;
        }

        // 引数に問題がなければ検索
        $lotterys = Lottery::find($params);
        $result = RLottery::getMultipleContent($lotterys);
        return $this->responseValidStatus($result);
    }

    /**
     * 個別のデータを返却
     */
    public function getTargetAction()
    {
        $lotteryId = $this->dispatcher->getParam('lottery_id');
        $response = $this->checkPositiveInteger($lotteryId);
        if ($response !== true) {
            return;
        }

        try {
            $lottery = Lottery::findFirst($lotteryId);
            $result = RLottery::getContent($lottery);
        } catch (\Exception $e) {
            return $this->responseExceptionError($e);
        }

        return $this->responseValidStatus($result);
    }

    /**
     * ふくびきの抽選
     */
    public function lotAction()
    {
        $result = Lottery::lot($this->account['account_id']);
        return $this->responseValidStatus($result);
    }
}
