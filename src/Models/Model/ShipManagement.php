<?php
/**
 * Papi\Models\Model
 */
namespace Papi\Models\Model;

/**
 * ShipManagement
 */
class ShipManagement extends \Papi\Models\Model\UProductAbstract
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
        $conditions = ['id' => $this->reference_id];
        $result = $namespace::findFirstByParams(['conditions' => $conditions]);

        // 想定したものと違う場合はnullを返す
        if ($result && $result->id == $this->reference_id) {
            $this->productIdCache = $result->product_id;
        }
        return $this->productIdCache;
    }
}
