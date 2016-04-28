<?php
/**
 * Test\Unit\src\Models
 */
namespace Test\Unit\src\Forms;

use Treasure\Forms\Model\SalesHistory;

/**
 * SalesHistoryTest
 */
class SalesHistoryTest extends \Test\Unit\TestCase
{

    public function testConstruct()
    {
        $form = new SalesHistory();
        $this->assertInstanceOf('Treasure\Forms\Model\SalesHistory', $form);
    }
}
