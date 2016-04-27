<?php
/**
 * Test\Unit\src\Models\Model
 */
namespace Test\Unit\src\Models\Model;

use Treasure\Models\Model\ProductLottery;

/**
 * ProductLotteryTest
 */
class ProductLotteryTest extends \Test\Unit\TestCase
{

    public function testConstruct()
    {
        $model = new ProductLottery();
        $this->assertInstanceOf('Treasure\Models\Model\ProductLottery', $model);
    }
}
