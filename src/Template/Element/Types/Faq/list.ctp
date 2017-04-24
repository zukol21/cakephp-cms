<?php
$this->append('article-box-classes', 'collapsed-box');
$this->prepend('article-action-buttons', $this->Html->link('<i class="fa fa-plus"></i>', '#', [
    'class' => 'btn btn-box-tool',
    'data-widget' => 'collapse',
    'escape' => false
]));
$this->append('article-body', $this->Text->truncate($article->content, 200));
