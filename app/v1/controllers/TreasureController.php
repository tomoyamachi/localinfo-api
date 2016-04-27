<?php
namespace Treasure\V1\Controllers;

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
        $result = [['id' => 1, 'name' => 'hoge']];
        /* $treasures = Treasure::find($params); */
        /* $result = RTreasure::getMultipleContent($treasures); */
        return $this->responseValidStatus($result);
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
        $result = ['id' => 1, 'name' => 'hoge'];

        /* try { */
        /*     $treasure = Treasure::findFirst($treasureId); */
        /*     $result = RTreasure::getContent($treasure); */
        /* } catch (\Exception $e) { */
        /*     return $this->responseExceptionError($e); */
        /* } */

        return $this->responseValidStatus($result);
    }
}
