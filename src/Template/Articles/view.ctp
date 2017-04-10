<?php use Cake\Utility\Inflector; ?>
<section class="content-header">
    <h1>
        <?php
        $typeUrl = $this->Html->link(Inflector::humanize($article->type), [
            'controller' => 'Articles',
            'action' => 'type',
            $article->site->slug,
            $article->type
        ]);
        if ($article->title) {
            echo $typeUrl . ' &raquo; ' . h($article->title);
        } else {
            $categoryUrl = $this->Html->link(h($article->category->name), [
                'controller' => 'Categories',
                'action' => 'view',
                $article->site->slug,
                $article->category->slug
            ]);
            echo $categoryUrl . ' &raquo; ' . $typeUrl;
        }
        ?>
    </h1>
</section>
<section class="content">
    <?= $this->element('Articles/new', [
        'categories' => $categories,
        'site' => $article->site,
        'article' => $newArticle,
        'articleTypes' => $types
    ]) ?>
    <?= $this->element('Articles/single', [
        'article' => $article,
        'articleTypes' => $types
    ]) ?>
</section>