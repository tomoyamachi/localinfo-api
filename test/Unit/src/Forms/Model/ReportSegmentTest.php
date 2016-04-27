<?php
/**
 * Test\Unit\src\Models
 */
namespace Test\Unit\src\Forms;

use Papi\Forms\Model\ReportSegment;

/**
 * ReportSegmentTest
 */
class ReportSegmentTest extends \Test\Unit\TestCase
{

    public function testConstruct()
    {
        $form = new ReportSegment();
        $this->assertInstanceOf('Papi\Forms\Model\ReportSegment', $form);
    }
}
