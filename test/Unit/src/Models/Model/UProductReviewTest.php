<?php
/**
 * Test\Unit\src\Models\Model
 */
namespace Test\Unit\src\Models\Model;

use Treasure\Models\Model\UProductReview;

/**
 * UProductReviewTest
 */
class UProductReviewTest extends \Test\Unit\TestCase
{

    public function testConstruct()
    {
        $model = new UProductReview();
        $this->assertInstanceOf('Treasure\Models\Model\UProductReview', $model);
    }
}
