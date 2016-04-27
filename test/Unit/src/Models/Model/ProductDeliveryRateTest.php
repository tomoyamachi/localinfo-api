<?php
/**
 * Test\Unit\src\Models\Model
 */
namespace Test\Unit\src\Models\Model;

use Papi\Models\Model\ProductDeliveryRate;

/**
 * ProductDeliveryRateTest
 */
class ProductDeliveryRateTest extends \Test\Unit\TestCase
{

    public function testConstruct()
    {
        $model = new ProductDeliveryRate();
        $this->assertInstanceOf('Papi\Models\Model\ProductDeliveryRate', $model);
    }
}
