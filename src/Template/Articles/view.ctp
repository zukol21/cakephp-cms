<?php
$this->extend('QoboAdminPanel./Common/panel-wrapper');
$this->assign('title', __d('QoboAdminPanel', 'Articles'));
$this->assign('panel-title', __d('QoboAdminPanel', 'Articles information'));
?>
<div class="panel panel-default">
    <!-- Panel header -->
    <div class="panel-heading">
        <h3 class="panel-title"><?= h($article->title) ?></h3>
    </div>
    <table class="table table-striped" cellpadding="0" cellspacing="0">
        <tr>
            <td><?= __('Title') ?></td>
            <td><?= h($article->title) ?></td>
        </tr>
        <tr>
            <td><?= __('Slug') ?></td>
            <td><?= h($article->slug) ?></td>
        </tr>
        <tr>
            <td><?= __('Featured Img') ?></td>
            <td><?= h($article->featured_img) ?></td>
        </tr>
        <tr>
            <td><?= __('Category') ?></td>
            <td><?= h($article->category) ?></td>
        </tr>
        <tr>
            <td><?= __('Created By') ?></td>
            <td><?= h($article->created_by) ?></td>
        </tr>
        <tr>
            <td><?= __('Modified By') ?></td>
            <td><?= h($article->modified_by) ?></td>
        </tr>
        <tr>
            <td><?= __('Publish Date') ?></td>
            <td><?= h($article->publish_date) ?></td>
        </tr>
        <tr>
            <td><?= __('Created') ?></td>
            <td><?= h($article->created) ?></td>
        </tr>
        <tr>
            <td><?= __('Modified') ?></td>
            <td><?= h($article->modified) ?></td>
        </tr>
        <tr>
            <td><?= __('Excerpt') ?></td>
            <td><?= $this->Text->autoParagraph(h($article->excerpt)); ?></td>
        </tr>
        <tr>
            <td><?= __('Content') ?></td>
            <td><?= $this->Text->autoParagraph(h($article->content)); ?></td>
        </tr>
    </table>
</div>

