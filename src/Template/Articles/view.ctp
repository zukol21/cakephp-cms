<?php
use Cake\Event\Event;

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
    <h4><?= h($article->title) ?></h4>
    <?= $this->Breadcrumbs->render(
        ['class' => 'breadcrumb'],
        ['separator' => false]
    ) ?>
</section>
<section class="content">
    <?php
    $element = $this->element('Sites/manage', [
        'articles' => [$article],
        'categories' => $categories,
        'site' => $site,
        'article' => $newArticle,
        'types' => $types
    ]);
    $event = new Event('Cms.View.element.beforeRender', $this, [
        'menu' => [
            [
                'url' => ['plugin' => 'Cms', 'controller' => 'Sites', 'action' => 'edit', 'pass' => [$site->id]],
                'html' => $element
            ]
        ],
        'user' => $user
    ]);
    $this->eventManager()->dispatch($event);

    echo $event->result;
    ?>
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
            <?= $this->element('Articles/single', [
                'site' => $site,
                'article' => $article,
                'articleTypes' => $types
            ]) ?>
        </div>
</section>