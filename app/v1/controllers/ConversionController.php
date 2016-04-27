<?php
namespace Papi\V1\Controllers;

use \Papi\Models\Model\Product;
use \Papi\Models\Model\ProductConversion as Conversion;
use \Papi\Response\Conversion as RConversion;

class ConversionController extends \Api\Controllers\Api\AbstractController
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
        $conversions = Conversion::find($params);
        $result = RConversion::getMultipleContent($conversions);
        return $this->responseValidStatus($result);
    }

    /**
     * 個別のデータを返却
     */
    public function getTargetAction()
    {
        $conversionId = $this->dispatcher->getParam('conversion_id');
        $response = $this->checkPositiveInteger($conversionId);
        if ($response !== true) {
            return;
        }

        try {
            $conversion = Conversion::findFirst($conversionId);
            $result = RConversion::getContent($conversion);
        } catch (\Exception $e) {
            return $this->responseExceptionError($e);
        }

        return $this->responseValidStatus($result);
    }

    /**
     * コンバージョン追加
     */
    public function reachAction()
    {
        $conversionId = $this->dispatcher->getParam('conversion_id');
        $response = $this->checkPositiveInteger($conversionId);
        if ($response !== true) {
            return;
        }
        $tag = $this->dispatcher->getParam('tag');

        $conversion = Conversion::findFirst($conversionId);
        $success = $conversion->reach($tag);

        $result = RConversion::getContent($conversion);
        $result['success'] = $success;
        return $this->responseValidStatus($result);
    }
}
