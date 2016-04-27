<?php
namespace Papi\V1\Controllers;

use \Papi\Models\Model\Product;
use \Papi\Response\Product as RProduct;

class ProductController extends \Api\Controllers\Api\AbstractController
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
        $products = Product::find($params);
        $result = RProduct::getMultipleContent($products);
        return $this->responseValidStatus($result);
    }

    /**
     * 個別のデータを返却
     */
    public function getTargetAction()
    {
        $productId = $this->dispatcher->getParam('product_id');
        $response = $this->checkPositiveInteger($productId);
        if ($response !== true) {
            return;
        }

        try {
            $product = Product::findFirst($productId);
            $result = RProduct::getContent($product);
        } catch (\Exception $e) {
            return $this->responseExceptionError($e);
        }

        return $this->responseValidStatus($result);
    }
}
