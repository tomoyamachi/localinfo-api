<?php
/**
 * Test\Unit\src\Models
 */
namespace Test\Unit\src\Forms;

use Lapi\Forms\Model\Localinfo;

/**
 * LocalinfoTest
 */
class LocalinfoTest extends \Test\Unit\TestCase
{

    public function testConstruct()
    {
        $form = new Localinfo();
        $this->assertInstanceOf('Lapi\Forms\Model\Localinfo', $form);
    }
}
