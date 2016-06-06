<?php
/**
 * Test\Unit\src\Models\Model
 */
namespace Test\Unit\src\Models\Model;

use Localinfo\Models\Model\LocalinfoImage;

/**
 * LocalinfoImageTest
 */
class LocalinfoImageTest extends \Test\Unit\TestCase
{

    public function testConstruct()
    {
        $model = new LocalinfoImage();
        $this->assertInstanceOf('Localinfo\Models\Model\LocalinfoImage', $model);
    }
}
