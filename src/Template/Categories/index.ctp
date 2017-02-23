<?php
echo $this->Html->css('AdminLTE./plugins/datatables/dataTables.bootstrap', ['block' => 'css']);
echo $this->Html->script(
    [
        'AdminLTE./plugins/datatables/jquery.dataTables.min',
        'AdminLTE./plugins/datatables/dataTables.bootstrap.min'
    ],
    [
        'block' => 'scriptBotton'
    ]
);
echo $this->Html->scriptBlock(
    '$(".table-datatable").DataTable({});',
    ['block' => 'scriptBotton']
);
?>
<section class="content-header">
    <h1>Categories
        <div class="pull-right">
            <div class="btn-group btn-group-sm" role="group">
                <?= $this->Html->link(
                    '<i class="fa fa-plus"></i> ' . __('Add'),
                    ['plugin' => $this->plugin, 'controller' => $this->name, 'action' => 'add'],
                    ['escape' => false, 'title' => __('Add'), 'class' => 'btn btn-default']
                ) ?>
            </div>
        </div>
    </h1>
</section>
<section class="content">
    <div class="box">
        <div class="box-body">
            <div class="box-body table-responsive">
                <table class="table table-condensed table-vertical-align">
                    <thead>
                        <tr>
                            <th><?= __('Node'); ?></th>
                            <th class="actions"><?= __('Actions'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($categories as $category) : ?>
                        <tr>
                            <td><?= $category->node ?></td>
                            <td class="actions">
                                <div class="btn-group btn-group-xs" role="group">
                                    <?php if ($category->parent_id) : ?>
                                        <?= $this->Form->postLink(
                                            '<i class="fa fa-arrow-up"></i>',
                                            ['action' => 'move_node', $category->id, 'up'],
                                            ['title' => __('Move up'), 'class' => 'btn btn-default', 'escape' => false]
                                        ) ?>
                                        <?= $this->Form->postLink(
                                            '<i class="fa fa-arrow-down"></i>',
                                            ['action' => 'move_node', $category->id, 'down'],
                                            ['title' => __('Move down'), 'class' => 'btn btn-default', 'escape' => false]
                                        ) ?>
                                    <?php endif; ?>
                                    <?= $this->Html->link(
                                        '<i class="fa fa-eye"></i>',
                                        ['action' => 'view', $category->id],
                                        ['title' => __('View'), 'class' => 'btn btn-default', 'escape' => false]
                                    ) ?>
                                    <?= $this->Html->link(
                                        '<i class="fa fa-pencil"></i>',
                                        ['action' => 'edit', $category->id],
                                        ['title' => __('Edit'), 'class' => 'btn btn-default', 'escape' => false]
                                    ) ?>
                                    <?= $this->Form->postLink(
                                        '<i class="fa fa-trash"></i>',
                                        ['action' => 'delete', $category->id],
                                        [
                                            'confirm' => __('Are you sure you want to delete # {0}?', $category->node),
                                            'title' => __('Delete'),
                                            'class' => 'btn btn-default',
                                            'escape' => false
                                        ]
                                    ) ?>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>