<?php
use Cake\Core\Configure;

// Burzum File-Storage plugin configuration
return [
    'FileStorage' => [
        'imageSizes' => [
            'ArticleFeaturedImage' => Configure::read('ThumbnailVersions')
        ]
    ]
];
