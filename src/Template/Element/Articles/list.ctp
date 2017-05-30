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
        <div class="box box-<?= !$isPublished ? 'danger' : 'solid' ?> list-item <?= $this->fetch('article-box-classes') ?>">
            <?= $this->fetch('article-header-start') ?>
                <?= $this->fetch('article-header') ?>
                <?= $this->fetch('article-action-buttons-start') ?>
                    <?= $this->fetch('article-action-buttons') ?>
                <?= $this->fetch('article-action-buttons-end') ?>
            <?= $this->fetch('article-header-end') ?>
            <div class="box-body">
                <?= $this->fetch('article-body') ?>
            </div>
            <?= $this->fetch('article-footer') ?>
        </div>
    </div>
<?php endforeach; ?>
</div>