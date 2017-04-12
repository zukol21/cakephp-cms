<?= $this->Html->image($article->article_featured_images[0]->path, ['class' => 'img-responsive center-block pad']); ?>
<?= $this->Text->truncate($article->excerpt, 200) ?>