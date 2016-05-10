<?php
namespace Treasure\V1\Controllers;

use \Treasure\Models\Model\MPrefecture as Prefecture;
use \Treasure\Response\Prefecture as RPrefecture;

class PrefectureController extends \Api\Controllers\Api\AbstractController
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
        //$prefectureModel = Prefecture::getInstance();
        $prefectures = Prefecture::find($params);
        $result = RPrefecture::getMultipleContent($prefectures);
        $params['result'] = $result;
        $params['count'] = count($prefectures);

        // 総件数まで必要ならtotalを付加
        $withTotal = $this->request->getQuery('total');
        if ($withTotal == '1') {
            $params['total'] = Prefecture::count();
        }

        return $this->responseValidStatus($params);
    }

    /**
     * 個別のデータを返却
     */
    public function getTargetAction()
    {
        $prefectureId = $this->dispatcher->getParam('prefecture_id');
        $response = $this->checkPositiveInteger($prefectureId);
        if ($response !== true) {
            return;
        }

        try {
            $prefecture = Prefecture::findFirst($prefectureId);
            $result = RPrefecture::getContent($prefecture);
        } catch (\Exception $e) {
            return $this->responseExceptionError($e);
        }

        return $this->responseValidStatus($result);
    }
}
