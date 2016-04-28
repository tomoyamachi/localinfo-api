<?php
/**
 * Test\Unit\src\Models
 */
namespace Test\Unit\src\Forms;

use Treasure\Forms\Model\ProductLottery;

/**
 * ProductLotteryTest
 */
class ProductLotteryTest extends \Test\Unit\TestCase
{

    public function testConstruct()
    {
        $form = new ProductLottery();
        $this->assertInstanceOf('Treasure\Forms\Model\ProductLottery', $form);
    }
}
