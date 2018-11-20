<?php
use Cake\Routing\Router;

Router::plugin(
    'Cms',
    function ($routes) {
        $routes->setExtensions(['json']);

        $routes->scope('/site', function ($routes) {
            // Categories routes
            $routes->connect(
                '/:site_slug/categories/:action/*',
                ['controller' => 'Categories'],
                ['pass' => ['site_slug']]
            );
            $routes->connect(
                '/:site_slug/category/:category_slug/view/*',
                ['controller' => 'Categories', 'action' => 'view'],
                ['pass' => ['site_slug', 'category_slug']]
            );
            // Articles routes
            $routes->connect(
                '/:site_slug/articles/:action/:article_type/*',
                ['controller' => 'Articles'],
                ['pass' => ['site_slug', 'article_type']]
            );
            $routes->connect(
                '/:site_slug/type/:article_type/view/*',
                ['controller' => 'Articles', 'action' => 'type'],
                ['pass' => ['site_slug', 'article_type']]
            );
        });

        $routes->fallbacks('DashedRoute');
    }
);
