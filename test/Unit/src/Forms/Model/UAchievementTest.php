<?php
/**
 * Test\Unit\src\Models
 */
namespace Test\Unit\src\Forms;

use Papi\Forms\Model\UAchievement;

/**
 * UAchievementTest
 */
class UAchievementTest extends \Test\Unit\TestCase
{

    public function testConstruct()
    {
        $form = new UAchievement();
        $this->assertInstanceOf('Papi\Forms\Model\UAchievement', $form);
    }
}
