<?php
use Cake\I18n\Time;
use Cake\Utility\Inflector;

$elements = [];
foreach ($articles as $article) {
    $element = 'Plugin/Cms/' . Inflector::camelize($article->type) . '/list';

    // fallback to plugin's element
    if (!$this->elementExists($element)) {
        $element = 'Types/' . Inflector::camelize($article->type) . '/list';
    }

    // fallback to default element
    if (!$this->elementExists($element)) {
        $element = 'Types/Common/list';
    }

    $elements[] = [
        'name' => $element,
        'article' => $article
    ];
}
?>
<div class ="row masonry-container">
<?php foreach ($elements as $element) : ?>
    <?php $isPublished = $element['article']->publish_date <= Time::now() ?>
    <?= $this->element('Articles/blocks', [
        'site' => $site,
        'article' => $element['article'],
        'types' => $types
    ]) ?>
    <?= $this->element($element['name'], [
        'site' => $site,
        'article' => $element['article'],
        'types' => $types
    ]) ?>
    <div class="col-xs-12 item">
        <div class="box box-<?= !$isPublished ? 'danger' : 'solid' ?> <?= $this->fetch('article-box-classes') ?>">
            <div class="box-header with-border">
                <?= $this->fetch('article-header') ?>
                <div class="box-tools pull-right">
                    <?= $this->fetch('article-action-buttons') ?>
                </div>
            </div>
            <div class="box-body">
            <?= $this->fetch('article-body') ?>
            </div>
            <div class="box-footer small">
                <?= $this->fetch('article-footer') ?>
            </div>
        </div>
    </div>
<?php endforeach; ?>
</div>