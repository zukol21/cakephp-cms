<?= $this->element('Articles/modal', [
    'site' => $site,
    'articles' => $articles,
    'types' => $types,
    'categories' => $categories
]) ?>
<?= $this->element('Categories/modal', [
    'site' => $site,
    'categories' => $site->categories,
    'categoriesTree' => $categories
]) ?>
<div class="nav-tabs-custom">
    <ul id="relatedTabs" class="nav nav-tabs" role="tablist">
        <li role="presentation">
            <a href="#manage-content" aria-controls="manage-content" role="tab" data-toggle="tab">
                <?= __('Add Content'); ?>
            </a>
        </li>
        <li role="presentation">
            <a href="#manage-categories" aria-controls="manage-categories" role="tab" data-toggle="tab">
                <?= __('Manage Categories'); ?>
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane" id="manage-content">
            <?= $this->element('Articles/new', [
                'categories' => $categories,
                'site' => $site,
                'article' => $article,
                'articleTypes' => $types
            ]) ?>
        </div>
        <div role="tabpanel" class="tab-pane" id="manage-categories">
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
                                <?= $this->Html->link('<i class="fa fa-pencil"></i>', '#', [
                                    'title' => __('Edit'),
                                    'class' => 'btn btn-default',
                                    'escape' => false,
                                    'data-toggle' => 'modal',
                                    'data-target' => '#' . $category->id
                                ]) ?>
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
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php endif; ?>
            <div class="btn-group btn-group-sm" role="group">
            <?= $this->Html->link('<i class="fa fa-plus"></i> ' . __('Add'), '#', [
                'title' => __('Create Category'),
                'class' => 'btn btn-default',
                'data-toggle' => 'modal',
                'data-target' => '#add-new-category',
                'escape' => false
            ]) ?>
            </div>
        </div>
    </div>
</div>
<hr />