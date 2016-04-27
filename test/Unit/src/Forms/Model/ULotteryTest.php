<?php
/**
 * Test\Unit\src\Models
 */
namespace Test\Unit\src\Forms;

use Treasure\Forms\Model\ULottery;

/**
 * ULotteryTest
 */
class ULotteryTest extends \Test\Unit\TestCase
{

    public function testConstruct()
    {
        $form = new ULottery();
        $this->assertInstanceOf('Treasure\Forms\Model\ULottery', $form);
    }
}
