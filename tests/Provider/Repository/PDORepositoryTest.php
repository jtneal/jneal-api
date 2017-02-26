<?php

namespace JNeal\Provider\Repository;

use Mockery as M;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;

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

        $repository = (new PDORepository($pdoMock, Request::createFromGlobals()))
            ->setTable('test')
            ->setPrimaryKey('id');

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

        $repository = (new PDORepository($pdoMock, Request::createFromGlobals()))
            ->setTable('test')
            ->setPrimaryKey('id');

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

        $repository = (new PDORepository($pdoMock, Request::createFromGlobals()))
            ->setTable('test')
            ->setPrimaryKey('id');

        $repository->getItem(0);
    }

    /**
     * Test Add
     */
    public function testAdd()
    {
        /** @var \PDO $pdoMock */
        $pdoMock = M::mock('PDO');
        $pdoMock->shouldReceive('fetchAll')->with(7, 0)->andReturn(['allow1', 'allow2']);
        $pdoMock->shouldReceive('execute')->with(['1', '3']);
        $pdoMock->shouldReceive('execute')->with(['test']);
        $pdoMock->shouldReceive('prepare')->with('SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE table_name = ?')->andReturn($pdoMock);
        $pdoMock->shouldReceive('prepare')->with('INSERT INTO test (allow1,allow2) VALUES (?,?)')->andReturn($pdoMock);

        $request = Request::createFromGlobals();
        $request->request->replace(['allow1' => '1', 'disallow1' => '2', 'allow2' => '3', 'disallow2' => '4']);

        $repository = (new PDORepository($pdoMock, $request))
            ->setTable('test')
            ->setPrimaryKey('id');

        $this->assertTrue($repository->add());
    }

    /**
     * Test Update
     */
    public function testUpdate()
    {
        /** @var \PDO $pdoMock */
        $pdoMock = M::mock('PDO');
        $pdoMock->shouldReceive('fetchAll')->with(7, 0)->andReturn(['allow1', 'allow2']);
        $pdoMock->shouldReceive('execute')->with(['1', '3', 5]);
        $pdoMock->shouldReceive('execute')->with(['test']);
        $pdoMock->shouldReceive('prepare')->with('SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE table_name = ?')->andReturn($pdoMock);
        $pdoMock->shouldReceive('prepare')->with('UPDATE test SET allow1 = ?, allow2 = ? WHERE id = ?')->andReturn($pdoMock);

        $request = Request::createFromGlobals();
        $request->request->replace(['allow1' => '1', 'disallow1' => '2', 'allow2' => '3', 'disallow2' => '4']);

        $repository = (new PDORepository($pdoMock, $request))
            ->setTable('test')
            ->setPrimaryKey('id');

        $this->assertTrue($repository->update(5));
    }

    /**
     * Test Delete
     */
    public function testDelete()
    {
        /** @var \PDO $pdoMock */
        $pdoMock = M::mock('PDO');
        $pdoMock->shouldReceive('execute')->with([5]);
        $pdoMock->shouldReceive('prepare')->with('DELETE FROM test WHERE id = ?')->andReturn($pdoMock);

        $repository = (new PDORepository($pdoMock, Request::createFromGlobals()))
            ->setTable('test')
            ->setPrimaryKey('id');

        $this->assertTrue($repository->delete(5));
    }
}
