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

$this->Breadcrumbs->templates([
    'separator' => '',
]);
$this->Breadcrumbs->add($site->name, [
    'controller' => 'Sites',
    'action' => 'view',
    $site->slug
]);
$this->Breadcrumbs->add($article->category->name, [
    'controller' => 'Categories',
    'action' => 'view',
    $site->slug,
    $article->category->slug
]);
$this->Breadcrumbs->add($types[$article->type]['label'], [
    'controller' => 'Articles',
    'action' => 'type',
    $site->slug,
    $article->type
]);
$this->Breadcrumbs->add($article->title, null, ['class' => 'active']);
?>
<section class="content-header">
    <h1><?= h($article->title) ?></h1>
    <?= $this->Breadcrumbs->render(
        ['class' => 'breadcrumb'],
        ['separator' => false]
    ) ?>
</section>
<section class="content">
    <?= $this->element('Qobo/Cms.Sites/manage', [
        'articles' => [$article],
        'categories' => $categories,
        'site' => $site,
        'article' => null,
        'types' => $types
    ]) ?>
    <div class="row">
        <div class="col-xs-12 col-md-3 col-md-push-9">
            <?= $this->element('Qobo/Cms.sidebar') ?>
        </div>
        <div class="col-xs-12 col-md-7 col-md-offset-1 col-md-pull-3">
            <?= $this->element('Qobo/Cms.Articles/single', [
                'site' => $site,
                'article' => $article,
                'articleTypes' => $types
            ]) ?>
        </div>
</section>
