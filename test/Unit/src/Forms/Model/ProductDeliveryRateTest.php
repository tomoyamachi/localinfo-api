<?php
/**
 * Test\Unit\src\Models
 */
namespace Test\Unit\src\Forms;

use Treasure\Forms\Model\ProductDeliveryRate;

/**
 * ProductDeliveryRateTest
 */
class ProductDeliveryRateTest extends \Test\Unit\TestCase
{

    public function testConstruct()
    {
        $form = new ProductDeliveryRate();
        $this->assertInstanceOf('Treasure\Forms\Model\ProductDeliveryRate', $form);
    }
}
