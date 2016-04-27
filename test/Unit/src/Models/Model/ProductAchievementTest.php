<?php
/**
 * Test\Unit\src\Models\Model
 */
namespace Test\Unit\src\Models\Model;

use Papi\Models\Model\ProductAchievement;

/**
 * ProductAchievementTest
 */
class ProductAchievementTest extends \Test\Unit\TestCase
{

    public function testConstruct()
    {
        $model = new ProductAchievement();
        $this->assertInstanceOf('Papi\Models\Model\ProductAchievement', $model);
    }
}
