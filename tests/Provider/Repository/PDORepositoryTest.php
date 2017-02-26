<?php

namespace JNeal\Provider\Repository;

use Mockery as M;
use PHPUnit\Framework\TestCase;

/**
 * Class PDORepositoryTest
 * @package JNeal\Provider\Repository
 */
class PDORepositoryTest extends TestCase
{
    /**
     * Test Get List
     */
    public function testGetList()
    {
        /** @var \PDO $pdoMock */
        $pdoMock = M::mock('PDO');
        $pdoMock->shouldReceive('fetchAll')->andReturn([['key' => 'val']]);
        $pdoMock->shouldReceive('execute');
        $pdoMock->shouldReceive('prepare')->with('SELECT * FROM test ORDER BY id DESC ')->andReturn($pdoMock);
        $pdoMock->shouldReceive('prepare')->with('SELECT * FROM test ORDER BY id DESC LIMIT 6')->andReturn($pdoMock);

        $repository = (new PDORepository($pdoMock))->setTable('test')->setPrimaryKey('id');

        $this->assertEquals([['key' => 'val']], $repository->getList());
        $this->assertEquals([['key' => 'val']], $repository->getRecent());
    }

    /**
     * Test Get Item
     */
    public function testGetItem()
    {
        /** @var \PDO $pdoMock */
        $pdoMock = M::mock('PDO');
        $pdoMock->shouldReceive('fetch')->andReturn(['key' => 'val']);
        $pdoMock->shouldReceive('execute');
        $pdoMock->shouldReceive('prepare')->with('SELECT * FROM test WHERE id = ? LIMIT 1')->andReturn($pdoMock);

        $repository = (new PDORepository($pdoMock))->setTable('test')->setPrimaryKey('id');

        $this->assertEquals(['key' => 'val'], $repository->getItem(0));
    }

    /**
     * @expectedException \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function testGetItemException()
    {
        /** @var \PDO $pdoMock */
        $pdoMock = M::mock('PDO');
        $pdoMock->shouldReceive('fetch')->andReturn(false);
        $pdoMock->shouldReceive('execute');
        $pdoMock->shouldReceive('prepare')->with('SELECT * FROM test WHERE id = ? LIMIT 1')->andReturn($pdoMock);

        $repository = (new PDORepository($pdoMock))->setTable('test')->setPrimaryKey('id');

        $repository->getItem(0);
    }
}
