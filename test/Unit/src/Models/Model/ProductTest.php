<?php
/**
 * Test\Unit\src\Models\Model
 */
namespace Test\Unit\src\Models\Model;

use Papi\Models\Model\Product;

/**
 * ProductTest
 */
class ProductTest extends \Test\Unit\TestCase
{

    public function testConstruct()
    {
        $model = new Product();
        $this->assertInstanceOf('Papi\Models\Model\Product', $model);
    }
}
