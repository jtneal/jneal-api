<?php

namespace JNeal;

use JNeal\Provider\Repository\Repository;
use JNeal\Provider\ResponseFactory\ResponseFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class Controller
 * @package JNeal
 */
class Controller
{
    /**
     * @var Request
     */
    private $request;

    /**
     * @var Repository
     */
    private $repository;

    /**
     * @var ResponseFactory
     */
    private $responseFactory;

    /**
     * @param Request $request
     * @param Repository $repository
     * @param ResponseFactory $responseFactory
     */
    public function __construct(
        Request $request,
        Repository $repository,
        ResponseFactory $responseFactory
    ) {
        $this->request = $request;
        $this->repository = $repository;
        $this->responseFactory = $responseFactory;
    }

    /**
     * @return Response
     */
    public function index(): Response
    {
        $method = 'get' . ucfirst($this->request->query->get('filter'));

        if (!method_exists($this->repository, $method)) {
            $method = 'getList';
        }

        return $this->responseFactory->make($this->repository->$method());
    }

    /**
     * @param int $id
     * @return Response
     */
    public function fetch(int $id): Response
    {
        return $this->responseFactory->make($this->repository->getItem($id));
    }

    /**
     * @return Response
     */
    public function add(): Response
    {
        $this->repository->add();

        return $this->responseFactory->make(['message' => 'Successfully added']);
    }

    /**
     * @param int $id
     * @return Response
     */
    public function update(int $id): Response
    {
        $this->repository->update($id);

        return $this->responseFactory->make(['message' => 'Successfully updated']);
    }

    /**
     * @param int $id
     * @return Response
     */
    public function delete(int $id): Response
    {
        $this->repository->delete($id);

        return $this->responseFactory->make(['message' => 'Successfully deleted']);
    }
}
