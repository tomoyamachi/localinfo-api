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
        $treasureModel = Treasure::getInstance();
        $treasures = $treasureModel->findStatusValid($params);


        $result = RTreasure::getMultipleContent($treasures);
        $params['result'] = $result;
        $params['count'] = count($treasures);

        // 総件数まで必要ならtotalを付加
        $withTotal = $this->request->getQuery('total');
        if ($withTotal == '1') {
            $params['total'] = $treasureModel->getTotalStatusValid($params);
        }

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
            $treasureModel = Treasure::getInstance();
            $treasure = $treasureModel->findFirstById($treasureId);
            $result = RTreasure::getContent($treasure);
        } catch (\Exception $e) {
            return $this->responseExceptionError($e);
        }

        return $this->responseValidStatus($result);
    }
}
