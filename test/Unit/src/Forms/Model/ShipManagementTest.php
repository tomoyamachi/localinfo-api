<?php
/**
 * Test\Unit\src\Models
 */
namespace Test\Unit\src\Forms;

use Treasure\Forms\Model\ShipManagement;

/**
 * ShipManagementTest
 */
class ShipManagementTest extends \Test\Unit\TestCase
{

    public function testConstruct()
    {
        $form = new ShipManagement();
        $this->assertInstanceOf('Treasure\Forms\Model\ShipManagement', $form);
    }
}
