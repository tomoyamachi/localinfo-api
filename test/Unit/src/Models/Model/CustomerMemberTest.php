<?php
/**
 * Test\Unit\src\Models\Model
 */
namespace Test\Unit\src\Models\Model;

use Papi\Models\Model\CustomerMember;

/**
 * CustomerMemberTest
 */
class CustomerMemberTest extends \Test\Unit\TestCase
{

    public function testConstruct()
    {
        $model = new CustomerMember();
        $this->assertInstanceOf('Papi\Models\Model\CustomerMember', $model);
    }
}
