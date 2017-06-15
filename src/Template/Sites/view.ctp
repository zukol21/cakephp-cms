<?php use Cake\Event\Event; ?>
<section class="content-header">
    <h1><?= h($site->name) ?> <small><?= $searchTitle ?></small></h1>
    <div class="btn-group btn-group-sm toolbox pull-right" role="group">
        <?= $this->element('Sites/toolbar', ['site' => $site, 'user' => $user]) ?>
    </div>
</section>
<section class="content">
    <?php
    $element = $this->element('Sites/manage', [
        'articles' => $site->articles,
        'categories' => $categories,
        'site' => $site,
        'article' => null,
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
                    <?= $this->element('Categories/sidebar', ['categories' => $site->categories, 'site' => $site]) ?>
                </div>
                <div class="col-xs-6 col-md-12">
                    <?= $this->element('Types/sidebar', ['types' => $types, 'site' => $site]) ?>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-md-7 col-md-offset-1 col-md-pull-3">
            <?= $this->element('Articles/list', [
                'site' => $site,
                'articles' => $site->articles,
                'articleTypes' => $types
            ]) ?>
        </div>
    </div>
</section>