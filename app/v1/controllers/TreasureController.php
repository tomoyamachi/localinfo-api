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
        $data = ['id' => 1, 'name' => 'hoge', 'posted_id' => 1, 'posted_name' => 'fuga', 'prefecture_id' => 1, 'prefecture_name' => 'ほげ', 'area_id' => 1, 'area_name' => 'fuga', 'comment' => 'jojojo', 'image_url' => 'http://image', 'created_at' => '20', 'updated_at' => '2093'];
        $result = ['count' => 10,'page' => 1, 'offset' => 10,
                   'result' => [$data]];
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

        $result = ['id' => 1, 'name' => 'hoge', 'posted_id' => 1, 'posted_name' => 'fuga', 'prefecture_id' => 1, 'prefecture_name' => 'ほげ', 'area_id' => 1, 'area_name' => 'fuga', 'comment' => 'jojojo', 'image_url' => 'http://image', 'created_at' => '20', 'updated_at' => '2093'];

        /* try { */
        /*     $treasure = Treasure::findFirst($treasureId); */
        /*     $result = RTreasure::getContent($treasure); */
        /* } catch (\Exception $e) { */
        /*     return $this->responseExceptionError($e); */
        /* } */

        return $this->responseValidStatus($result);
    }
}
