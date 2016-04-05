<?php
// I am useless without an id.
if (!isset($id) && empty($id)) {
    return false;
}
echo $this->Html->script('//cdn.ckeditor.com/4.5.7/standard-all/ckeditor.js', ['block' => 'scriptBottom']);
echo $this->Html->script('Cms.ckeditor-upload-plugin', ['block' => 'scriptBottom']);
echo $this->Html->scriptStart(['block' => 'scriptBottom']); ?>
<?php
echo <<<EOT
    var options = {};
    // Merge options
    var uploadOptions = uploadOptions || {};
    jQuery.extend(options, uploadOptions);
    CKEDITOR.replace('{$id}', options);
EOT;
echo $this->Html->scriptEnd();
