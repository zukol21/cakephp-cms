<?php
use Cake\Core\Configure;

// I am useless without an id.
if (!isset($id) && empty($id)) {
    return false;
}

echo $this->Html->script('https://cdn.ckeditor.com/4.5.8/full-all/ckeditor.js', ['block' => 'scriptBotton']);
echo $this->Html->script(Configure::read('Cms.ckeditor.upload.plugin.url'), ['block' => 'scriptBotton']);
echo $this->Html->scriptBlock(
    'var options = {
        customConfig: "' . $this->Url->script(Configure::read('Cms.ckeditor.custom.config.url')) . '"
    };
    var uploadOptions = uploadOptions || {};
    // Merge with upload plugin options
    jQuery.extend(options, uploadOptions);
    CKEDITOR.replace("' . $id . '", options);',
    ['block' => 'scriptBotton']
);
