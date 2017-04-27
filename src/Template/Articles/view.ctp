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
    <h1><?= h($article->title) ?></h1>
    <?= $this->Breadcrumbs->render(
        ['class' => 'breadcrumb'],
        ['separator' => false]
    ) ?>
</section>
<section class="content">
    <?php
    $element = $this->element('Articles/new', [
        'categories' => $categories,
        'site' => $site,
        'article' => $newArticle,
        'articleTypes' => $types
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

    echo $event->result ? $event->result . '<hr />' : '';
    ?>
    <?= $this->element('Articles/single', [
        'site' => $site,
        'article' => $article,
        'articleTypes' => $types
    ]) ?>
    <?php
    $element = $this->element('Articles/modal', [
        'categories' => $categories,
        'articles' => [$article],
        'articleTypes' => $types
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
</section>