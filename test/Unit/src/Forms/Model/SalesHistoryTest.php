<?php
/**
 * Test\Unit\src\Models
 */
namespace Test\Unit\src\Forms;

use Papi\Forms\Model\SalesHistory;

/**
 * SalesHistoryTest
 */
class SalesHistoryTest extends \Test\Unit\TestCase
{

    public function testConstruct()
    {
        $form = new SalesHistory();
        $this->assertInstanceOf('Papi\Forms\Model\SalesHistory', $form);
    }
}
