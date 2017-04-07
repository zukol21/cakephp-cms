<?php
use Cake\Utility\Inflector;

$element = 'Plugin/Cms/' . Inflector::camelize($article->type) . '/single';

// fallback to plugin's element
if (!$this->elementExists($element)) {
    $element = Inflector::camelize($article->type) . '/single';
}

// fallback to default element
if (!$this->elementExists($element)) {
    $element = 'Common/single';
}

$data = ['article' => $article];
?>
<section class="content-header">
    <h1>
        <?php
        if ($article->title) {
            echo Inflector::humanize($article->type) . ' &raquo; ' . h($article->title);
        } else {
            echo h($article->category->name) . ' &raquo; ' . Inflector::humanize($article->type);
        }
        ?>
    </h1>
</section>
<section class="content">
    <div class="row">
    <?= $this->element($element, $data); ?>
    </div>
</section>