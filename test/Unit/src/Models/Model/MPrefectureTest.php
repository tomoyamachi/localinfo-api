<?php
/**
 * Test\Unit\src\Models\Model
 */
namespace Test\Unit\src\Models\Model;

use Treasure\Models\Model\MPrefecture;

/**
 * MPrefectureTest
 */
class MPrefectureTest extends \Test\Unit\TestCase
{

    public function testConstruct()
    {
        $model = new MPrefecture();
        $this->assertInstanceOf('Treasure\Models\Model\MPrefecture', $model);
    }
}
