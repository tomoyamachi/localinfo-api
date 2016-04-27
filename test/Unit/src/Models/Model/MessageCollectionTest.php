<?php
/**
 * Test\Unit\src\Models\Model
 */
namespace Test\Unit\src\Models\Model;

use Treasure\Models\Model\MessageCollection;

/**
 * MessageCollectionTest
 */
class MessageCollectionTest extends \Test\Unit\TestCase
{

    public function testConstruct()
    {
        $model = new MessageCollection();
        $this->assertInstanceOf('Treasure\Models\Model\MessageCollection', $model);
    }
}
