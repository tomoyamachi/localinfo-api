<?php
namespace Lapi\V1\Controllers;

use \Lapi\Models\Model\Product;
use \Lapi\Models\Model\UAchievement;
use \Lapi\Response\UAchievement as RUAchievement;

use \Lapi\Models\Model\ULottery;
use \Lapi\Response\ULottery as RULottery;

class AccountController extends \Lapi\V1\Controllers\GetUserController
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
