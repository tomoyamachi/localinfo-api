<?php
/**
 * Test\Unit\src\Models\Model
 */
namespace Test\Unit\src\Models\Model;

use Lapi\Models\Model\MPrefecture;

/**
 * MPrefectureTest
 */
class MPrefectureTest extends \Test\Unit\TestCase
{

    public function testConstruct()
    {
        $model = new MPrefecture();
        $this->assertInstanceOf('Lapi\Models\Model\MPrefecture', $model);
    }
}
