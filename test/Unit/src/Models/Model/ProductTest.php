<?php
/**
 * Test\Unit\src\Models\Model
 */
namespace Test\Unit\src\Models\Model;

use Treasure\Models\Model\Product;

/**
 * ProductTest
 */
class ProductTest extends \Test\Unit\TestCase
{

    public function testConstruct()
    {
        $model = new Product();
        $this->assertInstanceOf('Treasure\Models\Model\Product', $model);
    }
}
