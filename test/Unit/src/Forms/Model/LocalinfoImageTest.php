<?php
/**
 * Test\Unit\src\Models
 */
namespace Test\Unit\src\Forms;

use Lapi\Forms\Model\LocalinfoImage;

/**
 * LocalinfoImageTest
 */
class LocalinfoImageTest extends \Test\Unit\TestCase
{

    public function testConstruct()
    {
        $form = new LocalinfoImage();
        $this->assertInstanceOf('Lapi\Forms\Model\LocalinfoImage', $form);
    }
}
