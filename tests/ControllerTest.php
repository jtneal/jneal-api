<?php

namespace JNeal;

use JNeal\Base\BaseRepository;
use JNeal\Provider\ResponseFactory\JsonResponseFactory;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ControllerTest
 * @package JNeal
 */
class ControllerTest extends TestCase
{
    /**
     * Test Controller
     */
    public function testController()
    {
        $controller = new Controller(
            Request::createFromGlobals(),
            new BaseRepository(),
            new JsonResponseFactory()
        );

        $this->assertContains('{"links":[', $controller->index()->getContent());
        $this->assertEquals('[]', $controller->fetch(0)->getContent());
        $this->assertEquals('{"message":"Successfully added"}', $controller->add()->getContent());
        $this->assertEquals('{"message":"Successfully updated"}', $controller->update(0)->getContent());
        $this->assertEquals('{"message":"Successfully deleted"}', $controller->delete(0)->getContent());
    }
}
