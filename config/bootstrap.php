<?php
use Burzum\FileStorage\Storage\StorageUtils;
use Cake\Core\Configure;

/**
 * Cms configuration
 */
// get app level config
$config = Configure::read('CMS');
$config = $config ? $config : [];
// load default plugin config
Configure::load('Qobo/Cms.cms');
// overwrite default plugin config by app level config
Configure::write('CMS', array_replace_recursive(
    Configure::read('CMS'),
    $config
));

/**
 * Burzum File-Storage configuration
 */
$config = Configure::read('FileStorage');
$config = $config ? $config : [];
Configure::load('Qobo/Cms.file_storage');
Configure::write('FileStorage', array_replace_recursive(
    Configure::read('FileStorage'),
    $config
));
StorageUtils::generateHashes(); // This is very important! The hashes are needed to calculate the image versions!

/**
 * TinyMCE configuration
 */
$config = Configure::read('TinyMCE');
$config = $config ? $config : [];
Configure::load('Qobo/Cms.tinymce');
Configure::write('TinyMCE', array_replace_recursive(
    Configure::read('TinyMCE'),
    $config
));

/**
 * elFinder configuration
 */
$config = Configure::read('TinymceElfinder');
$config = $config ? $config : [];
Configure::load('Qobo/Cms.elfinder');
Configure::write('TinymceElfinder', array_replace_recursive(
    Configure::read('TinymceElfinder'),
    $config
));
