<?php
$this->extend('QoboAdminPanel./Common/panel-wrapper');
$this->assign('title', __d('QoboAdminPanel', 'Article information'));
$this->assign('panel-title', __d('QoboAdminPanel', $article->title));
?>
<table class="table table-striped" cellpadding="0" cellspacing="0">
    <tr>
        <td><?= __('Slug') ?></td>
        <td><?= h($article->slug) ?></td>
    </tr>
    <tr>
        <td><?= __('Excerpt') ?></td>
        <td><?= $this->Text->autoParagraph($article->excerpt); ?></td>
    </tr>
    <tr>
        <td><?= __('Content') ?></td>
        <td><?= $this->Text->autoParagraph($article->content); ?></td>
    </tr>
    <tr>
        <td><?= __('Featured Image') ?></td>
        <td>
        <?=
            isset($article->article_featured_images[0])
            ? $this->Image->display($article->article_featured_images[0], 'small')
            : __d('cms', 'No featured image');
        ?>
        </td>
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
</table>
<?= $this->Html->link('', ['action' => 'edit', $article->id], ['title' => __('Edit'), 'class' => 'btn btn-default glyphicon glyphicon-pencil']) ?>
<?= $this->Form->postLink('', ['action' => 'delete', $article->id], ['confirm' => __('Are you sure you want to delete # {0}?', $article->id), 'title' => __('Delete'), 'class' => 'btn btn-default glyphicon glyphicon-trash']) ?>

