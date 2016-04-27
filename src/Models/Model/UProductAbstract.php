<?php
/**
 * Papi\Models\Model
 */
namespace Papi\Models\Model;

use \Papi\Models\Model\Product;
use \Papi\Models\Model\ShipManagement;

/**
 * 各アカウントの商品情報の抽象クラス
 */
class UProductAbstract extends \Papi\Models\Model\UserAbstract
{
    protected $productIdCache = false;

    /**
     * 商品IDを逆引き
     * @return mixed
     */
    public function getProductId()
    {
        if ($this->productIdCache !== false) {
            return $this->productIdCache;
        }

        $this->productIdCache = null;

        // 対象のモデルから指定されたIDで検索
        $namespace = '\\Papi\\Models\\Model\\Product'.ucwords($this->reference_type);
        $column = 'product_'.$this->reference_type.'_id';
        $conditions = ['id' => $this->$column];
        $result = $namespace::findFirstByParams(['conditions' => $conditions]);

        // 想定したものと違う場合はnullを返す
        if ($result && $result->id == $this->$column) {
            $this->productIdCache = $result->product_id;
        }
        return $this->productIdCache;
    }

    /**
     * 商品名を取得
     * @param void
     * @return mixed
     */
    public function getProductName()
    {
        $product = Product::findFirstByIdStrict($this->getProductId());
        if ($product instanceof Product) {
            return $product->name;
        }

        return null;
    }

    /**
     * 発送IDを取得
     * @param void
     * @return mixed
     */
    public function getShippingId()
    {
        $conditions = ['reference_type' => $this->reference_type,
                       'u_reference_id' => $this->id];

        $shipping = ShipManagement::findFirstByParams(['condition' => $conditions]);
        if ($shipping instanceof ShipManagement) {
            return $shipping->id;
        }
        return null;
    }
}
