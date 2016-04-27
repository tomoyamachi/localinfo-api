<?php
/**
 * Test\Unit\src\Models
 */
namespace Test\Unit\src\Forms;

use Papi\Forms\Model\ProductAchievement;

/**
 * ProductAchievementTest
 */
class ProductAchievementTest extends \Test\Unit\TestCase
{

    public function testConstruct()
    {
        $form = new ProductAchievement();
        $this->assertInstanceOf('Papi\Forms\Model\ProductAchievement', $form);
    }
}
