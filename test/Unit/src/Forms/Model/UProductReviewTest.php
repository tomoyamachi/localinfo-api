<?php
/**
 * Test\Unit\src\Models
 */
namespace Test\Unit\src\Forms;

use Treasure\Forms\Model\UProductReview;

/**
 * UProductReviewTest
 */
class UProductReviewTest extends \Test\Unit\TestCase
{

    public function testConstruct()
    {
        $form = new UProductReview();
        $this->assertInstanceOf('Treasure\Forms\Model\UProductReview', $form);
    }
}
