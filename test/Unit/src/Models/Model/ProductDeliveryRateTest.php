<?php
/**
 * Test\Unit\src\Models\Model
 */
namespace Test\Unit\src\Models\Model;

use Treasure\Models\Model\ProductDeliveryRate;

/**
 * ProductDeliveryRateTest
 */
class ProductDeliveryRateTest extends \Test\Unit\TestCase
{

    public function testConstruct()
    {
        $model = new ProductDeliveryRate();
        $this->assertInstanceOf('Treasure\Models\Model\ProductDeliveryRate', $model);
    }
}
