<?php
/**
 * Test\Unit\src\Models\Model
 */
namespace Test\Unit\src\Models\Model;

use Papi\Models\Model\ConversionReport;

/**
 * ConversionReportTest
 */
class ConversionReportTest extends \Test\Unit\TestCase
{

    public function testConstruct()
    {
        $model = new ConversionReport();
        $this->assertInstanceOf('Papi\Models\Model\ConversionReport', $model);
    }
}
