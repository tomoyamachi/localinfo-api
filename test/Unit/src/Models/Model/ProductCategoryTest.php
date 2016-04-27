<?php
/**
 * Test\Unit\src\Models\Model
 */
namespace Test\Unit\src\Models\Model;

use Treasure\Models\Model\ProductCategory;

/**
 * ProductCategoryTest
 */
class ProductCategoryTest extends \Test\Unit\TestCase
{

    public function testConstruct()
    {
        $model = new ProductCategory();
        $this->assertInstanceOf('Treasure\Models\Model\ProductCategory', $model);
    }
}
