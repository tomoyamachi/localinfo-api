<?php
/**
 * Test\Unit\src\Models\Model
 */
namespace Test\Unit\src\Models\Model;

use Treasure\Models\Model\ULottery;

/**
 * ULotteryTest
 */
class ULotteryTest extends \Test\Unit\TestCase
{

    public function testConstruct()
    {
        $model = new ULottery();
        $this->assertInstanceOf('Treasure\Models\Model\ULottery', $model);
    }
}
