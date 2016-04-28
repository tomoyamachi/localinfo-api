<?php
/**
 * Test\Unit\src\Models
 */
namespace Test\Unit\src\Forms;

use Treasure\Forms\Model\Treasure;

/**
 * TreasureTest
 */
class TreasureTest extends \Test\Unit\TestCase
{

    public function testConstruct()
    {
        $form = new Treasure();
        $this->assertInstanceOf('Treasure\Forms\Model\Treasure', $form);
    }
}
