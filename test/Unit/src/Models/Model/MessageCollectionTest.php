<?php
/**
 * Test\Unit\src\Models\Model
 */
namespace Test\Unit\src\Models\Model;

use Papi\Models\Model\MessageCollection;

/**
 * MessageCollectionTest
 */
class MessageCollectionTest extends \Test\Unit\TestCase
{

    public function testConstruct()
    {
        $model = new MessageCollection();
        $this->assertInstanceOf('Papi\Models\Model\MessageCollection', $model);
    }
}
