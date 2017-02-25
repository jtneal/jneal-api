<?php

namespace JNeal;

use JNeal\Base\BaseRepository;
use JNeal\Provider\Repository\PDORepository;
use JNeal\Provider\ResponseFactory\JsonResponseFactory;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * Class IOCEntries
 * @package JNeal
 */
class IOCEntries implements ServiceProviderInterface
{
    /**
     * @param Container $app
     */
    public function register(Container $app)
    {
        $this->providers($app);
        $this->controllers($app);
    }

    /**
     * @param Container $app
     */
    private function providers(Container $app)
    {
        $app['pdo'] = function ($app): \PDO {
            return new \PDO($app['db.dsn'], $app['db.user'], $app['db.pass']);
        };

        $app['repository.pdo'] = $app->factory(function ($app): PDORepository {
            return new PDORepository($app['pdo']);
        });

        $app['repository.base'] = function (): BaseRepository {
            return new BaseRepository();
        };

        $app['responseFactory.json'] = function (): JsonResponseFactory {
            return new JsonResponseFactory();
        };
    }

    /**
     * @param Container $app
     */
    private function controllers(Container $app)
    {
        $app['controller.base'] = function ($app): Controller {
            return new Controller(
                $app['request'],
                $app['repository.base'],
                $app['responseFactory.json']
            );
        };

        $app['controller.portfolio'] = function ($app): Controller {
            return new Controller(
                $app['request'],
                $app['repository.pdo']->setTable('portfolio')->setPrimaryKey('portfolio_id'),
                $app['responseFactory.json']
            );
        };
    }
}
