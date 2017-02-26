<?php

namespace JNeal;

use Silex\Api\ControllerProviderInterface;
use Silex\Application;
use Silex\ControllerCollection;

/**
 * Class Router
 * @package JNeal
 */
class Router implements ControllerProviderInterface
{
    /**
     * @param Application $app
     * @return ControllerCollection
     */
    public function connect(Application $app): ControllerCollection
    {
        $controllers = $app['controllers_factory'];

        $auth = [$app['auth'], 'authenticate'];

        $controllers->get('/', 'controller.base:index');
        $controllers->get('/portfolio', 'controller.portfolio:index');
        $controllers->post('/portfolio', 'controller.portfolio:add')->before($auth);
        $controllers->get('/portfolio/{id}', 'controller.portfolio:fetch')->assert('id', '\d+');
        $controllers->post('/portfolio/{id}', 'controller.portfolio:update')->assert('id', '\d+')->before($auth);
        $controllers->delete('/portfolio/{id}', 'controller.portfolio:delete')->assert('id', '\d+')->before($auth);

        return $controllers;
    }
}
