<?php
use Cake\Routing\Router;

Router::plugin(
    'Cms',
    function ($routes) {
        $routes->extensions(['json']);

        $routes->scope('/site', function ($routes) {
            // Categories routes
            $routes->connect(
                '/:slug/categories/:action/*',
                ['controller' => 'Categories'],
                ['pass' => ['slug']]
            );
            $routes->connect(
                '/:slug/category/:type/view/*',
                ['controller' => 'Categories', 'action' => 'view'],
                ['pass' => ['slug', 'type']]
            );
            // Articles routes
            $routes->connect(
                '/:slug/articles/:action/:type/*',
                ['controller' => 'Articles'],
                ['pass' => ['slug', 'type']]
            );
            $routes->connect(
                '/:slug/type/:type/view/*',
                ['controller' => 'Articles', 'action' => 'type'],
                ['pass' => ['slug', 'type']]
            );
        });

        $routes->fallbacks('DashedRoute');
    }
);
