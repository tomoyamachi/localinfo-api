<?php
/**
 * Test\Unit\src\Models
 */
namespace Test\Unit\src\Forms;

use Papi\Forms\Model\ConversionReport;

/**
 * ConversionReportTest
 */
class ConversionReportTest extends \Test\Unit\TestCase
{

    public function testConstruct()
    {
        $form = new ConversionReport();
        $this->assertInstanceOf('Papi\Forms\Model\ConversionReport', $form);
    }
}
