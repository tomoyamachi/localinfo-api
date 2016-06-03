<?php
/**
 * Test\Unit\src\Models\Model
 */
namespace Test\Unit\src\Models\Model;

use Lapi\Models\Model\Treasure;

/**
 * TreasureTest
 */
class TreasureTest extends \Test\Unit\TestCase
{

    public function testConstruct()
    {
        $model = new Treasure();
        $this->assertInstanceOf('Lapi\Models\Model\Treasure', $model);
    }
}
