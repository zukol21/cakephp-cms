<?php $this->loadHelper('Burzum/FileStorage.Image'); ?>
<section class="content-header">
    <h1><?= $this->Html->link(
        __('Articles'),
        ['action' => 'index']
    ) . ' &raquo; ' . h($article->title) ?></h1>
</section>
<section class="content">
    <div class="row">
        <div class="col-lg-4 col-lg-push-8">
            <div class="row">
                <div class="col-xs-12 col-md-4 col-lg-12">
                    <div class="box box-solid">
                        <div class="box-header with-border">
                            <i class="fa fa-info-circle"></i>
                            <h3 class="box-title">Info</h3>
                            <div class="pull-right box-tools">
                                <button type="button" class="btn btn-default btn-sm" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse">
                                    <i class="fa fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <div class="col-xs-4 text-right"><strong><?= __('Slug') ?>:</strong></div>
                                <div class="col-xs-8"><?= h($article->slug) ?></div>
                                <div class="clearfix"></div>
                                <div class="col-xs-4 text-right"><strong><?= __('Categories') ?>:</strong></div>
                                <div class="col-xs-8"><?= $this->Text->toList($categories) ?></div>
                                <div class="clearfix"></div>
                                <div class="col-xs-4 text-right"><strong><?= __('Created') ?>:</strong></div>
                                <div class="col-xs-8"><?= h($article->created) ?></div>
                                <div class="clearfix"></div>
                                <div class="col-xs-4 text-right"><strong><?= __('Modified') ?>:</strong></div>
                                <div class="col-xs-8"><?= h($article->modified) ?></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-md-4 col-lg-12">
                    <div class="box box-solid">
                        <div class="box-header with-border">
                            <i class="fa fa-calendar"></i>
                            <h3 class="box-title">Publish</h3>
                            <div class="pull-right box-tools">
                                <button type="button" class="btn btn-default btn-sm" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse">
                                    <i class="fa fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <div class="col-xs-4 text-right"><strong><?= __('Publish Date') ?>:</strong></div>
                                <div class="col-xs-8"><?= h($article->publish_date) ?></div>
                                <div class="clearfix"></div>
                                <div class="col-xs-4 text-right"><strong><?= __('Created by') ?>:</strong></div>
                                <div class="col-xs-8"><?= h($article->created_by) ?></div>
                                <div class="clearfix"></div>
                                <div class="col-xs-4 text-right"><strong><?= __('Modified by') ?>:</strong></div>
                                <div class="col-xs-8"><?= h($article->modified_by) ?></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-md-4 col-lg-12">
                    <div class="box box-solid">
                        <div class="box-header with-border">
                            <i class="fa fa-file-image-o"></i>
                            <h3 class="box-title">Featured Image</h3>
                            <div class="pull-right box-tools">
                                <button type="button" class="btn btn-default btn-sm" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse">
                                    <i class="fa fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="box-body">
                            <div><?=
                                isset($article->article_featured_images[0])
                                ? $this->Image->display($article->article_featured_images[0], 'small')
                                : __d('cms', 'No featured image');
                            ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8 col-lg-pull-4">
            <div class="box box-solid">
                <div class="box-header with-border">
                    <i class="fa fa-pencil-square-o"></i>
                    <h3 class="box-title">Content</h3>
                </div>
                <div class="box-body">
                    <div><?= $this->Text->autoParagraph($article->content) ?></div>
                </div>
            </div>
            <div class="box box-solid">
                <div class="box-header with-border">
                    <i class="fa fa-ellipsis-h"></i>
                    <h3 class="box-title">Excerpt</h3>
                </div>
                <div class="box-body">
                    <div><?= $this->Text->autoParagraph($article->excerpt) ?></div>
                </div>
            </div>
        </div>
    </div>
</section>