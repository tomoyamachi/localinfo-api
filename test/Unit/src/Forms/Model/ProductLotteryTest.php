<?php
/**
 * Test\Unit\src\Models
 */
namespace Test\Unit\src\Forms;

use Papi\Forms\Model\ProductLottery;

/**
 * ProductLotteryTest
 */
class ProductLotteryTest extends \Test\Unit\TestCase
{

    public function testConstruct()
    {
        $form = new ProductLottery();
        $this->assertInstanceOf('Papi\Forms\Model\ProductLottery', $form);
    }
}
