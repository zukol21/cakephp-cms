<?php
use Cake\Routing\Router;

Router::plugin(
    'Cms',
    function ($routes) {
        // Frontend requests only
        $routes->connect('/categories/*', ['plugin' => 'Cms', 'controller' => 'Categories', 'action' => 'display']);
        $routes->extensions(['json']);
        $routes->fallbacks('DashedRoute');
    }
);