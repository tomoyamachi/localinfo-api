<?php
/**
 * Test\Unit\src\Models\Model
 */
namespace Test\Unit\src\Models\Model;

use Treasure\Models\Model\MArea;

/**
 * MAreaTest
 */
class MAreaTest extends \Test\Unit\TestCase
{

    public function testConstruct()
    {
        $model = new MArea();
        $this->assertInstanceOf('Treasure\Models\Model\MArea', $model);
    }
}
