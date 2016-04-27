<?php
/**
 * Test\Unit\src\Models\Model
 */
namespace Test\Unit\src\Models\Model;

use Papi\Models\Model\Customer;

/**
 * CustomerTest
 */
class CustomerTest extends \Test\Unit\TestCase
{

    public function testConstruct()
    {
        $model = new Customer();
        $this->assertInstanceOf('Papi\Models\Model\Customer', $model);
    }
}
