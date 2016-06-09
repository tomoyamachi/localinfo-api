<?php
namespace Lapi\V1\Controllers;

use \Lapi\Models\Model\Localinfo;
use \Lapi\Response\Localinfo as RLocalinfo;

class GetrandomController extends \Api\Controllers\Api\AbstractController
{
    /**
     * 対象のレビューを取得
     */
    public function getLocalinfoAction()
    {
        $limit = $this->request->getQuery('limit', null, 10);
        // TODO : あとでテストを書く
        $this->checkPositiveInteger($limit);

        // 引数に問題がなければ検索
        $localinfos = Localinfo::getRandom($limit);
        $result = RLocalinfo::getMultipleContent($localinfos);
        $params['limit'] = $limit;
        $params['result'] = $result;
        $params['count'] = count($localinfos);
        return $this->responseValidStatus($params);
    }


    /**
     * 対象の県のレビューを取得
     */
    public function getNearLocalinfoAction()
    {
        $localinfoId = $this->dispatcher->getParam('localinfo_id');
        $limit = $this->request->getQuery('limit', null, 10);
        // TODO : あとでテストを書く
        $this->checkPositiveInteger($limit);
        $this->checkPositiveInteger($localinfoId);

        $localinfo = Localinfo::findFirst($localinfoId);

        $localinfos = $localinfo->getNearBy($limit);
        $result = RLocalinfo::getMultipleContent($localinfos);
        $params['limit'] = $limit;
        $params['result'] = $result;
        $params['count'] = count($localinfos);
        return $this->responseValidStatus($params);
    }


    /**
     * フィルタリング
     * @param  $attribute
     * @return Response
     */
    private function getTargetAttributes($attribute)
    {
        $params = $this->checkLimitOffsetParameter();
        if ($params instanceof \Gpl\Http\Response) {
            return;
        }

        // IDに問題がないか確認
        $attributeId = $this->dispatcher->getParam($attribute.'_id');
        $response = $this->checkPositiveInteger($attributeId);
        if ($response !== true) {
            return $response;
        }

        // 引数に問題がなければ検索
        $localinfoModel = Localinfo::getInstance();
        $params['conditions'] = [$attribute.'_id' => $attributeId];
        $localinfos = $localinfoModel->findStatusValid($params);

        $result = RLocalinfo::getMultipleContent($localinfos);
        $params['result'] = $result;
        $params['count'] = count($localinfos);

        // 総件数まで必要ならtotalを付加
        $withTotal = $this->request->getQuery('total');
        if ($withTotal == '1') {
            $params['total'] = $localinfoModel->getTotalStatusValid($params);
        }

        return $this->responseValidStatus($params);
    }

}