<?php
/**
 * Test\Unit\src\Models\Model
 */
namespace Test\Unit\src\Models\Model;

use Papi\Models\Model\ShipManagement;

/**
 * ShipManagementTest
 */
class ShipManagementTest extends \Test\Unit\TestCase
{

    public function testConstruct()
    {
        $model = new ShipManagement();
        $this->assertInstanceOf('Papi\Models\Model\ShipManagement', $model);
    }
}
