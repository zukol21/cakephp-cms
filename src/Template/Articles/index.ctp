<?php
$this->loadHelper('Burzum/FileStorage.Image');

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
    <h1>Articles
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
            <table class="table table-hover table-condensed table-vertical-align table-datatable" width="100%">
                <thead>
                    <tr>
                        <th><?= __('Title'); ?></th>
                        <th><?= __('Slug'); ?></th>
                        <th><?= __('Categories'); ?></th>
                        <th><?= __('Author'); ?></th>
                        <th><?= __('Publish'); ?></th>
                        <th><?= __('Featured Image'); ?></th>
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
                        <?php if ($article->publish_date < new DateTime('now')) : ?>
                            <span class="fa fa-check" aria-hidden="true"></span></td>
                        <?php else : ?>
                            <span class="fa fa-remove" aria-hidden="true"></span></td>
                        <?php endif; ?>
                        </td>
                        <td>
                        <?=
                            isset($article->article_featured_images[0])
                            ? $this->Image->display($article->article_featured_images[0], 'small')
                            : __d('cms', 'No featured image');
                        ?>
                        </td>
                        <td class="actions">
                            <div class="btn-group btn-group-xs" role="group">
                                <?= $this->Html->link(
                                    '<i class="fa fa-eye"></i>',
                                    ['action' => 'view', $article->id],
                                    ['title' => __('View'), 'class' => 'btn btn-default', 'escape' => false]
                                ) ?>
                                <?= $this->Html->link(
                                    '<i class="fa fa-pencil"></i>',
                                    ['action' => 'edit', $article->id],
                                    ['title' => __('Edit'), 'class' => 'btn btn-default', 'escape' => false]
                                ) ?>
                                <?= $this->Form->postLink(
                                    '<i class="fa fa-trash"></i>',
                                    ['action' => 'delete', $article->id],
                                    [
                                        'confirm' => __('Are you sure you want to delete # {0}?', $article->title),
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
</section>