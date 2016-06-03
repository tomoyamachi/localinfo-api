<?php
/**
 * Test\Unit\src\Models
 */
namespace Test\Unit\src\Forms;

use Lapi\Forms\Model\MArea;

/**
 * MAreaTest
 */
class MAreaTest extends \Test\Unit\TestCase
{

    public function testConstruct()
    {
        $form = new MArea();
        $this->assertInstanceOf('Lapi\Forms\Model\MArea', $form);
    }
}
