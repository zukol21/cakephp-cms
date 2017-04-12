<?php
use Cake\Core\Configure;

// load tinyMCE editor and elFinder file manager
echo $this->Html->script('Cms./plugins/tinymce/tinymce.min', ['block' => 'scriptBotton']);
echo $this->TinymceElfinder->defineElfinderBrowser(true);

// initialize tinyMCE
echo $this->Html->scriptBlock(
    'var tinymce_init_config = ' . json_encode(Configure::read('TinyMCE')) . ';',
    ['block' => 'scriptBotton']
);
echo $this->Html->script('Cms.tinymce.init', ['block' => 'scriptBotton']);
