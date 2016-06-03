<?php
/**
 * Test\Unit\src\Models
 */
namespace Test\Unit\src\Forms;

use Lapi\Forms\Model\Treasure;

/**
 * TreasureTest
 */
class TreasureTest extends \Test\Unit\TestCase
{

    public function testConstruct()
    {
        $form = new Treasure();
        $this->assertInstanceOf('Lapi\Forms\Model\Treasure', $form);
    }
}
