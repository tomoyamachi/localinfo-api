<?php
/**
 * Test\Unit\src\Models\Model
 */
namespace Test\Unit\src\Models\Model;

use Localinfo\Models\Model\ImportLog;

/**
 * ImportLogTest
 */
class ImportLogTest extends \Test\Unit\TestCase
{

    public function testConstruct()
    {
        $model = new ImportLog();
        $this->assertInstanceOf('Localinfo\Models\Model\ImportLog', $model);
    }
}
