<?php
/**
 * Test\Unit\src\Models
 */
namespace Test\Unit\src\Forms;

use Treasure\Forms\Model\ProductCategory;

/**
 * ProductCategoryTest
 */
class ProductCategoryTest extends \Test\Unit\TestCase
{

    public function testConstruct()
    {
        $form = new ProductCategory();
        $this->assertInstanceOf('Treasure\Forms\Model\ProductCategory', $form);
    }
}
