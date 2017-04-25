<?php
use Cake\Utility\Inflector;

$element = 'Plugin/Cms/' . Inflector::camelize($article->type) . '/single';

// fallback to plugin's element
if (!$this->elementExists($element)) {
    $element = 'Types/' . Inflector::camelize($article->type) . '/single';
}

// fallback to default element
if (!$this->elementExists($element)) {
    $element = 'Types/Common/single';
}

$data = ['article' => $article];
?>
<div class="row">
    <div class="col-xs-12">
        <div class="box box-solid">
            <div class="box-header with-border">
                <i class="fa fa-<?= $articleTypes[$article->type]['icon'] ?>"></i>
                <h3 class="box-title"><?= $article->title ?></h3>
                <div class="box-tools pull-right">
                    <?= $this->Html->link('<i class="fa fa-pencil"></i>', '#', [
                        'title' => __('Edit'),
                        'class' => 'btn btn-box-tool',
                        'escape' => false,
                        'data-toggle' => 'modal',
                        'data-target' => '#' . $article->slug
                    ]) ?>
                    <?= $this->Form->postLink(
                        '<i class="fa fa-trash"></i>',
                        [
                            'controller' => 'Articles',
                            'action' => 'delete',
                            $article->site->slug,
                            $article->slug
                        ],
                        [
                            'confirm' => __('Are you sure you want to delete # {0}?', $article->title),
                            'title' => __('Delete'),
                            'class' => 'btn btn-box-tool',
                            'escape' => false
                        ]
                    ) ?>
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
                    $article->site->slug,
                    $article->category->slug
                ]) ?>
                |
                <?= __('Published') ?>
                <?= $article->publish_date->timeAgoInWords([
                    'format' => 'MMM d, YYY | HH:mm',
                    'end' => '1 month'
                ]) ?>
                </div>
            </div>
        </div>
    </div>
</div>