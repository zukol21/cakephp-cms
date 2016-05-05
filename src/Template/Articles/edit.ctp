<?php
use Cake\Core\Configure;
$this->extend('QoboAdminPanel./Common/panel-wrapper');
$this->assign('title', __d('QoboAdminPanel', 'Articles'));
$this->assign('panel-title', __d('QoboAdminPanel', 'Articles information'));
$idContent = 'article-content';
?>
<?= $this->Form->create($article, ['type' => 'file']); ?>
<fieldset>
    <legend><?= __('Edit {0}', ['Article']) ?></legend>
    <?php
    echo $this->Form->input('title');
    echo $this->Form->input('content', ['type' => 'textarea', 'id' => $idContent]);
    echo $this->Form->input('excerpt', ['type' => 'textarea']);
    echo $this->Form->input('categories._ids', ['options' => $categories, 'escape' => false]);
    ?>
    <?= $this->element('QoboAdminPanel.datepicker', [
        'options' => ['fieldName' => 'publish_date', 'type' => 'datetimepicker', 'label' => true, 'value' => $article->publish_date]
    ]); ?>
    <div class="form-group">
        <label class="control-label" for="featured-image"><?= __d('cms', 'Featured Image'); ?></label>
        <?php
        echo $this->Form->file('file');
        echo $this->Form->error('file');
        ?>
    </div>
    <?php if (!empty($article->article_featured_images)) : ?>
        <div class="form-group">
            <label class="control-label" for="featured-image">Featured Image preview</label>
        </div>
        <?php
        $sizes = array_keys(Configure::read('FileStorage.imageSizes.' . $article->article_featured_images[0]->model));
        ?>
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
            <?php foreach ($sizes as $index => $size) : ?>
                <li role="presentation" class="<?= (!$index) ? 'active' : ''; ?>"><a href="#<?= $size ?>" aria-controls="<?= $size ?>" role="tab" data-toggle="tab"><?= ucwords($size) ?></a></li>
            <?php endforeach; ?>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
            <?php foreach ($sizes as $index => $size) : ?>
                <div role="tabpanel" class="tab-pane fade in <?= (!$index) ? 'active' : ''; ?>" id="<?= $size ?>">
                    <?= $this->Image->display($article->article_featured_images[0], $size, ['class' => 'img-responsive']); ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</fieldset>
<?= $this->Form->button(__("Save"), ['class' => 'btn-primary']); ?>
<?= $this->Form->end() ?>
<?php
$url = $this->Url->assetUrl(['action' => 'uploadFromEditor', $article->id, '_ext' => 'json']);
echo $this->element('Cms.ckeditor', ['id' => $idContent, 'url' => $url]);
?>