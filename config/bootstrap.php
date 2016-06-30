<?php
use Cake\Core\Configure;

//Burzum FileStorage configurations
include __DIR__ . '/file_storage.php';

/**
 * Plugin configuration
 *
 * Following configuration can be overridden by the application or other plugin.
 */

//CKEditor specific
if (!Configure::check('Cms.ckeditor.upload.plugin.url')) {
    Configure::write('Cms.ckeditor.upload.plugin.url', 'Cms.ckeditor-upload-plugin');
}

if (!Configure::check('Cms.ckeditor.custom.config.url')) {
    Configure::write('Cms.ckeditor.custom.config.url', 'Cms.ckeditor-config');
}

//CMS
if (!Configure::check('Cms.articles.related')) {
    Configure::write('Cms.articles.related', 5);
}