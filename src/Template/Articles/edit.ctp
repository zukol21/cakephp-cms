<?php
$this->extend('QoboAdminPanel./Common/panel-wrapper');
$this->assign('title', __d('QoboAdminPanel', 'Articles'));
$this->assign('panel-title', __d('QoboAdminPanel', 'Articles information'));
?>
<?= $this->Form->create($article, ['type' => 'file']); ?>
<fieldset>
    <legend><?= __('Edit {0}', ['Article']) ?></legend>
    <?php
    echo $this->Form->input('title');
    echo $this->Form->input('slug');
    echo $this->Form->input('excerpt', ['type' => 'textarea', 'id' => 'editor1']);
    echo $this->Form->input('content', ['type' => 'textarea', 'id' => 'editor2']);
    echo $this->Form->input('category',[
        'options' => $categories,
        'value' => $article->category,
    ]);
    echo $this->Form->input('created_by');
    echo $this->Form->input('modified_by');
    echo $this->Form->input('publish_date');
    ?>
    <div class="form-group">
        <label class="control-label" for="featured-image">Featured Image</label>
        <?php
        echo $this->Form->file('file');
        echo $this->Form->error('file');
        ?>
    </div>
    <div>
        <div class="form-group">
            <label class="control-label" for="featured-image">Featured Image sizes</label>
        </div>
        <?php
        /**
         * @todo: Read the configuration and make the following dynamic. The application can override the config
         * and have different sizes.
         */
        ?>
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#small" aria-controls="small" role="tab" data-toggle="tab">Small</a></li>
            <li role="presentation"><a href="#medium" aria-controls="medium" role="tab" data-toggle="tab">Medium</a></li>
            <li role="presentation"><a href="#large" aria-controls="large" role="tab" data-toggle="tab">Large</a></li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane fade in active" id="small">
                <?= $this->Image->display($article->article_featured_images[0], 'small', ['class' => 'img-responsive']); ?>
            </div>
            <div role="tabpanel" class="tab-pane fade" id="medium">
                <?= $this->Image->display($article->article_featured_images[0], 'medium', ['class' => 'img-responsive']); ?>
            </div>
            <div role="tabpanel" class="tab-pane fade" id="large">
                <?= $this->Image->display($article->article_featured_images[0], 'large', ['class' => 'img-responsive']); ?>
            </div>
        </div>
    </div>
</fieldset>
<?= $this->Form->button(__("Save"), ['class' => 'btn-primary']); ?>
<?= $this->Form->end() ?>
