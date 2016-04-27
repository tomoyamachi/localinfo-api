<?php
namespace Treasure\V1\Controllers;

use \Treasure\Models\Model\Product;
use \Treasure\Models\Model\UAchievement;
use \Treasure\Response\UAchievement as RUAchievement;

use \Treasure\Models\Model\ULottery;
use \Treasure\Response\ULottery as RULottery;

class AccountController extends \Treasure\V1\Controllers\GetUserController
{
    /**
     * 商品管理一覧を取得
     */
    public function getAchievementsAction()
    {
        $params = $this->checkLimitOffsetParameter();
        if ($params instanceof \Gpl\Http\Response) {
            return;
        }

        $conditions = ['account_id' => $this->account['account_id']];
        $params['conditions'] = $conditions;
        $uachievements = UAchievement::findByParams($params);

        $result = RUAchievement::getMultipleContent($uachievements);
        return $this->responseValidStatus($result);
    }


    /**
     * ふくびき一覧を取得
     */
    public function getLotteriesAction()
    {

        $params = $this->checkLimitOffsetParameter();
        if ($params instanceof \Gpl\Http\Response) {
            return;
        }

        $conditions = ['account_id' => $this->account['account_id']];
        $params['conditions'] = $conditions;
        $ulotteries = ULottery::findByParams($params);

        $result = RULottery::getMultipleContent($ulotteries);
        return $this->responseValidStatus($result);

    }
}
