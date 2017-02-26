<?php

namespace JNeal;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

/**
 * Class Auth
 * @package JNeal
 */
class Auth
{
    /**
     * @var Request
     */
    private $request;

    /**
     * @var string
     */
    private $authToken;

    /**
     * @param Request $request
     * @param string $authToken
     */
    public function __construct(Request $request, string $authToken)
    {
        $this->request = $request;
        $this->authToken = $authToken;
    }

    /**
     * @throws UnauthorizedHttpException
     */
    public function authenticate()
    {
        if ($this->request->headers->get('X-AUTH-TOKEN') !== $this->authToken) {
            throw new UnauthorizedHttpException(null, 'You are unauthorized for that HTTP method');
        }
    }
}
