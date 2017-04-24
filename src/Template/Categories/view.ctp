<?php
$this->Breadcrumbs->templates([
    'separator' => '',
]);
$this->Breadcrumbs->add($category->site->name, [
    'controller' => 'Sites',
    'action' => 'view',
    $category->site->slug,
]);
$this->Breadcrumbs->add($category->name, null, ['class' => 'active']);
?>
<section class="content-header">
    <h1><?= h($category->name) ?></h1>
    <?= $this->Breadcrumbs->render(
        ['class' => 'breadcrumb'],
        ['separator' => false]
    ) ?>
</section>
<section class="content">
    <?= $this->element('Articles/new', [
        'categories' => $categories,
        'site' => $category->site,
        'article' => $article,
        'articleTypes' => $types
    ]) ?>
    <?= $this->element('Articles/list', [
        'articles' => $category->articles,
        'articleTypes' => $types
    ]) ?>
    <?= $this->element('Articles/modal', [
        'articles' => $category->articles,
        'articleTypes' => $types,
        'categories' => $categories
    ]) ?>
</section>