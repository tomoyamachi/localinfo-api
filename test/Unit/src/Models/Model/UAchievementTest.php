<?php
/**
 * Test\Unit\src\Models\Model
 */
namespace Test\Unit\src\Models\Model;

use Papi\Models\Model\UAchievement;

/**
 * UAchievementTest
 */
class UAchievementTest extends \Test\Unit\TestCase
{

    public function testConstruct()
    {
        $model = new UAchievement();
        $this->assertInstanceOf('Papi\Models\Model\UAchievement', $model);
    }
}
