<?php
$this->extend('QoboAdminPanel./Common/panel-wrapper');
$this->assign('title', __d('QoboAdminPanel', 'Articles'));
$this->assign('panel-title', __d('QoboAdminPanel', 'Articles information'));
?>
<p class="text-right">
    <?php echo $this->Html->link(
        __('Add New'),
        ['plugin' => $this->request->plugin, 'controller' => $this->request->controller, 'action' => 'add'],
        ['class' => 'btn btn-primary']
    ); ?>
</p>
<table class="table table-striped" cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th><?= $this->Paginator->sort('title'); ?></th>
            <th><?= $this->Paginator->sort('slug'); ?></th>
            <th><?= $this->Paginator->sort('category'); ?></th>
            <th><?= $this->Paginator->sort('Author'); ?></th>
            <th><?= __d('cms', 'Featured Image'); ?></th>
            <th class="actions"><?= __('Actions'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($articles as $article): ?>
        <tr>
            <td><?= h($article->title) ?></td>
            <td><?= h($article->slug) ?></td>
            <td><?= h($article->category) ?></td>
            <td><?= h($article->created_by) ?></td>
            <td>
            <?=
                isset($article->article_featured_images[0])
                ? $this->Image->display($article->article_featured_images[0], 'small')
                : __d('cms', 'No featured image');
            ?>
            </td>
            <td class="actions">
                <?= $this->Html->link('', ['action' => 'view', $article->id], ['title' => __('View'), 'class' => 'btn btn-default glyphicon glyphicon-eye-open']) ?>
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