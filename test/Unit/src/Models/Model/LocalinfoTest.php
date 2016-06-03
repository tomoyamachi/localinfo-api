<?php
/**
 * Test\Unit\src\Models\Model
 */
namespace Test\Unit\src\Models\Model;

use Lapi\Models\Model\Localinfo;

/**
 * LocalinfoTest
 */
class LocalinfoTest extends \Test\Unit\TestCase
{

    public function testConstruct()
    {
        $model = new Localinfo();
        $this->assertInstanceOf('Lapi\Models\Model\Localinfo', $model);
    }
}
