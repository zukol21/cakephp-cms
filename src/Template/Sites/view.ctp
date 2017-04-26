<?php use Cake\Event\Event; ?>
<section class="content-header">
    <div class="row">
        <div class="col-xs-12 col-md-6">
            <h4><?= h($site->name) ?></h4>
        </div>
        <div class="col-xs-12 col-md-6">
            <div class="pull-right">
                <div class="btn-group btn-group-sm" role="group">
                <?php
                $event = new Event('Cms.View.topMenu.beforeRender', $this, [
                    'menu' => [],
                    'user' => $user
                ]);
                $this->eventManager()->dispatch($event);

                echo $event->result;
                ?>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="content">
    <?php
    $element = $this->element('Sites/manage', [
        'categories' => $categories,
        'site' => $site,
        'article' => $article,
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
            <?= $this->element('Articles/list', [
                'articles' => $site->articles,
                'articleTypes' => $types
            ]) ?>
            <?php
            $element = $this->element('Articles/modal', [
                'articles' => $site->articles,
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