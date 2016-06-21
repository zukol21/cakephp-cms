<?php
$this->extend('QoboAdminPanel./Common/panel-wrapper');
$this->assign('title', __d('QoboAdminPanel', 'Categories'));
$this->assign('panel-title', __d('QoboAdminPanel', 'Edit ' . $category->name));
?>
<?= $this->Form->create($category); ?>
<?= $this->element('Cms.preview', ['slug' => $category->slug]); ?>
<fieldset>
    <?php
    echo $this->Form->input('name');
    echo $this->Form->input('parent_id', ['options' => $list, 'escape' => false]);
    echo $this->Form->input('hide_title');
    ?>
</fieldset>
<?= $this->Form->button(__("Save")); ?>
<?= $this->Form->end() ?>
