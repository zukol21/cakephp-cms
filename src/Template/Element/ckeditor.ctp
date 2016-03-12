<?php
// I am useless without an id.
if (!isset($id) && empty($id)) {
    return false;
}
echo $this->Html->script('//cdn.ckeditor.com/4.5.7/standard-all/ckeditor.js', ['block' => 'scriptBottom']);
echo $this->Html->scriptStart(['block' => 'scriptBottom']);
// When there is an upload URL then we can enable
// CKeditor's Image Paste plugin which allows to upload pasted or dropped images
// @link: http://ckeditor.com/addon/imagepaste
if (isset($url) && !empty($url)) {
    echo <<<EOT
        var options = {
            extraPlugins: 'uploadimage,image2',
            // Load the default contents.css file plus customizations for this sample.
            contentsCss: [ CKEDITOR.basePath + 'contents.css', 'http://sdk.ckeditor.com/samples/assets/css/widgetstyles.css' ],
            uploadUrl: '{$url}',
            // Configure the Enhanced Image plugin to use classes instead of styles and to disable the
            // resizer (because image size is controlled by widget styles or the image takes maximum
            // 100% of the editor width).
            image2_alignClasses: ['text-left', 'text-center', 'text-right'],
            image2_disableResizer: true
        };
EOT;
}

echo <<<EOT
    if (typeof options === 'undefined') {
        var options = {};
    }
    CKEDITOR.replace('{$id}', options);
EOT;
echo $this->Html->scriptEnd();
