<?php
/**
 * Test\Unit\src\Models
 */
namespace Test\Unit\src\Forms;

use Papi\Forms\Model\Customer;

/**
 * CustomerTest
 */
class CustomerTest extends \Test\Unit\TestCase
{

    public function testConstruct()
    {
        $form = new Customer();
        $this->assertInstanceOf('Papi\Forms\Model\Customer', $form);
    }
}
