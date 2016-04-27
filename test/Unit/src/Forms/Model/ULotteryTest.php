<?php
/**
 * Test\Unit\src\Models
 */
namespace Test\Unit\src\Forms;

use Papi\Forms\Model\ULottery;

/**
 * ULotteryTest
 */
class ULotteryTest extends \Test\Unit\TestCase
{

    public function testConstruct()
    {
        $form = new ULottery();
        $this->assertInstanceOf('Papi\Forms\Model\ULottery', $form);
    }
}
