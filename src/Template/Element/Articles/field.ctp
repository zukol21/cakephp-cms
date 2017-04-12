<?php
// echo fields
foreach ($typeOptions['fields'] as $field => $options) {
    $fieldName = $options['field'];
    $inputOptions = [
        'type' => $options['renderAs'],
        'label' => $field,
        'required' => (bool)$options['required']
    ];

    // case by type
    switch ($options['renderAs']) {
        case 'file':
            $fieldName = 'file';
            $inputOptions['escape'] = false;
            if (!empty($article->article_featured_images[0])) {
                $inputOptions['required'] = false;
                $inputOptions['label'] .= '&nbsp;';
                $inputOptions['label'] .= $this->Html->image($article->article_featured_images[0]->path, [
                    'class' => 'img-circle',
                    'style' => 'height: 20px; width 20px;'
                ]);
            }
            break;

        case 'select':
            $inputOptions['options'] = $options['options'];
            $inputOptions['class'] = 'select2';
            break;

        case 'textarea':
            if ((bool)$options['editor']) {
                $inputOptions['class'] = 'tinymce';
                $inputOptions['required'] = false;
            }
            break;

        default:
            //
            break;
    }

    echo $this->Form->input($fieldName, $inputOptions);
}

// load tinyMCE if needed
$loadedEditor = false;
foreach ($typeOptions['fields'] as $field => $options) {
    if (!(bool)$options['editor']) {
        continue;
    }

    if (!$loadedEditor) {
        $loadedEditor = true;
        echo $this->element('Cms.tinymce');
    }
}
