<?php
/**
 * Test\Unit\src\Models\Model
 */
namespace Test\Unit\src\Models\Model;

use Treasure\Models\Model\SalesHistory;

/**
 * SalesHistoryTest
 */
class SalesHistoryTest extends \Test\Unit\TestCase
{

    public function testConstruct()
    {
        $model = new SalesHistory();
        $this->assertInstanceOf('Treasure\Models\Model\SalesHistory', $model);
    }
}
