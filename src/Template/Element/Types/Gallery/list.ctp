<?php
$this->start('article-body');
echo $this->fetch('article-body');
echo $this->Html->image($article->article_featured_images[0]->path, ['class' => 'img-responsive center-block pad']);
echo $this->Html->tag('div', $this->Text->truncate($article->excerpt, 200), ['class' => 'pad']);
$this->end();