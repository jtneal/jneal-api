<?php

namespace JNeal;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class AuthTest
 * @package JNeal
 */
class AuthTest extends TestCase
{
    /**
     * Test Authenticate
     */
    public function testAuthenticate()
    {
        $request = Request::createFromGlobals();
        $request->headers->set('X-AUTH-TOKEN', 'test');

        $auth = new Auth($request, 'test');
        $auth->authenticate();

        $this->assertInstanceOf('JNeal\Auth', $auth);
    }

    /**
     * @expectedException \Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException
     */
    public function testAuthenticateException()
    {
        $auth = new Auth(Request::createFromGlobals(), 'test');
        $auth->authenticate();
    }
}
