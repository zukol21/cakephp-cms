<?php
use Cake\Core\Configure;

// load tinyMCE editor and elFinder file manager
echo $this->Html->script('Cms./plugins/tinymce/tinymce.min', ['block' => 'scriptBotton']);
echo $this->TinymceElfinder->defineElfinderBrowser(true);

// initialize tinyMCE
echo $this->Html->scriptBlock(
    '$(document).ready(function() {
        // tinymce init
        var config = ' . json_encode(Configure::read('TinyMCE')) . ';
        config.file_browser_callback = elFinderBrowser;
        tinyMCE.init(config);
    });',
    ['block' => 'scriptBotton']
);
