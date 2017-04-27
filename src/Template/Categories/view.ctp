<?php
use Cake\Event\Event;

$this->Breadcrumbs->templates([
    'separator' => '',
]);
$this->Breadcrumbs->add($site->name, [
    'controller' => 'Sites',
    'action' => 'view',
    $site->slug,
]);
$this->Breadcrumbs->add($category->name, null, ['class' => 'active']);
?>
<section class="content-header">
    <h1><?= h($category->name) ?> <small><?= __('Category') ?></small></h1>
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
        'article' => $article,
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
                'site' => $site,
                'articles' => $category->articles,
                'articleTypes' => $types
            ]) ?>
            <?php
            $element = $this->element('Articles/modal', [
                'site' => $site,
                'articles' => $category->articles,
                'articleTypes' => $types,
                'categories' => $categories
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
        </div>
    </div>
</section>