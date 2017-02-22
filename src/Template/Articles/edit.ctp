<?php
use Cake\Core\Configure;

$this->extend('QoboAdminPanel./Common/panel-wrapper');
$this->assign('panel-title', __d('QoboAdminPanel', __('Edit {0}', $article->title)));
$idContent = 'article-content';
?>
<?= $this->Form->create($article, ['type' => 'file']); ?>
<?= $this->element('Cms.preview', ['slug' => $article->slug]); ?>
<fieldset>
    <?php
    echo $this->Form->input('title');
    echo $this->Form->input('content', ['type' => 'textarea', 'id' => $idContent]);
    echo $this->Form->input('excerpt', ['type' => 'textarea']);
    echo $this->Form->input('categories._ids', ['options' => $categories, 'escape' => false]);
    ?>
    <?= $this->element('QoboAdminPanel.datepicker', [
        'options' => [
            'fieldName' => 'publish_date',
            'type' => 'datetimepicker',
            'label' => true,
            'value' => $article->publish_date->format('Y/m/d H:i:s')
        ]
    ]); ?>
    <div class="form-group">
        <label class="control-label" for="featured-image"><?= __d('cms', 'Featured Image'); ?></label>
        <?php
        if (!isset($article->article_featured_images[0])) : ?>
            <?= $this->Form->file('file'); ?>
            <?= $this->Form->error('file'); ?>
        <?php
        else : ?>
            <div>
                <?= $this->Form->file('file', ['class' => 'hidden']); ?>
                <?= $this->Form->error('file', ['class' => 'hidden']); ?>
                <?= $this->Html->link(
                    __d('cms', 'Preview'),
                    '#',
                    ['data-target' => '#featuredImage', 'data-toggle' => 'modal']
                );
                ?>
            </div>
        <?php
        endif ?>
    </div>
<?= $this->Form->button(__("Save"), ['class' => 'btn-primary']); ?>
<?= $this->Form->end() ?>
</fieldset>
<?php
if (isset($article->article_featured_images[0])) :
    echo $this->element('Cms.featured-image-preview', ['featuredImage' => $article->article_featured_images[0]]);
endif;
?>
<?php
$url = $this->Url->assetUrl(['action' => 'uploadFromEditor', $article->id, '_ext' => 'json']);
echo $this->element('Cms.ckeditor', ['id' => $idContent, 'url' => $url]);
?>
