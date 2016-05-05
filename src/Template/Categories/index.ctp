<?php
$this->extend('QoboAdminPanel./Common/panel-wrapper');
$this->assign('panel-title', __d('QoboAdminPanel', 'View all'));
?>
<?= $this->element('add-cta'); ?>
<table class="table table-striped" cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th><?= __('Node'); ?></th>
            <th class="actions"><?= __('Actions'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($categories as $category): ?>
        <tr>
            <td><?= $category->node ?></td>
            <td class="actions">
                <?php if ($category->parent_id) : ?>
                        <?= $this->Form->postLink('', ['action' => 'move_node', $category->id, 'up'], ['title' => __('Move up'), 'class' => 'btn btn-default glyphicon glyphicon-arrow-up']) ?>
                        <?= $this->Form->postLink('', ['action' => 'move_node', $category->id, 'down'], ['title' => __('Move down'), 'class' => 'btn btn-default glyphicon glyphicon-arrow-down']) ?>
                <?php endif; ?>
                <?= $this->Html->link('', ['action' => 'display', $category->slug], ['title' => __('Preview'), 'class' => 'btn btn-default glyphicon glyphicon-eye-open', 'target' => '_blank']) ?>
                <?= $this->Html->link('', ['action' => 'edit', $category->id], ['title' => __('Edit'), 'class' => 'btn btn-default glyphicon glyphicon-pencil']) ?>
                <?= $this->Form->postLink('', ['action' => 'delete', $category->id], ['confirm' => __('Are you sure you want to delete # {0}?', $category->id), 'title' => __('Delete'), 'class' => 'btn btn-default glyphicon glyphicon-trash']) ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>