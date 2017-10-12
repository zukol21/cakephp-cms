<?php
/**
 * Copyright (c) Qobo Ltd. (https://www.qobo.biz)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Qobo Ltd. (https://www.qobo.biz)
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

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
    <?= $this->element('Cms.Articles/blocks', [
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
