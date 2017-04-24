<?php
$this->start('article-body');
echo $this->fetch('article-body');
echo $this->Html->link($article->content, $article->content, ['target' => '_blank']);
$this->end();
