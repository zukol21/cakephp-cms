<?php
use Cake\I18n\Time;

echo $this->Html->css(
    [
        'AdminLTE./plugins/daterangepicker/daterangepicker-bs3',
        'AdminLTE./plugins/select2/select2.min',
        'Cms.select2-bootstrap.min',
        'Cms.style'
    ],
    [
        'block' => 'css'
    ]
);
echo $this->Html->script(
    [
        'AdminLTE./plugins/daterangepicker/moment.min',
        'AdminLTE./plugins/daterangepicker/daterangepicker',
        'AdminLTE./plugins/select2/select2.full.min',
        'Cms.select2.init',
        'Cms.datetimepicker.init',
    ],
    ['block' => 'scriptBotton']
);

$formOptions = ['type' => 'file'];
if (!empty($url)) {
    $formOptions['url'] = $url;
}

$publishDate = $article && $article->publish_date ?
    $article->publish_date->i18nFormat('yyyy-MM-dd HH:mm') :
    Time::now()->i18nFormat('yyyy-MM-dd HH:mm');
?>
<?= $this->Form->create($article, $formOptions) ?>
<div class="row">
    <div class="col-lg-4 col-lg-push-8">
        <?= $this->Form->input('category_id', [
            'type' => 'select',
            'options' => $categories,
            'class' => 'select2',
            'required' => true
        ]); ?>
        <?= $this->Form->input('publish_date', [
            'type' => 'text',
            'required' => true,
            'class' => 'datetimepicker',
            'autocomplete' => 'off',
            'value' => $publishDate,
            'templates' => [
                'input' => '<div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </div>
                    <input type="{{type}}" name="{{name}}"{{attrs}}/>
                </div>'
            ]
        ]) ?>
    </div>
    <div class="col-lg-8 col-lg-pull-4">
        <?= $this->element('Articles/field', [
            'typeOptions' => $typeOptions,
            'article' => $article
        ]) ?>
    </div>
</div>
<?= $this->Form->button(__('Submit'), ['class' => 'btn btn-primary']) ?>
<?= $this->Form->end() ?>