<?php use Cake\Event\Event; ?>
<?php $this->start('article-box-classes') ?>
<?php $this->end() ?>
<?php $this->start('article-header') ?>
    <i class="fa fa-<?= $types[$element['data']['article']->type]['icon'] ?> text-muted"></i>
    <h3 class="box-title">
    <?= $this->Html->link(
        $this->Text->truncate($element['data']['article']->title, 35, ['exact' => false]),
        [
            'controller' => 'Articles',
            'action' => 'view',
            $element['data']['article']->site->slug,
            $element['data']['article']->type,
            $element['data']['article']->slug
        ],
        ['title' => h($element['data']['article']->title)]
    ) ?></h3>
<?php $this->end() ?>
<?php $this->start('article-action-buttons') ?>
    <?php
    $buttons = [];
    $buttons[] = [
        'html' => $this->Html->link('<i class="fa fa-pencil"></i>', '#', [
            'title' => __('Edit'),
            'class' => 'btn btn-box-tool',
            'escape' => false,
            'data-toggle' => 'modal',
            'data-target' => '#' . $element['data']['article']->slug
        ]),
        'url' => ['plugin' => 'Cms', 'controller' => 'Sites', 'action' => 'edit', 'pass' => [$site->id]]
    ];
    $buttons[] = [
        'html' => $this->Form->postLink(
            '<i class="fa fa-trash"></i>',
            [
                'controller' => 'Articles',
                'action' => 'delete',
                $element['data']['article']->site->slug,
                $element['data']['article']->slug
            ],
            [
                'confirm' => __('Are you sure you want to delete # {0}?', $element['data']['article']->title),
                'title' => __('Delete'),
                'class' => 'btn btn-box-tool',
                'escape' => false
            ]
        ),
        'url' => ['plugin' => 'Cms', 'controller' => 'Sites', 'action' => 'edit', 'pass' => [$site->id]]
    ];

    $event = new Event('Cms.View.element.beforeRender', $this, [
        'menu' => $buttons,
        'user' => $user
    ]);
    $this->eventManager()->dispatch($event);

    echo $event->result;
    ?>
<?php $this->end() ?>
<?php $this->start('article-body') ?>
<?php $this->end() ?>
<?php $this->start('article-footer') ?>
    <div class="text-muted text-right">
    <?php
    if ('type' === $this->request->action) {
        $assocUrl = $this->Html->link($element['data']['article']->category->name, [
            'controller' => 'Categories',
            'action' => 'view',
            $element['data']['article']->site->slug,
            $element['data']['article']->category->slug
        ]);
    } else {
        $assocUrl = $this->Html->link($types[$element['data']['article']->type]['label'], [
            'controller' => 'Articles',
            'action' => 'type',
            $element['data']['article']->site->slug,
            $element['data']['article']->type
        ]);
    }
    ?>
    <?= $assocUrl ?>
    |
    <?= __('Published') ?>
    <?= $element['data']['article']->publish_date->timeAgoInWords([
        'format' => 'MMM d, YYY',
        'end' => '1 month'
    ]) ?>
    </div>
<?php $this->end() ?>