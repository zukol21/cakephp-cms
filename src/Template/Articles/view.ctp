<?php
$this->extend('../Layout/TwitterBootstrap/dashboard');


$this->start('tb_actions');
?>
<li><?= $this->Html->link(__('Edit Article'), ['action' => 'edit', $article->id]) ?> </li>
<li><?= $this->Form->postLink(__('Delete Article'), ['action' => 'delete', $article->id], ['confirm' => __('Are you sure you want to delete # {0}?', $article->id)]) ?> </li>
<li><?= $this->Html->link(__('List Articles'), ['action' => 'index']) ?> </li>
<li><?= $this->Html->link(__('New Article'), ['action' => 'add']) ?> </li>
<?php
$this->end();

$this->start('tb_sidebar');
?>
<ul class="nav nav-sidebar">
<li><?= $this->Html->link(__('Edit Article'), ['action' => 'edit', $article->id]) ?> </li>
<li><?= $this->Form->postLink(__('Delete Article'), ['action' => 'delete', $article->id], ['confirm' => __('Are you sure you want to delete # {0}?', $article->id)]) ?> </li>
<li><?= $this->Html->link(__('List Articles'), ['action' => 'index']) ?> </li>
<li><?= $this->Html->link(__('New Article'), ['action' => 'add']) ?> </li>
</ul>
<?php
$this->end();
?>
<div class="panel panel-default">
    <!-- Panel header -->
    <div class="panel-heading">
        <h3 class="panel-title"><?= h($article->title) ?></h3>
    </div>
    <table class="table table-striped" cellpadding="0" cellspacing="0">
        <tr>
            <td><?= __('Id') ?></td>
            <td><?= h($article->id) ?></td>
        </tr>
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

