<?php
$this->extend('QoboAdminPanel./Common/panel-wrapper');
$this->assign('title', __d('QoboAdminPanel', 'Articles'));
$this->assign('panel-title', __d('QoboAdminPanel', 'Articles information'));
?>
<?= $this->Form->create($article); ?>
<fieldset>
    <legend><?= __('Edit {0}', ['Article']) ?></legend>
    <?php
    echo $this->Form->input('title');
    echo $this->Form->input('slug');
    echo $this->Form->input('excerpt', ['type' => 'textarea', 'id' => 'editor1']);
    echo $this->Form->input('content', ['type' => 'textarea', 'id' => 'editor2']);
    echo $this->Form->input('featured_img');
    echo $this->Form->input('category',[
        'options' => $categories,
        'value' => $article->category,
    ]);
    echo $this->Form->input('created_by');
    echo $this->Form->input('modified_by');
    echo $this->Form->input('publish_date');
    ?>
</fieldset>
<?= $this->Form->button(__("Save")); ?>
<?= $this->Form->end() ?>
