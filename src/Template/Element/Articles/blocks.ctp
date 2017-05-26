<?php
use Cake\Event\Event;
use Cake\I18n\Time;

$isPublished = $article->publish_date <= Time::now();

$buttons = [];
$buttons[] = [
    'html' => $this->Html->link('<i class="fa fa-pencil"></i>', '#', [
        'title' => __('Edit'),
        'class' => 'btn btn-box-tool',
        'escape' => false,
        'data-toggle' => 'modal',
        'data-target' => '#' . $article->slug
    ]),
    'url' => ['plugin' => 'Cms', 'controller' => 'Sites', 'action' => 'edit', 'pass' => [$site->id]]
];
$buttons[] = [
    'html' => $this->Form->postLink(
        '<i class="fa fa-trash"></i>',
        [
            'controller' => 'Articles',
            'action' => 'delete',
            $site->slug,
            $article->slug
        ],
        [
            'confirm' => __('Are you sure you want to delete # {0}?', $article->title),
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

$actionButtons = $event->result;

/**
 * BLOCK: Article action buttons start
 */
$this->start('article-action-buttons-start') ?>
    <div class="box-tools pull-right">
<?php $this->end();

/**
 * BLOCK: Article action buttons
 */
$this->start('article-action-buttons'); ?>
    <?= $actionButtons ?>
<?php
$this->end();

/**
 * BLOCK: Article action buttons end
 */
$this->start('article-action-buttons-end') ?>
    </div>
<?php $this->end();

/**
 * BLOCK: Article header start
 */
$this->start('article-header-start') ?>
    <div class="box-header with-border">
<?php $this->end();

/**
 * BLOCK: Article header
 */
$this->start('article-header') ?>
    <i class="fa fa-<?= $types[$article->type]['icon'] ?> text-muted"></i>
    <h3 class="box-title">
    <?= $this->Html->link(
        $this->Text->truncate($article->title, 35, ['exact' => false]),
        [
            'controller' => 'Articles',
            'action' => 'view',
            $site->slug,
            $article->type,
            $article->slug
        ],
        ['title' => h($article->title)]
    ) ?></h3>
<?php $this->end();

/**
 * BLOCK: Article header end
 */
$this->start('article-header-end') ?>
    </div>
<?php $this->end();

/**
 * BLOCK: Article body
 */
$this->start('article-body');
$this->end();

/**
 * BLOCK: Article footer
 */
$this->start('article-footer')
?>
<div class="box-footer small">
    <div class="text-muted text-right">
    <?php
    if ('type' === $this->request->action) {
        $assocUrl = $this->Html->link($article->category->name, [
            'controller' => 'Categories',
            'action' => 'view',
            $site->slug,
            $article->category->slug
        ]);
    } else {
        $assocUrl = $this->Html->link($types[$article->type]['label'], [
            'controller' => 'Articles',
            'action' => 'type',
            $site->slug,
            $article->type
        ]);
    }
    ?>
    <?= $assocUrl ?>
    |
    <?php if ($isPublished) : ?>
        <?= __('Published') ?>
        <?= $article->publish_date->timeAgoInWords([
            'format' => 'MMM d, YYY',
            'end' => '1 month'
        ]) ?>
    <?php else : ?>
        <?= __('Unpublished') ?> <i class="fa fa-eye-slash text-danger"></i>
    <?php endif; ?>
    </div>
</div>
<?php
$this->end();

/**
 * BLOCK: Article box classes
 */
$this->start('article-box-classes');
$this->end();
