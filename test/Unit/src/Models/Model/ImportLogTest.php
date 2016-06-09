<?php
/**
 * Test\Unit\src\Models\Model
 */
namespace Test\Unit\src\Models\Model;

use Lapi\Models\Model\ImportLog;

/**
 * ImportLogTest
 */
class ImportLogTest extends \Test\Unit\TestCase
{

    public function testConstruct()
    {
        $model = new ImportLog();
        $this->assertInstanceOf('Lapi\Models\Model\ImportLog', $model);
    }
}
