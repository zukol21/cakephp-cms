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

// edit button
echo $this->Html->link('<i class="fa fa-pencil"></i> ' . __('Edit'), '#', [
    'title' => __('Edit Site'),
    'class' => 'btn btn-default',
    'data-toggle' => 'modal',
    'data-target' => '#cms-site-edit' . $site->id,
    'escape' => false
]) . $this->element('Qobo/Cms.Sites/modal', ['site' => $site]);

// delete button
echo $this->Form->postLink(
    '<i class="fa fa-trash"></i> ' . __('Delete'),
    ['action' => 'delete', $site->id],
    [
        'confirm' => __('Are you sure you want to delete # {0}?', $site->name),
        'title' => __('Delete Site'),
        'class' => 'btn btn-default',
        'escape' => false
    ]
);
