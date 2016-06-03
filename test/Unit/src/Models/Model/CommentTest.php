<?php
/**
 * Test\Unit\src\Models\Model
 */
namespace Test\Unit\src\Models\Model;

use Lapi\Models\Model\Comment;

/**
 * CommentTest
 */
class CommentTest extends \Test\Unit\TestCase
{

    public function testConstruct()
    {
        $model = new Comment();
        $this->assertInstanceOf('Lapi\Models\Model\Comment', $model);
    }
}
