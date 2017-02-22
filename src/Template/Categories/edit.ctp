<?= $this->Form->create($category); ?>
<?= $this->element('Cms.preview', ['slug' => $category->slug]); ?>
<fieldset>
    <?php
    echo $this->Form->input('name');
    echo $this->Form->input('parent_id', ['options' => $list, 'escape' => false, 'empty' => true]);
    echo $this->Form->input('align_category_article_image', ['options' => $category->get('align_options')]);
    echo $this->Form->input('hide_title');
    ?>
</fieldset>
<?= $this->Form->button(__("Save")); ?>
<?= $this->Form->end() ?>
