<?php
/**
 * Test\Unit\src\Models
 */
namespace Test\Unit\src\Forms;

use Treasure\Forms\Model\Customer;

/**
 * CustomerTest
 */
class CustomerTest extends \Test\Unit\TestCase
{

    public function testConstruct()
    {
        $form = new Customer();
        $this->assertInstanceOf('Treasure\Forms\Model\Customer', $form);
    }
}
