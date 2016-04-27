<?php
/**
 * Test\Unit\src\Models
 */
namespace Test\Unit\src\Forms;

use Papi\Forms\Model\UProductReview;

/**
 * UProductReviewTest
 */
class UProductReviewTest extends \Test\Unit\TestCase
{

    public function testConstruct()
    {
        $form = new UProductReview();
        $this->assertInstanceOf('Papi\Forms\Model\UProductReview', $form);
    }
}
