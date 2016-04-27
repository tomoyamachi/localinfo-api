<?php
/**
 * Test\Unit\src\Models\Model
 */
namespace Test\Unit\src\Models\Model;

use Treasure\Models\Model\ProductConversion;

/**
 * ProductConversionTest
 */
class ProductConversionTest extends \Test\Unit\TestCase
{

    public function testConstruct()
    {
        $model = new ProductConversion();
        $this->assertInstanceOf('Treasure\Models\Model\ProductConversion', $model);
    }
}
