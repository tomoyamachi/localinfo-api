<?php
namespace Treasure\V1\Controllers;

use \Treasure\Models\Model\Treasure;
use \Treasure\Response\Treasure as RTreasure;

class TreasureController extends \Api\Controllers\Api\AbstractController
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
        //TODO : 状態がvalidのものを検索できるように
        $treasures = Treasure::find($params);
        $total = 100;

        $result = RTreasure::getMultipleContent($treasures);
        $params['result'] = $result;
        $params['count'] = count($treasures);
        $params['total'] = $total;
        return $this->responseValidStatus($params);
    }

    /**
     * 個別のデータを返却
     */
    public function getTargetAction()
    {
        $treasureId = $this->dispatcher->getParam('treasure_id');
        $response = $this->checkPositiveInteger($treasureId);
        if ($response !== true) {
            return;
        }


        try {
            $treasure = Treasure::findFirst($treasureId);
            $result = RTreasure::getContent($treasure);
        } catch (\Exception $e) {
            return $this->responseExceptionError($e);
        }

        return $this->responseValidStatus($result);
    }
}
