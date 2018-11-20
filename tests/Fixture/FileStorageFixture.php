<?php
namespace Cms\Test\Fixture;

use Burzum\FileStorage\Test\Fixture\FileStorageFixture as BaseFixture;

class FileStorageFixture extends BaseFixture
{
    public $records = [
        [
            'id' => '00000000-0000-0000-0000-000000000001',
            'user_id' => 'user-1',
            'foreign_key' => '00000000-0000-0000-0000-000000000001',
            'model' => 'ArticleFeaturedImage',
            'filename' => 'cake.icon.png',
            'filesize' => '',
            'mime_type' => 'image/png',
            'extension' => 'png',
            'hash' => '',
            'path' => '',
            'adapter' => 'Local',
            'created' => '2012-01-01 12:00:00',
            'modified' => '2012-01-01 12:00:00',
        ],
    ];

}
