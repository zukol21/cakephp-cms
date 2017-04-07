<?php use Cake\Utility\Inflector; ?>
<section class="content-header">
    <h1><?= h($site->name) . ' &raquo; ' . Inflector::humanize($type) ?></h1>
</section>
<section class="content">
    <?= $this->element('Categories/new_articles', [
        'categories' => $categories,
        'site' => $site,
        'article' => $article,
        'articleTypes' => $types
    ]) ?>
    <?= $this->element('Categories/articles', [
        'articles' => $articles,
        'articleTypes' => $types
    ]) ?>
</section>