<?php
/**
 * Test\Unit\src\Models
 */
namespace Test\Unit\src\Forms;

use Papi\Forms\Model\MessageCollection;

/**
 * MessageCollectionTest
 */
class MessageCollectionTest extends \Test\Unit\TestCase
{

    public function testConstruct()
    {
        $form = new MessageCollection();
        $this->assertInstanceOf('Papi\Forms\Model\MessageCollection', $form);
    }
}
