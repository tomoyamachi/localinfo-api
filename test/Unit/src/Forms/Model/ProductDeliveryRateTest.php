<?php
/**
 * Test\Unit\src\Models
 */
namespace Test\Unit\src\Forms;

use Papi\Forms\Model\ProductDeliveryRate;

/**
 * ProductDeliveryRateTest
 */
class ProductDeliveryRateTest extends \Test\Unit\TestCase
{

    public function testConstruct()
    {
        $form = new ProductDeliveryRate();
        $this->assertInstanceOf('Papi\Forms\Model\ProductDeliveryRate', $form);
    }
}
