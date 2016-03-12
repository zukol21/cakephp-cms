<?php
use Cake\Routing\Router;

Router::plugin(
    'Cms',
    ['path' => '/cms'],
    function ($routes) {
        $routes->extensions(['json']);
        $routes->fallbacks('DashedRoute');
    }
);

