<?= $this->Html->image($article->article_featured_images[0]->path, [
    'class' => 'img-responsive pad',
    'style' => 'margin: 0 auto;'
]); ?>
<?= $this->Text->truncate($article->excerpt, 200) ?>