<?php
// TinyMCE plugin configuration
return [
    'TinyMCE' => [
        'selector' => 'textarea.tinymce',
        'relative_urls' => false,
        'plugins' => ['image', 'link'],
        'browser_spellcheck' => true,
        'file_browser_callback_types' => 'file image',
        'theme' => 'modern',
        'height' => 300
    ]
];
