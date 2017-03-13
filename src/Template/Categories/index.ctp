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
                <?= $this->Form->button(
                    '<i class="fa fa-plus"></i> ' . __('Add'),
                    [
                        'type' => 'button',
                        'title' => __('Add'),
                        'class' => 'btn btn-default dropdown-toggle',
                        'data-toggle' => 'dropdown',
                        'aria-haspopup' => 'true',
                        'aria-expanded' => 'false'
                    ]
                ) ?>
                <ul class="dropdown-menu dropdown-menu-right">
                <?php foreach ($sites as $site) : ?>
                    <li>
                        <a href="<?= $this->Url->build(['action' => 'add', $site->slug]); ?>">
                            <?= $site->name ?>
                        </a>
                    </li>
                <?php endforeach; ?>
                </ul>
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
                            <th><?= __('Name'); ?></th>
                            <th><?= __('Site'); ?></th>
                            <th class="actions"><?= __('Actions'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($categories as $category) : ?>
                        <tr>
                            <td><?= $category->node ?></td>
                            <td>
                                <?php if ($category->has('site')) : ?>
                                <a href="<?= $this->Url->build(['controller' => 'Sites', 'action' => 'view', $category->site->id])?>" class="label label-primary">
                                    <?= $category->site->name ?>
                                </a>
                                <?php endif; ?>
                            </td>
                            <td class="actions">
                                <div class="btn-group btn-group-xs" role="group">
                                    <?php if ($category->parent_id) : ?>
                                        <?= $this->Form->postLink(
                                            '<i class="fa fa-arrow-up"></i>',
                                            ['action' => 'moveNode', $category->site->slug, $category->slug, 'up'],
                                            ['title' => __('Move up'), 'class' => 'btn btn-default', 'escape' => false]
                                        ) ?>
                                        <?= $this->Form->postLink(
                                            '<i class="fa fa-arrow-down"></i>',
                                            ['action' => 'moveNode', $category->site->slug, $category->slug, 'down'],
                                            ['title' => __('Move down'), 'class' => 'btn btn-default', 'escape' => false]
                                        ) ?>
                                    <?php endif; ?>
                                    <?= $this->Html->link(
                                        '<i class="fa fa-eye"></i>',
                                        ['action' => 'view', $category->site->slug, $category->slug],
                                        ['title' => __('View'), 'class' => 'btn btn-default', 'escape' => false]
                                    ) ?>
                                    <?= $this->Html->link(
                                        '<i class="fa fa-pencil"></i>',
                                        ['action' => 'edit', $category->site->slug, $category->slug],
                                        ['title' => __('Edit'), 'class' => 'btn btn-default', 'escape' => false]
                                    ) ?>
                                    <?= $this->Form->postLink(
                                        '<i class="fa fa-trash"></i>',
                                        ['action' => 'delete', $category->site->slug, $category->slug],
                                        [
                                            'confirm' => __('Are you sure you want to delete # {0}?', $category->name),
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