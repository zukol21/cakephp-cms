<?php
use Cake\Routing\Router;

Router::plugin(
    'Cms',
    function ($routes) {
        $routes->connect('/articles/display/*', ['Plugin' => 'Cms', 'controller' => 'Articles', 'action' => 'display']);
        $routes->connect('/categories/display/*', ['Plugin' => 'Cms', 'controller' => 'Categories', 'action' => 'display']);

        $routes->connect('/articles/*', ['Plugin' => 'Cms', 'controller' => 'Articles', 'action' => 'display']);
        $routes->connect('/categories/*', ['Plugin' => 'Cms', 'controller' => 'Categories', 'action' => 'display']);

        $routes->extensions(['json']);
        $routes->fallbacks('DashedRoute');
    }
);
Router::connect('/admin', ['plugin' => 'Cms', 'controller' => 'Articles']);
