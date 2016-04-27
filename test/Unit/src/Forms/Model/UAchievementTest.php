<?php
/**
 * Test\Unit\src\Models
 */
namespace Test\Unit\src\Forms;

use Treasure\Forms\Model\UAchievement;

/**
 * UAchievementTest
 */
class UAchievementTest extends \Test\Unit\TestCase
{

    public function testConstruct()
    {
        $form = new UAchievement();
        $this->assertInstanceOf('Treasure\Forms\Model\UAchievement', $form);
    }
}
