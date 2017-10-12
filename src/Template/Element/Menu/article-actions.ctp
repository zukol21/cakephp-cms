<?php
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
