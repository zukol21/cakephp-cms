<?php
use Cake\Event\Event;
use Cms\Event\EventName;

$menu = [];

// edit button
$menu[] = [
    'url' => [
        'plugin' => 'Cms',
        'controller' => 'Sites',
        'action' => 'edit',
        $site->id
    ],
    'html' => $this->Html->link('<i class="fa fa-pencil"></i> ' . __('Edit'), '#', [
        'title' => __('Edit Site'),
        'class' => 'btn btn-default',
        'data-toggle' => 'modal',
        'data-target' => '#cms-site-edit' . $site->id,
        'escape' => false
    ]) . $this->element('Sites/modal', ['site' => $site])
];

// delete button
$menu[] = [
    'url' => [
        'plugin' => 'Cms',
        'controller' => 'Sites',
        'action' => 'delete',
        $site->id
    ],
    'html' => $this->Form->postLink(
        '<i class="fa fa-trash"></i> ' . __('Delete'),
        ['action' => 'delete', $site->id],
        [
            'confirm' => __('Are you sure you want to delete # {0}?', $site->name),
            'title' => __('Delete Site'),
            'class' => 'btn btn-default',
            'escape' => false
        ]
    )
];

$event = new Event((string)EventName::VIEW_TOOLBAR_BEFORE_RENDER(), $this, [
    'menu' => $menu,
    'user' => $user
]);
$this->eventManager()->dispatch($event);

echo $event->result;
