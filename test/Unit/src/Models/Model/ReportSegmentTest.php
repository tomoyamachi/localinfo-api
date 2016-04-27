<?php
/**
 * Test\Unit\src\Models\Model
 */
namespace Test\Unit\src\Models\Model;

use Treasure\Models\Model\ReportSegment;

/**
 * ReportSegmentTest
 */
class ReportSegmentTest extends \Test\Unit\TestCase
{

    public function testConstruct()
    {
        $model = new ReportSegment();
        $this->assertInstanceOf('Treasure\Models\Model\ReportSegment', $model);
    }
}
