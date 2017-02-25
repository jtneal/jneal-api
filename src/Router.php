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

        $controllers->get('/', 'controller.base:index');
        $controllers->get('/portfolio/', 'controller.portfolio:index');
        $controllers->get('/portfolio/{id}', 'controller.portfolio:fetch')->assert('id', '\d+');

        return $controllers;
    }
}
