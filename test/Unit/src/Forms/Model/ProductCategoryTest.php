<?php
/**
 * Test\Unit\src\Models
 */
namespace Test\Unit\src\Forms;

use Papi\Forms\Model\ProductCategory;

/**
 * ProductCategoryTest
 */
class ProductCategoryTest extends \Test\Unit\TestCase
{

    public function testConstruct()
    {
        $form = new ProductCategory();
        $this->assertInstanceOf('Papi\Forms\Model\ProductCategory', $form);
    }
}
