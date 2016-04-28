<?php
/**
 * Test\Unit\src\Models
 */
namespace Test\Unit\src\Forms;

use Treasure\Forms\Model\Like;

/**
 * LikeTest
 */
class LikeTest extends \Test\Unit\TestCase
{

    public function testConstruct()
    {
        $form = new Like();
        $this->assertInstanceOf('Treasure\Forms\Model\Like', $form);
    }
}
