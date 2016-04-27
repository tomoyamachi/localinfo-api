<?php
/**
 * Test\Unit\src\Models\Model
 */
namespace Test\Unit\src\Models\Model;

use Treasure\Models\Model\ProductAchievement;

/**
 * ProductAchievementTest
 */
class ProductAchievementTest extends \Test\Unit\TestCase
{

    public function testConstruct()
    {
        $model = new ProductAchievement();
        $this->assertInstanceOf('Treasure\Models\Model\ProductAchievement', $model);
    }
}
