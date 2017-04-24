<?php
$this->Breadcrumbs->templates([
    'separator' => '',
]);
$this->Breadcrumbs->add($site->name, [
    'controller' => 'Sites',
    'action' => 'view',
    $site->slug
]);
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
        'articleTypes' => [$type => $types[$type]]
    ]) ?>
    <hr />
    <div class="row">
        <div class="col-xs-12 col-md-3 col-md-push-9">
            <div class="row">
                <div class="col-xs-6 col-md-12">
                    <?= $this->element('Categories/list', ['categories' => $site->categories, 'site' => $site]) ?>
                </div>
                <div class="col-xs-6 col-md-12">
                    <?= $this->element('Types/list', ['types' => $types, 'site' => $site]) ?>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-md-7 col-md-offset-1 col-md-pull-3">
            <?= $this->element('Articles/list', [
                'articles' => $articles,
                'articleTypes' => $types
            ]) ?>
            <?= $this->element('Articles/modal', [
                'categories' => $categories,
                'articles' => $articles,
                'articleTypes' => $types
            ]) ?>
        </div>
    </div>
</section>