<?php use Cake\Utility\Inflector; ?>
<div class="box box-solid">
    <div class="box-header with-border">
        <i class="fa fa-<?= $types[$article->type]['icon'] ?>"></i>
        <h3 class="box-title"><?= $article->title ? $article->title : Inflector::humanize($article->type) ?></h3>
        <div class="box-tools pull-right">
            <?= $this->Html->link(
                '<i class="fa fa-pencil"></i>',
                ['controller' => 'Articles', 'action' => 'edit', $article->site->slug, $article->type, $article->slug],
                ['title' => __('Edit'), 'class' => 'btn btn-box-tool', 'escape' => false]
            ) ?>
        </div>
    </div>
    <div class="box-body">
    <?php foreach ($types[$article->type]['fields'] as $field => $options) : ?>
        <?php
        if (!$article->{$options['field']}) {
            continue;
        } ?>
        <div class="row">
            <div class="col-xs-12 col-md-4">
                <div class="text-right hidden-xs hidden-sm"><strong><?= h($field) ?></strong></div>
                <div class="hidden-md hidden-lg"><strong><?= h($field) ?></strong></div>
            </div>
            <div class="col-xs-12 col-md-8"><?= h($article->{$options['field']}) ?></div>
        </div>
    <?php endforeach; ?>
    </div>
    <div class="box-footer small">
        <div class="row">
            <div class="col-xs-4">
            </div>
            <div class="col-xs-4 text-center">
                <?= $this->Html->link(__('MORE'), [
                    'controller' => 'Articles',
                    'action' => 'view',
                    $article->site->slug,
                    $article->slug
                ]) ?>
            </div>
            <div class="col-xs-4 text-muted text-right">
                <?= $article->publish_date->format('Y-m-d H:m') ?>
            </div>
        </div>
    </div>
</div>
