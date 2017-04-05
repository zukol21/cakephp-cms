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
 * TinyMCE configuration
 */
$config = Configure::read('TinyMCE');
$config = $config ? $config : [];
Configure::load('Cms.tinymce');
Configure::write('TinyMCE', array_replace_recursive(
    Configure::read('TinyMCE'),
    $config
));

/**
 * elFinder configuration
 */
$config = Configure::read('TinymceElfinder');
$config = $config ? $config : [];
Configure::load('Cms.elfinder');
Configure::write('TinymceElfinder', array_replace_recursive(
    Configure::read('TinymceElfinder'),
    $config
));
