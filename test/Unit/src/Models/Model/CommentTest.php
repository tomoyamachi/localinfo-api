<?php
/**
 * Test\Unit\src\Models\Model
 */
namespace Test\Unit\src\Models\Model;

use Treasure\Models\Model\Comment;

/**
 * CommentTest
 */
class CommentTest extends \Test\Unit\TestCase
{

    public function testConstruct()
    {
        $model = new Comment();
        $this->assertInstanceOf('Treasure\Models\Model\Comment', $model);
    }
}
