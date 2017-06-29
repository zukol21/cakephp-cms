<?php
$this->start('article-body');
echo $this->fetch('article-body');
echo $this->Text->truncate($article->content, 200);
$this->end();
