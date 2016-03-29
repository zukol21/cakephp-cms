<?php
use Cake\Routing\Router;

Router::plugin(
    'Cms',
    function ($routes) {
        // Frontend requests only
        $routes->extensions(['json']);
        $routes->fallbacks('DashedRoute');
    }
);