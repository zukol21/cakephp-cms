<?php
use Cake\Utility\Inflector;

$element = 'Plugin/Cms/' . Inflector::camelize($article->type) . '/single';

// fallback to plugin's element
if (!$this->elementExists($element)) {
    $element = Inflector::camelize($article->type) . '/single';
}

// fallback to default element
if (!$this->elementExists($element)) {
    $element = 'Common/single';
}

$data = ['article' => $article];
?>
<div class="row">
    <div class="col-xs-12">
        <div class="box box-solid">
            <div class="box-header with-border">
                <h3 class="box-title"><?= $article->title ?></h3>
                <div class="box-tools pull-right">
                    <?= $this->Html->link('<i class="fa fa-pencil"></i>', '#', [
                        'title' => __('Edit'),
                        'class' => 'btn btn-box-tool',
                        'escape' => false,
                        'data-toggle' => 'modal',
                        'data-target' => '#' . $article->slug
                    ]) ?>
                </div>
            </div>
            <div class="box-body">
                <?= $this->element($element, $data); ?>
            </div>
            <div class="box-footer small">
                <div class="text-right text-muted">
                <?= $this->Html->link(Inflector::humanize($article->category->slug), [
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

<div class="modal fade" id="<?= $article->slug ?>" tabindex="-1" role="dialog" aria-labelledby="<?= $article->slug ?>Label">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="<?= $article->slug ?>Label">
                    <?= __('Edit') ?> <?= $article->title ? $article->title : Inflector::humanize($article->type) ?>
                </h4>
            </div>
            <div class="modal-body">
                <?= $this->element('Articles/post', [
                    'url' => [
                        'controller' => 'Articles',
                        'action' => 'edit',
                        $article->site->slug,
                        $article->type,
                        $article->slug
                    ],
                    'article' => $article,
                    'typeOptions' => $articleTypes[$article->type]
                ]); ?>
            </div>
        </div>
    </div>
</div>