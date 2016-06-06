<?php
/**
 * Test\Unit\src\Models\Model
 */
namespace Test\Unit\src\Models\Model;

use Lapi\Models\Model\LocalinfoImage;

/**
 * LocalinfoImageTest
 */
class LocalinfoImageTest extends \Test\Unit\TestCase
{

    public function testConstruct()
    {
        $model = new LocalinfoImage();
        $this->assertInstanceOf('Lapi\Models\Model\LocalinfoImage', $model);
    }
}
