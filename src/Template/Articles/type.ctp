<?php
$this->Breadcrumbs->templates([
    'separator' => '',
]);
$this->Breadcrumbs->add($site->name);
$this->Breadcrumbs->add($types[$type]['label'], null, ['class' => 'active']);
?>
<section class="content-header">
    <h1><?= h($types[$type]['label']) ?></h1>
    <?= $this->Breadcrumbs->render(
        ['class' => 'breadcrumb'],
        ['separator' => false]
    ) ?>
</section>
<section class="content">
    <?= $this->element('Articles/new', [
        'categories' => $categories,
        'site' => $site,
        'article' => $article,
        'articleTypes' => $types
    ]) ?>
    <?= $this->element('Articles/list', [
        'articles' => $articles,
        'articleTypes' => $types
    ]) ?>
</section>