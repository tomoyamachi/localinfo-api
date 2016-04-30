<?php
namespace Treasure\V1\Controllers;

use \Treasure\Models\Model\MArea as Area;
use \Treasure\Response\Area as RArea;

class AreaController extends \Api\Controllers\Api\AbstractController
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

        // IDに問題がないか確認
        $prefectureId = $this->dispatcher->getParam('prefecture_id');
        $response = $this->checkPositiveInteger($prefectureId);
        if ($response !== true) {
            return $response;
        }

        $params['conditions'] = ['prefecture_id' => $prefectureId];
        $areas = Area::findByParams($params);

        $result = RArea::getMultipleContent($areas);
        $params['result'] = $result;
        $params['count'] = count($areas);

        // 総件数まで必要ならtotalを付加
        $withTotal = $this->request->getQuery('total');
        if ($withTotal == '1') {
            $params['total'] = Area::count();
        }

        return $this->responseValidStatus($params);
    }

    /**
     * 個別のデータを返却
     */
    public function getTargetAction()
    {
        $areaId = $this->dispatcher->getParam('area_id');
        $response = $this->checkPositiveInteger($areaId);
        if ($response !== true) {
            return;
        }

        try {
            $area = Area::findFirst($areaId);
            $result = RArea::getContent($area);
        } catch (\Exception $e) {
            return $this->responseExceptionError($e);
        }

        return $this->responseValidStatus($result);
    }
}
