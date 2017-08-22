<?php
use Cake\Event\Event;
use Cms\Event\EventName;

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
    <h1><?= h($types[$type]['label']) ?> <small><?= $searchTitle ?></small></h1>
    <?= $this->Breadcrumbs->render(
        ['class' => 'breadcrumb'],
        ['separator' => false]
    ) ?>
</section>
<section class="content">
    <?php
    $element = $this->element('Sites/manage', [
        'articles' => $articles,
        'categories' => $categories,
        'site' => $site,
        'article' => null,
        'types' => $types
    ]);
    $event = new Event((string)EventName::VIEW_MANAGE_BEFORE_RENDER(), $this, [
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
            <?= $this->element('Cms.sidebar') ?>
        </div>
        <div class="col-xs-12 col-md-7 col-md-offset-1 col-md-pull-3">
            <?= $this->element('Articles/list', [
                'site' => $site,
                'articles' => $articles,
                'articleTypes' => $types
            ]) ?>
        </div>
    </div>
</section>