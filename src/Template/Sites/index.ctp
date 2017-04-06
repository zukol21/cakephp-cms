<?php
use Cake\Utility\Inflector;

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
    <h1>Sites
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
                            <th><?= __('Name'); ?></th>
                            <th><?= __('Slug'); ?></th>
                            <th><?= __('Active'); ?></th>
                            <th class="actions"><?= __('Actions'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($sites as $site) : ?>
                        <tr>
                            <td><?= $site->name ?></td>
                            <td><?= $site->slug ?></td>
                            <td><?= $site->active ? __('Yes') : __('No') ?></td>
                            <td class="actions">
                                <div class="btn-toolbar" role="toolbar">
                                    <div class="btn-group btn-group-xs" role="group">
                                        <?= $this->Html->link(
                                            '<i class="fa fa-eye"></i>',
                                            ['action' => 'view', $site->id],
                                            ['title' => __('View'), 'class' => 'btn btn-default', 'escape' => false]
                                        ) ?>
                                        <?= $this->Html->link(
                                            '<i class="fa fa-pencil"></i>',
                                            ['action' => 'edit', $site->id],
                                            ['title' => __('Edit'), 'class' => 'btn btn-default', 'escape' => false]
                                        ) ?>
                                        <?= $this->Form->postLink(
                                            '<i class="fa fa-trash"></i>',
                                            ['action' => 'delete', $site->id],
                                            [
                                                'confirm' => __('Are you sure you want to delete # {0}?', $site->name),
                                                'title' => __('Delete'),
                                                'class' => 'btn btn-default',
                                                'escape' => false
                                            ]
                                        ) ?>
                                    </div>
                                    <div class="btn-group btn-group-xs" role="group">
                                        <?= $this->Html->link(
                                            '<i class="fa fa-tag"></i>',
                                            ['controller' => 'Categories', 'action' => 'add', $site->slug],
                                            ['title' => __('Create Category'), 'class' => 'btn btn-default', 'escape' => false]
                                        ) ?>
                                        <?= $this->Form->button('<i class="fa fa-pencil-square"></i>', [
                                            'type' => 'button',
                                            'title' => __('Create Article'),
                                            'class' => 'btn btn-default dropdown-toggle',
                                            'data-toggle' => 'dropdown',
                                            'aria-haspopup' => 'true',
                                            'aria-expanded' => 'false',
                                            'escape' => false
                                        ]
                                            // ['controller' => 'Articles', 'action' => 'add', $site->slug],
                                        ) ?>
                                        <ul class="dropdown-menu dropdown-menu-right">
                                        <?php foreach (array_keys($types) as $type) : ?>
                                            <li>
                                                <a href="<?= $this->Url->build([
                                                    'controller' => 'Articles',
                                                    'action' => 'add',
                                                    $site->slug,
                                                    $type
                                                ]); ?>">
                                                    <?= Inflector::humanize($type) ?>
                                                </a>
                                            </li>
                                        <?php endforeach; ?>
                                        </ul>
                                    </div>
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