<?php
use Cake\Routing\Router;

Router::plugin(
    'Cms',
    function ($routes) {
        $routes->extensions(['json']);
        $routes->fallbacks('DashedRoute');
    }
);
Router::connect('/admin', ['plugin' => 'Cms', 'controller' => 'Articles']);
