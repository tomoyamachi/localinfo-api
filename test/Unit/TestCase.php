<?php
/**
 * Test\Unit
 */
namespace Test\Unit;

use \Gpl\Mvc\Application\Launcher;
use \Treasure\Config\ProjectConfiguration\V1;

/**
 * TestCase
 */
class TestCase extends \Phalcon\Test\UnitTestCase
{
    /**
     * setUpBeforeClass
     */
    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();
    }

    /**
     * setUp
     */
    protected function setUp()
    {
        $configuration = new V1('test');
        \Phalcon\DI::setDefault($configuration->getDI());
    }
}
