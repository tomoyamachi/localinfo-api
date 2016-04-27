<?php
/**
 * Test\Unit\src\Models\Model
 */
namespace Test\Unit\src\Models\Model;

use Treasure\Models\Model\ReportPublishList;

/**
 * ReportPublishListTest
 */
class ReportPublishListTest extends \Test\Unit\TestCase
{

    public function testConstruct()
    {
        $model = new ReportPublishList();
        $this->assertInstanceOf('Treasure\Models\Model\ReportPublishList', $model);
    }
}
