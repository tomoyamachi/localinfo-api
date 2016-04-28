<?php
/**
 * Test\Unit\src\Models
 */
namespace Test\Unit\src\Forms;

use Treasure\Forms\Model\Product;

/**
 * ProductTest
 */
class ProductTest extends \Test\Unit\TestCase
{

    public function testConstruct()
    {
        $form = new Product();
        $this->assertInstanceOf('Treasure\Forms\Model\Product', $form);
    }
}
