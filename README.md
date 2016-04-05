# Cms plugin for CakePHP

## Setup

You can install this plugin into your CakePHP application using [composer](http://getcomposer.org).

The recommended way to install composer packages is:

Install plugin
```
composer require qobo/cakephp-cms
```

Load plugin
```
bin/cake plugin load QoboAdminPanel
```

## WYSIWYG editor

The plugin's WYSIWYG editor is [CKEditor 4.5.8](http://ckeditor.com/) which is used to create/edit the article content.
The following documentation requires some basic knowledge of CKeditor.

### CKEditor distribution
We use the full-all distribution which contains all of the plugins of the editor. You can see more details [here](https://cdn.ckeditor.com/).

### Customized CKEditor

#### Custom config
With CKeditor, you can load your own configuration file and this is what we do in our plugin. If you would like to load your configuration then override the following value in your application or plugin.

```php
Configure::write('Cms.ckeditor.upload.plugin.url', 'path-to-your-js-file');
```

#### Upload plugin
The [upload plugin](http://ckeditor.com/addon/imagepaste) of CKEditor is used so we can enable drag & drop feature in the textarea. If you would like to load your configuration then override the following value in your application or plugin.

```php
Configure::write('Cms.ckeditor.upload.plugin.url', 'path-to-your-js-file');
```

## ToDo
1. Add documentation for Articles, Categories
2. PHPUnit tests