<?php
use Cake\Event\Event;
use Cake\I18n\Time;
use Cake\Utility\Inflector;
use Cms\View\Shortcode;

// load lightbox library
$this->Html->css('Qobo/Utils./plugins/lightbox2/css/lightbox.min', ['block' => 'css']);
$this->Html->script('Qobo/Utils./plugins/lightbox2/js/lightbox.min', ['block' => 'scriptBottom']);

$element = 'Plugin/Cms/' . Inflector::camelize($article->type) . '/single';

// fallback to plugin's element
if (!$this->elementExists($element)) {
    $element = 'Types/' . Inflector::camelize($article->type) . '/single';
}

// fallback to default element
if (!$this->elementExists($element)) {
    $element = 'Types/Common/single';
}

if (!empty($types[$article->type]['fields'])) {
    $article = Shortcode::parse($article, $types[$article->type]['fields'], $this);
}

$data = ['article' => $article];

$isPublished = $article->publish_date <= Time::now();
?>
<div class="row">
    <div class="col-xs-12">
        <div class="box box-<?= $isPublished ? 'solid' : 'danger' ?> single-item">
            <div class="box-header with-border">
                <i class="fa fa-<?= $articleTypes[$article->type]['icon'] ?>"></i>
                <h3 class="box-title"><?= $article->title ?></h3>
                <div class="box-tools pull-right">
                    <?php
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

                    echo $event->result;
                    ?>
                </div>
            </div>
            <div class="box-body">
                <?= $this->element($element, $data); ?>
            </div>
            <div class="box-footer small">
                <div class="text-right text-muted">
                <?= $this->Html->link($article->category->name, [
                    'controller' => 'Categories',
                    'action' => 'view',
                    $site->slug,
                    $article->category->slug
                ]) ?>
                |
                <?php if ($isPublished) : ?>
                    <?= __('Published') ?>
                    <?= $article->publish_date->timeAgoInWords([
                        'format' => 'MMM d, YYY | HH:mm',
                        'end' => '1 month'
                    ]) ?>
                <?php else : ?>
                    <?= __('Unpublished') ?> <i class="fa fa-eye-slash text-danger"></i>
                <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>