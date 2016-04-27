<?php
namespace Treasure\V1\Controllers;

use \Treasure\Models\Model\Product;
use \Treasure\Models\Model\ShipManagement;
use \Treasure\Response\ShipManagement as RShipManagement;

class ShippingController extends \Treasure\V1\Controllers\GetUserController
{
    /**
     * 商品管理一覧を取得
     */
    public function getAction()
    {
        $params = $this->checkLimitOffsetParameter();
        if ($params instanceof \Gpl\Http\Response) {
            return;
        }

        $conditions = ['account_id' => $this->account['account_id']];

        $params['conditions'] = $conditions;
        $shippings = ShipManagement::find($params);
        $result = RShipManagement::getMultipleContent($shippings);
        return $this->responseValidStatus($result);
    }


    /**
     * ふくびき一覧を取得
     */
    public function getTargetAction()
    {
        $shippingId = $this->dispatcher->getParam('shipping_id');
        $response = $this->checkPositiveInteger($shippingId);
        if ($response !== true) {
            return;
        }

        try {
            $shipping = ShipManagement::findFirstByIdStrict($shippingId);
            $result = RShipManagement::getContent($shipping);
        } catch (\Exception $e) {
            return $this->responseExceptionError($e);
        }

        return $this->responseValidStatus($result);
    }
}
