<?php
$this->extend('QoboAdminPanel./Common/panel-wrapper');
$this->assign('panel-title', __d('QoboAdminPanel', 'View all'));
?>
<div class="pull-right">
    <p class="text-right">
        <?php echo $this->Html->link(
            __('Add New'),
            ['plugin' => $this->request->plugin, 'controller' => $this->request->controller, 'action' => 'add'],
            ['class' => 'btn btn-primary']
        ); ?>
    </p>
    <?= $this->Form->create(null, ['type' => 'get', 'class' => 'form-inline articles-search']); ?>
    <?= $this->Form->input('s', ['label' => false]); ?>
    <?= $this->Form->button(__d('cms', 'Search'), ['class' => 'btn-info']); ?>
    <?= $this->Form->end(); ?>
</div>
<table class="table table-striped" cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th><?= $this->Paginator->sort('title'); ?></th>
            <th><?= $this->Paginator->sort('slug'); ?></th>
            <th><?= $this->Paginator->sort('categories'); ?></th>
            <th><?= $this->Paginator->sort('Author'); ?></th>
            <th><?= __d('cms', 'Featured Image'); ?></th>
            <th class="actions"><?= __('Actions'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($articles as $article) : ?>
        <tr>
            <td><?= h($article->title) ?></td>
            <td><?= h($article->slug) ?></td>
            <?php
            //Printing out categories
            $categories = [];
            foreach ($article->categories as $category) {
                $categories[] = $category->name;
            }
            ?>
            <td><?= $this->Text->toList($categories); ?></td>
            <td><?= h($article->created_by) ?></td>
            <td>
            <?=
                isset($article->article_featured_images[0])
                ? $this->Image->display($article->article_featured_images[0], 'small')
                : __d('cms', 'No featured image');
            ?>
            </td>
            <td class="actions">
                <?= $this->Html->link('', ['action' => 'display', $article->slug], ['title' => __('Preview'), 'class' => 'btn btn-default glyphicon glyphicon-eye-open', 'target' => '_blank']) ?>
                <?= $this->Html->link('', ['action' => 'edit', $article->id], ['title' => __('Edit'), 'class' => 'btn btn-default glyphicon glyphicon-pencil']) ?>
                <?= $this->Form->postLink('', ['action' => 'delete', $article->id], ['confirm' => __('Are you sure you want to delete # {0}?', $article->id), 'title' => __('Delete'), 'class' => 'btn btn-default glyphicon glyphicon-trash']) ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<div class="paginator">
    <ul class="pagination">
        <?= $this->Paginator->prev('< ' . __('previous')) ?>
        <?= $this->Paginator->numbers(['before' => '', 'after' => '']) ?>
        <?= $this->Paginator->next(__('next') . ' >') ?>
    </ul>
    <p><?= $this->Paginator->counter() ?></p>
</div>

<?= $this->Html->css('Cms.articles'); ?>