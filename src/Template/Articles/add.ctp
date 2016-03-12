<?php
$this->extend('QoboAdminPanel./Common/panel-wrapper');
$this->assign('title', __d('QoboAdminPanel', 'Articles'));
$this->assign('panel-title', __d('QoboAdminPanel', 'Articles information'));
$ckeditorIds = ['article-excerpt', 'article-content'];
list($idExcerpt, $idContent) = $ckeditorIds;
?>
<?= $this->Form->create($article, ['type' => 'file']); ?>
<fieldset>
    <legend><?= __('Add {0}', ['Article']) ?></legend>
    <?php
    echo $this->Form->input('title');
    echo $this->Form->input('slug');
    echo $this->Form->input('excerpt', ['type' => 'textarea', 'id' => $idExcerpt]);
    echo $this->Form->input('content', ['type' => 'textarea', 'id' => $idContent]);
    echo $this->Form->input('category',[
        'options' => $categories,
    ]);
    echo $this->Form->input('publish_date');
    ?>
    <div class="form-group">
        <label class="control-label" for="featured-image"><?= __d('cms', 'Featured Image'); ?></label>
        <?php
        echo $this->Form->file('file');
        echo $this->Form->error('file');
        ?>
    </div>
</fieldset>
<?= $this->Form->button(__("Add"), ['class' => 'btn-primary']); ?>
<?= $this->Form->end() ?>
<?php
$url = $this->Url->assetUrl(['action' => 'uploadFromEditor', $article->id, '_ext' => 'json']);
echo $this->element('Cms.ckeditor', ['id' => $idExcerpt, 'url' => $url]);
echo $this->element('Cms.ckeditor', ['id' => $idContent, 'url' => $url]);
?>