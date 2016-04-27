<?php
/**
 * Test\Unit\src\Models\Model
 */
namespace Test\Unit\src\Models\Model;

use Treasure\Models\Model\ShipManagement;

/**
 * ShipManagementTest
 */
class ShipManagementTest extends \Test\Unit\TestCase
{

    public function testConstruct()
    {
        $model = new ShipManagement();
        $this->assertInstanceOf('Treasure\Models\Model\ShipManagement', $model);
    }
}
