<?php
/**
 * Test\Unit\src\Models
 */
namespace Test\Unit\src\Forms;

use Lapi\Forms\Model\ImportLog;

/**
 * ImportLogTest
 */
class ImportLogTest extends \Test\Unit\TestCase
{

    public function testConstruct()
    {
        $form = new ImportLog();
        $this->assertInstanceOf('Lapi\Forms\Model\ImportLog', $form);
    }
}
