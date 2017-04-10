<section class="content-header">
    <h1><?= __('Create {0}', ['Category']) ?></h1>
</section>
<section class="content">
    <div class="row">
        <div class="col-xs-12 col-md-6">
            <div class="box box-solid">
                <?= $this->Form->create($category); ?>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">
                            <?= $this->Form->input('name') ?>
                        </div>
                        <div class="col-md-6">
                            <?= $this->Form->input('parent_id', [
                                'options' => $categories,
                                'escape' => false,
                                'empty' => true
                            ]) ?>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <?= $this->Form->button(__('Submit'), ['class' => 'btn btn-primary']) ?>
                </div>
                <?= $this->Form->end() ?>
        </div>
    </div>
</section>