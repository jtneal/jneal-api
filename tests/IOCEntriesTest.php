<?php

namespace JNeal;

use PHPUnit\Framework\TestCase;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class IOCEntriesTest
 * @package JNeal
 */
class IOCEntriesTest extends TestCase
{
    /**
     * Test Register
     */
    public function testRegister()
    {
        $app = new Application();
        $entries = new IOCEntries();

        $entries->register($app);

        $app['auth.token'] = 'test';
        $app['request'] = Request::createFromGlobals();
        $app['pdo'] = $this->createMock('PDO');

        $this->assertInstanceOf('JNeal\Auth', $app['auth']);
        $this->assertInstanceOf('JNeal\Provider\Repository\PDORepository', $app['repository.pdo']);
        $this->assertInstanceOf('JNeal\Base\BaseRepository', $app['repository.base']);
        $this->assertInstanceOf('JNeal\Provider\ResponseFactory\JsonResponseFactory', $app['responseFactory.json']);
        $this->assertInstanceOf('JNeal\Controller', $app['controller.base']);
        $this->assertInstanceOf('JNeal\Controller', $app['controller.portfolio']);
    }

    /**
     * @expectedException \PDOException
     */
    public function testPDO()
    {
        $app = new Application();
        $entries = new IOCEntries();

        $app['db.dsn'] = '';
        $app['db.user'] = '';
        $app['db.pass'] = '';

        $entries->register($app);

        $this->assertInstanceOf('PDO', $app['pdo']);
    }
}
