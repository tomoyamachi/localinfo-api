<?php
/**
 * Test\Unit\src\Models\Model
 */
namespace Test\Unit\src\Models\Model;

use Lapi\Models\Model\Like;

/**
 * LikeTest
 */
class LikeTest extends \Test\Unit\TestCase
{

    public function testConstruct()
    {
        $model = new Like();
        $this->assertInstanceOf('Lapi\Models\Model\Like', $model);
    }
}
