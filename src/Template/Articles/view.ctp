<?php
$this->Breadcrumbs->templates([
    'separator' => '',
]);
$this->Breadcrumbs->add($article->site->name);
$this->Breadcrumbs->add($article->category->name, [
    'controller' => 'Categories',
    'action' => 'view',
    $article->site->slug,
    $article->category->slug
]);
$this->Breadcrumbs->add($types[$article->type]['label'], [
    'controller' => 'Articles',
    'action' => 'type',
    $article->site->slug,
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
    <?= $this->element('Articles/new', [
        'categories' => $categories,
        'site' => $article->site,
        'article' => $newArticle,
        'articleTypes' => $types
    ]) ?>
    <?= $this->element('Articles/single', [
        'article' => $article,
        'articleTypes' => $types
    ]) ?>
    <?= $this->element('Articles/modal', [
        'categories' => $categories,
        'articles' => [$article],
        'articleTypes' => $types
    ]) ?>
</section>