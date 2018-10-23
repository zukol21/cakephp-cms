<?php
/**
 * Copyright (c) Qobo Ltd. (https://www.qobo.biz)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Qobo Ltd. (https://www.qobo.biz)
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

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
        echo $this->element('Qobo/Cms.tinymce');
    }
}
