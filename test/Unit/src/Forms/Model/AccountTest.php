<?php
/**
 * Test\Unit\src\Models
 */
namespace Test\Unit\src\Forms;

use Lapi\Forms\Model\Account;

/**
 * AccountTest
 */
class AccountTest extends \Test\Unit\TestCase
{

    public function testConstruct()
    {
        $form = new Account();
        $this->assertInstanceOf('Lapi\Forms\Model\Account', $form);
    }
}
