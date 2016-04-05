<?php
// I am useless without an id.
if (!isset($id) && empty($id)) {
    return false;
}
echo $this->Html->script('//cdn.ckeditor.com/4.5.8/full-all/ckeditor.js', ['block' => 'scriptBottom']);
echo $this->Html->script('Cms.ckeditor-upload-plugin', ['block' => 'scriptBottom']);
echo $this->Html->scriptStart(['block' => 'scriptBottom']); ?>
<?php
$url = $this->Url->script('Cms.ckeditor-config');
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
