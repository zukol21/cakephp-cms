<?php
use Burzum\FileStorage\Lib\StorageManager;
use Burzum\FileStorage\Storage\Listener\BaseListener;
use Burzum\FileStorage\Storage\StorageUtils;
use Cake\Core\Configure;
use Cake\Event\EventManager;

StorageManager::config(
    'Local',
    [
        'adapterOptions' => [WWW_ROOT, true],
        'adapterClass' => '\Gaufrette\Adapter\Local',
        'class' => '\Gaufrette\Filesystem'
    ]
);

$listener = new BaseListener([
    'imageProcessing' => true,
    'pathBuilderOptions' => [
        'pathPrefix' => '/uploads'
    ]
]);

EventManager::instance()->on($listener);

// Allow the app or other plugin to override this config.
if (!Configure::check('FileStorage.imageSizes.ArticleFeaturedImage')) {
    //Image dimension are based on Bootstrap columns using 16:9 ratio.
    Configure::write('FileStorage.imageSizes.ArticleFeaturedImage', [
        'large' => [
            'thumbnail' => [
                'mode' => 'inbound',
                //col-12
                'width' => 1170,
                'height' => 658
            ]
        ],
        'medium' => [
            'thumbnail' => [
                'mode' => 'inbound',
                //col-8
                'width' => 750,
                'height' => 422
            ]
        ],
        'small' => [
            'thumbnail' => [
                'mode' => 'inbound',
                //col-4
                'width' => 260,
                'height' => 146
            ]
        ],
        'extra-small' => [
            'thumbnail' => [
                'mode' => 'inbound',
                //col-2
                'width' => 165,
                'height' => 93
            ]
        ]
    ]);
}

// This is very important! The hashes are needed to calculate the image versions!
StorageUtils::generateHashes();
