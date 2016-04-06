<?php
use Cake\Core\Configure;

// I am useless without an id.
if (!isset($id) && empty($id)) {
    return false;
}
echo $this->Html->script('https://cdn.ckeditor.com/4.5.8/full-all/ckeditor.js', ['block' => 'scriptBottom']);
echo $this->Html->script(Configure::read('Cms.ckeditor.upload.plugin.url'), ['block' => 'scriptBottom']);
echo $this->Html->scriptStart(['block' => 'scriptBottom']); ?>
<?php
$url = $this->Url->script(Configure::read('Cms.ckeditor.custom.config.url'));
echo <<<EOT
    var options = {
        customConfig: '{$url}'
    };
    var uploadOptions = uploadOptions || {};
    // Merge with upload plugin options
    jQuery.extend(options, uploadOptions);
    CKEDITOR.replace('{$id}', options);
EOT;
echo $this->Html->scriptEnd();
