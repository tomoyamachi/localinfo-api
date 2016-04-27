<?php
/**
 * Test\Unit\src\Models\Model
 */
namespace Test\Unit\src\Models\Model;

use Papi\Models\Model\ReportPublishList;

/**
 * ReportPublishListTest
 */
class ReportPublishListTest extends \Test\Unit\TestCase
{

    public function testConstruct()
    {
        $model = new ReportPublishList();
        $this->assertInstanceOf('Papi\Models\Model\ReportPublishList', $model);
    }
}
