# Cms plugin for CakePHP

## Requirements

[Cakephp-Tinymce-Elfinder](https://github.com/hashmode/cakephp-tinymce-elfinder) plugin
[UseMuffin/Slug](https://github.com/UseMuffin/Slug) plugin
[UseMuffin/Trash](https://github.com/UseMuffin/Trash) plugin

## Setup

You can install this plugin into your CakePHP application using [composer](http://getcomposer.org).

The recommended way to install composer packages is:

Install plugin
```
composer require qobo/cakephp-cms
```

Load plugin
```
bin/cake plugin load Cms
```

Load required plugin(s)
```
bin/cake plugin load Muffin/Trash
bin/cake plugin load Muffin/Slug
bin/cake plugin load CakephpTinymceElfinder --routes
```

## WYSIWYG editor

The plugin's WYSIWYG editor is [tinyMCE 4.*](https://www.tinymce.com) which is used to create/edit the article content.

## ToDo
1. Add documentation for Articles, Categories
2. PHPUnit tests