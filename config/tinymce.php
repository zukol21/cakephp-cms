<?php
// TinyMCE plugin configuration
return [
    'TinyMCE' => [
        'selector' => 'textarea.tinymce',
        'relative_urls' => false,
        'plugins' => ['image', 'link'],
        'file_browser_callback_types' => 'file image',
        'theme' => 'modern',
        'height' => 300
    ]
];
