<?php use Cake\Utility\Inflector; ?>
<section class="content-header">
    <h1><?= __('Edit {0}', [Inflector::humanize($this->request->param('pass.1'))]) ?></h1>
</section>
<section class="content">
    <?= $this->element('Articles/post') ?>
</section>