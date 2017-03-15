<?php
use Burzum\FileStorage\Storage\StorageUtils;
use Cake\Core\Configure;

/**
 * Burzum File-Storage configuration
 */
// get app level config
$config = Configure::read('FileStorage');
$config = $config ? $config : [];

// load default plugin config
Configure::load('Cms.file_storage');

// overwrite default plugin config by app level config
Configure::write('FileStorage', array_replace_recursive(
    Configure::read('FileStorage'),
    $config
));

// This is very important! The hashes are needed to calculate the image versions!
StorageUtils::generateHashes();

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
