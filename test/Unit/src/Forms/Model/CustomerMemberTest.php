<?php
/**
 * Test\Unit\src\Models
 */
namespace Test\Unit\src\Forms;

use Papi\Forms\Model\CustomerMember;

/**
 * CustomerMemberTest
 */
class CustomerMemberTest extends \Test\Unit\TestCase
{

    public function testConstruct()
    {
        $form = new CustomerMember();
        $this->assertInstanceOf('Papi\Forms\Model\CustomerMember', $form);
    }
}
