<?php
/**
 * Test\Functional
 */
namespace Test\Functional;

use \Gpl\Mvc\Application\Launcher;
use \Treasure\Config\ProjectConfiguration\V1;

/**
 * TestCase
 */
class TestCase extends \Phalcon\Test\FunctionalTestCase
{
    protected $launcher;

    /**
     * setUpBeforeClass
     */
    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();
    }

    /**
     * initializeRequest
     */
    public function initializeRequest()
    {
        $this->tearDown();
        parent::setUp(null, null);
        $this->launcher = new Launcher(new V1('test'));
        $_SERVER['REQUEST_METHOD'] = 'GET';
    }

    /**
     * getEndPoint
     */
    protected function getEndPoint($title, $description, $http_method, $path, $parameters = [])
    {
        $response = json_decode($this->getContent(), true);
        return [
            'title' => $title,
            'description' => $description,
            'http_method' => $http_method,
            'path' => $path,
            'parameters' => $parameters,
            'response' => json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
        ];
    }

    /**
     * getRequestParameter
     */
    protected function getRequestParameter($name, $description, $type, $status)
    {
        return [
            'name' => $name,
            'description' => $description,
            'type' => $type,
            'status' => $status
        ];
    }

    /**
     * setUp
     */
    protected function setUp(\Phalcon\DiInterface $di = null, \Phalcon\Config $config = null)
    {
        //FIXME 今は問題ないが、DI関係で問題になる可能性がある
        parent::setUp($di, $config);
        $this->launcher = new Launcher(new V1('test'));
        $_SERVER['REQUEST_METHOD'] = 'GET';
    }

    /**
     * setRequestMethod
     */
    protected function setRequestMethod($method)
    {
        $_SERVER['REQUEST_METHOD'] = $method;
    }

    /**
     * setRequestUri
     */
    protected function setRequestUri($uri)
    {
        $_SERVER['REQUEST_URI'] = $uri;
    }

    /**
     * setPostData
     */
    protected function setRequestData(array $params)
    {
        foreach ($params as $name => $value) {
            $_GET[$name] = $value;
            $_POST[$name] = $value;
            $_REQUEST[$name] = $value;
        }
    }

    /**
     * tearDown
     */
    protected function tearDown()
    {
        parent::tearDown();
        $_REQUEST = [];
    }
}
