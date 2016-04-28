<?php
/**
 * Test\Unit\src\Models
 */
namespace Test\Unit\src\Forms;

use Treasure\Forms\Model\Account;

/**
 * AccountTest
 */
class AccountTest extends \Test\Unit\TestCase
{

    public function testConstruct()
    {
        $form = new Account();
        $this->assertInstanceOf('Treasure\Forms\Model\Account', $form);
    }
}
