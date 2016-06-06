<?php
/**
 * Test\Unit\src\Models
 */
namespace Test\Unit\src\Forms;

use Localinfo\Forms\Model\LocalinfoImage;

/**
 * LocalinfoImageTest
 */
class LocalinfoImageTest extends \Test\Unit\TestCase
{

    public function testConstruct()
    {
        $form = new LocalinfoImage();
        $this->assertInstanceOf('Localinfo\Forms\Model\LocalinfoImage', $form);
    }
}
