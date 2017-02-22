<?= $this->element('QoboAdminPanel.main-title'); ?>
<div class="panel panel-default">
    <!-- Panel header -->
    <div class="panel-heading">
        <h3 class="panel-title"><?= h($category->name) ?></h3>
    </div>
    <table class="table table-striped" cellpadding="0" cellspacing="0">
        <tr>
            <td><?= __('Slug') ?></td>
            <td><?= h($category->slug) ?></td>
        </tr>
        <tr>
            <td><?= __('Name') ?></td>
            <td><?= h($category->name) ?></td>
        </tr>
        <tr>
            <td><?= __('Hidden title') ?></td>
            <td><?= h($category->hide_title) ?></td>
        </tr>
        <tr>
            <td><?= __('Align option') ?></td>
            <td><?= h($category->align_category_article_image) ?></td>
        </tr>
        <tr>
            <td><?= __('Parent Category') ?></td>
            <td><?= $category->has('parent_category') ? $this->Html->link($category->parent_category->name, ['controller' => 'Categories', 'action' => 'view', $category->parent_category->id]) : '' ?></td>
        </tr>
        <tr>
            <td><?= __('Created') ?></td>
            <td><?= h($category->created) ?></td>
        </tr>
        <tr>
            <td><?= __('Modified') ?></td>
            <td><?= h($category->modified) ?></td>
        </tr>
    </table>
</div>

<div class="panel panel-default">
    <!-- Panel header -->
    <div class="panel-heading">
        <h3 class="panel-title"><?= __('Related Categories') ?></h3>
    </div>
    <?php if (!empty($category->child_categories)) : ?>
        <table class="table table-striped">
            <thead>
            <tr>
                <th><?= __('Slug') ?></th>
                <th><?= __('Name') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($category->child_categories as $childCategories) : ?>
                <tr>
                    <td><?= h($childCategories->slug) ?></td>
                    <td><?= h($childCategories->name) ?></td>
                    <td class="actions">
                        <?= $this->Html->link('', ['controller' => 'Categories', 'action' => 'view', $childCategories->id], ['title' => __('View'), 'class' => 'btn btn-default glyphicon glyphicon-eye-open']) ?>
                        <?= $this->Html->link('', ['controller' => 'Categories', 'action' => 'edit', $childCategories->id], ['title' => __('Edit'), 'class' => 'btn btn-default glyphicon glyphicon-pencil']) ?>
                        <?= $this->Form->postLink('', ['controller' => 'Categories', 'action' => 'delete', $childCategories->id], ['confirm' => __('Are you sure you want to delete # {0}?', $childCategories->id), 'title' => __('Delete'), 'class' => 'btn btn-default glyphicon glyphicon-trash']) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php else : ?>
        <p class="panel-body">no related Categories</p>
    <?php endif; ?>
</div>
<div class="panel panel-default">
    <!-- Panel header -->
    <div class="panel-heading">
        <h3 class="panel-title"><?= __('Related Articles') ?></h3>
    </div>
    <?php if (!empty($category->articles)) : ?>
        <table class="table table-striped">
            <thead>
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('Title') ?></th>
                <th><?= __('Slug') ?></th>
                <th><?= __('Excerpt') ?></th>
                <th><?= __('Content') ?></th>
                <th><?= __('Created By') ?></th>
                <th><?= __('Modified By') ?></th>
                <th><?= __('Publish Date') ?></th>
                <th><?= __('Created') ?></th>
                <th><?= __('Modified') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($category->articles as $articles) : ?>
                <tr>
                    <td><?= h($articles->id) ?></td>
                    <td><?= h($articles->title) ?></td>
                    <td><?= h($articles->slug) ?></td>
                    <td><?= h($articles->excerpt) ?></td>
                    <td><?= h($articles->content) ?></td>
                    <td><?= h($articles->created_by) ?></td>
                    <td><?= h($articles->modified_by) ?></td>
                    <td><?= h($articles->publish_date) ?></td>
                    <td><?= h($articles->created) ?></td>
                    <td><?= h($articles->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link('', ['controller' => 'Articles', 'action' => 'view', $articles->id], ['title' => __('View'), 'class' => 'btn btn-default glyphicon glyphicon-eye-open']) ?>
                        <?= $this->Html->link('', ['controller' => 'Articles', 'action' => 'edit', $articles->id], ['title' => __('Edit'), 'class' => 'btn btn-default glyphicon glyphicon-pencil']) ?>
                        <?= $this->Form->postLink('', ['controller' => 'Articles', 'action' => 'delete', $articles->id], ['confirm' => __('Are you sure you want to delete # {0}?', $articles->id), 'title' => __('Delete'), 'class' => 'btn btn-default glyphicon glyphicon-trash']) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php else : ?>
        <p class="panel-body">no related Articles</p>
    <?php endif; ?>
</div>
