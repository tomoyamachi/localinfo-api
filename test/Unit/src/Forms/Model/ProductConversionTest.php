<?php
/**
 * Test\Unit\src\Models
 */
namespace Test\Unit\src\Forms;

use Papi\Forms\Model\ProductConversion;

/**
 * ProductConversionTest
 */
class ProductConversionTest extends \Test\Unit\TestCase
{

    public function testConstruct()
    {
        $form = new ProductConversion();
        $this->assertInstanceOf('Papi\Forms\Model\ProductConversion', $form);
    }
}
