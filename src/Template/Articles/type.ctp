<?php use Cake\Utility\Inflector; ?>
<section class="content-header">
    <h1><?= h($site->name) . ' &raquo; ' . Inflector::humanize($type) ?></h1>
</section>
<section class="content">
    <?= $this->element('Articles/new', [
        'categories' => $categories,
        'site' => $site,
        'article' => $article,
        'articleTypes' => $types
    ]) ?>
    <?= $this->element('Articles/list', [
        'articles' => $articles,
        'articleTypes' => $types
    ]) ?>
</section>