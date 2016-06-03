<?php
/**
 * Test\Unit\src\Models
 */
namespace Test\Unit\src\Forms;

use Lapi\Forms\Model\MPrefecture;

/**
 * MPrefectureTest
 */
class MPrefectureTest extends \Test\Unit\TestCase
{

    public function testConstruct()
    {
        $form = new MPrefecture();
        $this->assertInstanceOf('Lapi\Forms\Model\MPrefecture', $form);
    }
}
