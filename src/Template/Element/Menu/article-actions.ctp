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

echo $this->Html->link('<i class="fa fa-pencil"></i>', '#', [
    'title' => __('Edit'),
    'class' => 'btn btn-box-tool',
    'escape' => false,
    'data-toggle' => 'modal',
    'data-target' => '#' . $article->get('slug')
]);
echo $this->Form->postLink(
    '<i class="fa fa-trash"></i>',
    ['controller' => 'Articles', 'action' => 'delete', $site->get('slug'), $article->get('slug')],
    [
        'confirm' => __('Are you sure you want to delete # {0}?', $article->get('title')),
        'title' => __('Delete'),
        'class' => 'btn btn-box-tool',
        'escape' => false
    ]
);
