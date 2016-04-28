<?php
/**
 * Test\Unit\src\Models
 */
namespace Test\Unit\src\Forms;

use Treasure\Forms\Model\ReportSegment;

/**
 * ReportSegmentTest
 */
class ReportSegmentTest extends \Test\Unit\TestCase
{

    public function testConstruct()
    {
        $form = new ReportSegment();
        $this->assertInstanceOf('Treasure\Forms\Model\ReportSegment', $form);
    }
}
