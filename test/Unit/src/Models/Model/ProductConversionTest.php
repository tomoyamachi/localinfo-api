<?php
/**
 * Test\Unit\src\Models\Model
 */
namespace Test\Unit\src\Models\Model;

use Papi\Models\Model\ProductConversion;

/**
 * ProductConversionTest
 */
class ProductConversionTest extends \Test\Unit\TestCase
{

    public function testConstruct()
    {
        $model = new ProductConversion();
        $this->assertInstanceOf('Papi\Models\Model\ProductConversion', $model);
    }
}
