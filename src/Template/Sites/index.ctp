<?php
echo $this->Html->css('AdminLTE./plugins/datatables/dataTables.bootstrap', ['block' => 'css']);
echo $this->Html->script(
    [
        'AdminLTE./plugins/datatables/jquery.dataTables.min',
        'AdminLTE./plugins/datatables/dataTables.bootstrap.min',
        'Cms.datatables.init'
    ],
    [
        'block' => 'scriptBotton'
    ]
);
?>
<section class="content-header">
    <h1>Sites
        <div class="pull-right">
            <div class="btn-group btn-group-sm" role="group">
                <?= $this->Html->link('<i class="fa fa-plus"></i> ' . __('Add'), '#', [
                    'title' => __('Add'),
                    'class' => 'btn btn-default',
                    'data-toggle' => 'modal',
                    'data-target' => '#cms-site-add',
                    'escape' => false
                ]) ?>
            </div>
        </div>
    </h1>
</section>
<section class="content">
    <div class="box">
        <div class="box-body">
            <table class="table table-hover table-condensed table-vertical-align table-datatable" width="100%">
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
                                        ['action' => 'view', $site->slug],
                                        ['title' => __('View'), 'class' => 'btn btn-default', 'escape' => false]
                                    ) ?>
                                    <?php if (!$site->active) : ?>
                                        <?= $this->Html->link('<i class="fa fa-pencil"></i>', '#', [
                                            'title' => __('Edit'),
                                            'class' => 'btn btn-default',
                                            'data-toggle' => 'modal',
                                            'data-target' => '#cms-site-edit' . $site->id,
                                            'escape' => false
                                        ]) ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>
<?= $this->element('Sites/modal', ['site' => null]) ?>
<?php
foreach ($sites as $site) {
    if ($site->active) {
        continue;
    }

    echo $this->element('Sites/modal', ['site' => $site]);
}
