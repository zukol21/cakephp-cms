<?php
use Cake\Routing\Router;

Router::plugin(
    'Cms',
    function ($routes) {
        $routes->extensions(['json']);

        $routes->scope('/site', function ($routes) {
            $routes->connect('/:slug/categories/:action/*', ['controller' => 'Categories'], ['pass' => ['slug']]);
            $routes->connect(
                '/:slug/articles/:action/:type/*',
                ['controller' => 'Articles'],
                ['pass' => ['slug', 'type']]
            );
            $routes->connect(
                '/:slug/category/:category/display/*',
                ['controller' => 'Categories', 'action' => 'display'],
                ['pass' => ['slug', 'category']]
            );
        });

        $routes->fallbacks('DashedRoute');
    }
);
