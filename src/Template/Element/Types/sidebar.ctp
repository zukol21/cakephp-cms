<?php use Cake\Utility\Inflector; ?>
<div class="box box-solid">
    <div class="box-header with-border">
        <i class="fa fa-tags"></i>
        <h3 class="box-title"><?= __('Read More') ?></h3>
    </div>
    <div class="box-body no-padding">
        <ul class="nav nav-stacked">
            <?php foreach ($types as $type => $typeOptions) : ?>
            <li>
                <?= $this->Html->link(Inflector::pluralize($typeOptions['label']), [
                    'controller' => 'Articles',
                    'action' => 'type',
                    $site->slug,
                    $type
                ]) ?>
            </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>