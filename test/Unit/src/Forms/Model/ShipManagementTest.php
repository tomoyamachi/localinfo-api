<?php
/**
 * Test\Unit\src\Models
 */
namespace Test\Unit\src\Forms;

use Papi\Forms\Model\ShipManagement;

/**
 * ShipManagementTest
 */
class ShipManagementTest extends \Test\Unit\TestCase
{

    public function testConstruct()
    {
        $form = new ShipManagement();
        $this->assertInstanceOf('Papi\Forms\Model\ShipManagement', $form);
    }
}
