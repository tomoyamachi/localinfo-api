<?php
/**
 * Test\Unit\src\Models
 */
namespace Test\Unit\src\Forms;

use Lapi\Forms\Model\Comment;

/**
 * CommentTest
 */
class CommentTest extends \Test\Unit\TestCase
{

    public function testConstruct()
    {
        $form = new Comment();
        $this->assertInstanceOf('Lapi\Forms\Model\Comment', $form);
    }
}
