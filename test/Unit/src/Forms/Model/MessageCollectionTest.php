<?php
/**
 * Test\Unit\src\Models
 */
namespace Test\Unit\src\Forms;

use Treasure\Forms\Model\MessageCollection;

/**
 * MessageCollectionTest
 */
class MessageCollectionTest extends \Test\Unit\TestCase
{

    public function testConstruct()
    {
        $form = new MessageCollection();
        $this->assertInstanceOf('Treasure\Forms\Model\MessageCollection', $form);
    }
}
