<?php
use Cake\Utility\Inflector;

$elements = [];
foreach ($articles as $article) {
    $element = 'Plugin/Cms/' . Inflector::camelize($article->type) . '/list';

    // fallback to plugin's element
    if (!$this->elementExists($element)) {
        $element = Inflector::camelize($article->type) . '/list';
    }

    // fallback to default element
    if (!$this->elementExists($element)) {
        $element = 'Common/list';
    }

    $elements[] = [
        'name' => $element,
        'data' => [
            'types' => $types,
            'article' => $article
        ]
    ];
}
?>
<div class ="row masonry-container">
<?php foreach ($elements as $element) : ?>
    <?= $this->element('Articles/blocks', ['element' => $element, 'types' => $types]) ?>
    <?= $this->element($element['name'], $element['data']) ?>
    <div class="col-xs-12 item">
        <div class="box box-solid <?= $this->fetch('article-box-classes') ?>">
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