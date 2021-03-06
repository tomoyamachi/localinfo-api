<?php
/**
 * Test\Unit\src\Models\Model
 */
namespace Test\Unit\src\Models\Model;

use Lapi\Models\Model\Account;

/**
 * AccountTest
 */
class AccountTest extends \Test\Unit\TestCase
{

    public function testConstruct()
    {
        $model = new Account();
        $this->assertInstanceOf('Lapi\Models\Model\Account', $model);
    }
}
