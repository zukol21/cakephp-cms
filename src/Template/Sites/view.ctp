<section class="content-header">
    <h1><?= h($site->name) ?> <small><?= __('Site') ?></small></h1>
</section>
<section class="content">
    <div class="row">
        <div class="col-lg-4">
            <div class="box box-solid">
                <div class="box-header with-border">
                    <i class="fa fa-info"></i>
                    <h3 class="box-title">Details</h3>
                </div>
                <div class="box-body">
                    <dl class="dl-horizontal">
                        <dt><?= __('Name') ?></dt>
                        <dd><?= h($site->name) ?></dd>
                        <dt><?= __('Slug') ?></dt>
                        <dd><?= h($site->slug) ?></dd>
                        <dt><?= __('Active') ?></dt>
                        <dd><?= $site->active ? __('Yes') : __('No'); ?></dd>
                    </dl>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="nav-tabs-custom">
                <ul id="relatedTabs" class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active">
                        <a href="#related-categories" aria-controls="related-categories" role="tab" data-toggle="tab">
                            <?= __('Related Categories'); ?>
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="related-categories">
                        <?php if (!empty($site->categories)) : ?>
                        <table class="table table-hover table-condensed table-vertical-align">
                            <thead>
                                <tr>
                                    <th><?= __('Name') ?></th>
                                    <th><?= __('Slug') ?></th>
                                    <th class="actions"><?= __('Actions') ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($site->categories as $category) : ?>
                                <tr>
                                    <td><?= $category->node ?></td>
                                    <td><?= h($category->slug) ?></td>
                                    <td class="actions">
                                        <div class="btn-toolbar" role="toolbar">
                                            <div class="btn-group btn-group-xs" role="group">
                                            <?= $this->Html->link(
                                                '<i class="fa fa-eye"></i>',
                                                ['controller' => 'Categories', 'action' => 'view', $site->slug, $category->slug],
                                                ['title' => __('View'), 'class' => 'btn btn-default', 'escape' => false]
                                            ) ?>
                                            <?= $this->Html->link(
                                                '<i class="fa fa-pencil"></i>',
                                                ['controller' => 'Categories', 'action' => 'edit', $site->slug, $category->slug],
                                                ['title' => __('Edit'), 'class' => 'btn btn-default', 'escape' => false]
                                            ) ?>
                                            <?= $this->Form->postLink(
                                                '<i class="fa fa-trash"></i>',
                                                ['controller' => 'Categories', 'action' => 'delete', $site->slug, $category->slug],
                                                [
                                                    'confirm' => __('Are you sure you want to delete # {0}?', $category->name),
                                                    'title' => __('Delete'),
                                                    'class' => 'btn btn-default',
                                                    'escape' => false
                                                ]
                                            ) ?>
                                            </div>
                                            <?php if ($category->parent_id) : ?>
                                            <div class="btn-group btn-group-xs" role="group">
                                                <?= $this->Form->postLink(
                                                    '<i class="fa fa-arrow-up"></i>',
                                                    ['controller' => 'Categories', 'action' => 'moveNode', $site->slug, $category->slug, 'up'],
                                                    ['title' => __('Move up'), 'class' => 'btn btn-default', 'escape' => false]
                                                ) ?>
                                                <?= $this->Form->postLink(
                                                    '<i class="fa fa-arrow-down"></i>',
                                                    ['controller' => 'Categories', 'action' => 'moveNode', $site->slug, $category->slug, 'down'],
                                                    ['title' => __('Move down'), 'class' => 'btn btn-default', 'escape' => false]
                                                ) ?>
                                            </div>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?= $this->element('Articles/new', [
        'categories' => $categories,
        'site' => $site,
        'article' => $article,
        'articleTypes' => $types
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
                'articles' => $site->articles,
                'articleTypes' => $types
            ]) ?>
            <?= $this->element('Articles/modal', [
                'articles' => $site->articles,
                'articleTypes' => $types,
                'categories' => $categories
            ]) ?>
        </div>
    </div>
</section>