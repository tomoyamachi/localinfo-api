<?php
/**
 * Test\Unit\src\Models
 */
namespace Test\Unit\src\Forms;

use Treasure\Forms\Model\MArea;

/**
 * MAreaTest
 */
class MAreaTest extends \Test\Unit\TestCase
{

    public function testConstruct()
    {
        $form = new MArea();
        $this->assertInstanceOf('Treasure\Forms\Model\MArea', $form);
    }
}
