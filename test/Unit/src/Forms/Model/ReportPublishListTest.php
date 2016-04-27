<?php
/**
 * Test\Unit\src\Models
 */
namespace Test\Unit\src\Forms;

use Treasure\Forms\Model\ReportPublishList;

/**
 * ReportPublishListTest
 */
class ReportPublishListTest extends \Test\Unit\TestCase
{

    public function testConstruct()
    {
        $form = new ReportPublishList();
        $this->assertInstanceOf('Treasure\Forms\Model\ReportPublishList', $form);
    }
}
