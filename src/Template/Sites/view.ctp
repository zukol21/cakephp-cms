<section class="content-header">
    <h1><?= $this->Html->link(
        __('Sites'),
        ['action' => 'index']
    ) . ' &raquo; ' . h($site->name) ?></h1>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-6">
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
                        <dt><?= __('Created') ?></dt>
                        <dd><?= h($site->created) ?></dd>
                        <dt><?= __('Modified') ?></dt>
                        <dd><?= h($site->modified) ?></dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
    <hr />
    <div class="row">
        <div class="col-xs-12">
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
                        <div class="table-responsive">
                            <table class="table table-hover table-condensed table-vertical-align">
                                <thead>
                                    <tr>
                                        <th><?= __('Slug') ?></th>
                                        <th><?= __('Name') ?></th>
                                        <th class="actions"><?= __('Actions') ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($site->categories as $category) : ?>
                                    <tr>
                                        <td><?= h($category->slug) ?></td>
                                        <td><?= h($category->name) ?></td>
                                        <td class="actions">
                                            <div class="btn-group btn-group-xs" role="group">
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
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>