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

$isPublished = $article->publish_date <= Time::now();

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
    <?= $this->element('Cms./Menu/article-actions', ['site' => $site, 'article' => $article]) ?>
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
    if ('type' === $this->request->getParam('action')) {
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
