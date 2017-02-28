<section class="content-header">
    <h1><?= $this->Html->link(
        __('Categories'),
        ['action' => 'index']
    ) . ' &raquo; ' . h($category->name) ?></h1>
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
                        <dt><?= __('Slug') ?></dt>
                        <dd><?= h($category->slug) ?></dd>
                        <dt><?= __('Name') ?></dt>
                        <dd><?= h($category->name) ?></dd>
                        <dt><?= __('Site') ?></dt>
                        <dd>
                            <?php if ($category->has('site')) : ?>
                            <a href="<?= $this->Url->build(['controller' => 'Sites', 'action' => 'view', $category->site->id])?>" class="label label-primary">
                                <?= $category->site->name ?>
                            </a>
                            <?php endif; ?>
                        </dd>
                        <dt><?= __('Hidden title') ?></dt>
                        <dd><?= $category->hide_title ? __('Yes') : __('No') ?></dd>
                        <dt><?= __('Align option') ?></dt>
                        <dd><?= h($category->align_category_article_image) ?></dd>
                        <dt><?= __('Parent Category') ?></dt>
                        <dd><?= $category->has('parent_category') ?
                            $this->Html->link($category->parent_category->name, [
                                'action' => 'view', $category->parent_category->id
                            ]) : '&nbsp;'
                        ?></dd>
                        <dt><?= __('Created') ?></dt>
                        <dd><?= h($category->created) ?></dd>
                        <dt><?= __('Modified') ?></dt>
                        <dd><?= h($category->modified) ?></dd>
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
                        <a href="#related-articles" aria-controls="related-articles" role="tab" data-toggle="tab">
                            <?= __('Related Articles'); ?>
                        </a>
                    </li>
                    <li role="presentation">
                        <a href="#related-categories" aria-controls="related-categories" role="tab" data-toggle="tab">
                            <?= __('Related Categories'); ?>
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="related-articles">
                        <?php if (!empty($category->articles)) : ?>
                        <div class="table-responsive">
                            <table class="table table-hover table-condensed table-vertical-align">
                                <thead>
                                    <tr>
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
                                    <?php foreach ($category->articles as $article) : ?>
                                    <tr>
                                        <td><?= h($article->title) ?></td>
                                        <td><?= h($article->slug) ?></td>
                                        <td><?= h($article->excerpt) ?></td>
                                        <td><?= h($article->content) ?></td>
                                        <td><?= h($article->created_by) ?></td>
                                        <td><?= h($article->modified_by) ?></td>
                                        <td><?= h($article->publish_date) ?></td>
                                        <td><?= h($article->created) ?></td>
                                        <td><?= h($article->modified) ?></td>
                                        <td class="actions">
                                            <div class="btn-group btn-group-xs" role="group">
                                            <?= $this->Html->link(
                                                '<i class="fa fa-eye"></i>',
                                                ['controller' => 'Articles', 'action' => 'view', $article->id],
                                                ['title' => __('View'), 'class' => 'btn btn-default', 'escape' => false]
                                            ) ?>
                                            <?= $this->Html->link(
                                                '<i class="fa fa-pencil"></i>',
                                                ['controller' => 'Articles', 'action' => 'edit', $article->id],
                                                ['title' => __('Edit'), 'class' => 'btn btn-default', 'escape' => false]
                                            ) ?>
                                            <?= $this->Form->postLink(
                                                '<i class="fa fa-trash"></i>',
                                                ['controller' => 'Articles', 'action' => 'delete', $article->id],
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
                        <?php endif; ?>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="related-categories">
                        <?php if (!empty($category->child_categories)) : ?>
                        <div class="table-responsive">
                            <table class="table table-hover table-condensed table-vertical-align">
                                <thead>
                                    <tr>
                                        <th><?= __('Slug') ?></th>
                                        <th><?= __('Name') ?></th>
                                        <th><?= __('Site') ?></th>
                                        <th class="actions"><?= __('Actions') ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($category->child_categories as $child) : ?>
                                    <tr>
                                        <td><?= h($child->slug) ?></td>
                                        <td><?= h($child->name) ?></td>
                                        <td>
                                            <?php if ($child->has('site')) : ?>
                                            <a href="<?= $this->Url->build(['controller' => 'Sites', 'action' => 'view', $child->site->id])?>" class="label label-primary">
                                                <?= $child->site->name ?>
                                            </a>
                                            <?php endif; ?>
                                        </td>
                                        <td class="actions">
                                            <div class="btn-group btn-group-xs" role="group">
                                            <?= $this->Html->link(
                                                '<i class="fa fa-eye"></i>',
                                                ['action' => 'view', $child->id],
                                                ['title' => __('View'), 'class' => 'btn btn-default', 'escape' => false]
                                            ) ?>
                                            <?= $this->Html->link(
                                                '<i class="fa fa-pencil"></i>',
                                                ['action' => 'edit', $child->id],
                                                ['title' => __('Edit'), 'class' => 'btn btn-default', 'escape' => false]
                                            ) ?>
                                            <?= $this->Form->postLink(
                                                '<i class="fa fa-trash"></i>',
                                                ['action' => 'delete', $child->id],
                                                [
                                                    'confirm' => __('Are you sure you want to delete # {0}?', $child->name),
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