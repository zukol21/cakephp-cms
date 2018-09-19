# Cms plugin for CakePHP

[![Build Status](https://travis-ci.org/QoboLtd/cakephp-cms.svg?branch=master)](https://travis-ci.org/QoboLtd/cakephp-cms)
[![Latest Stable Version](https://poser.pugx.org/qobo/cakephp-cms/v/stable)](https://packagist.org/packages/qobo/cakephp-cms)
[![Total Downloads](https://poser.pugx.org/qobo/cakephp-cms/downloads)](https://packagist.org/packages/qobo/cakephp-cms)
[![Latest Unstable Version](https://poser.pugx.org/qobo/cakephp-cms/v/unstable)](https://packagist.org/packages/qobo/cakephp-cms)
[![License](https://poser.pugx.org/qobo/cakephp-cms/license)](https://packagist.org/packages/qobo/cakephp-cms)
[![codecov](https://codecov.io/gh/QoboLtd/cakephp-cms/branch/master/graph/badge.svg)](https://codecov.io/gh/QoboLtd/cakephp-cms)

## About

Content management plugin for CakePHP 3+.

This plugin is developed by [Qobo](https://www.qobo.biz) for [Qobrix](https://qobrix.com).  It can be used as standalone CakePHP plugin, or as part of the [project-template-cakephp](https://github.com/QoboLtd/project-template-cakephp) installation.

## Requirements

**Plugins:**
- [Cakephp-Tinymce-Elfinder](https://github.com/hashmode/cakephp-tinymce-elfinder)
- [UseMuffin/Slug](https://github.com/UseMuffin/Slug)
- [UseMuffin/Trash](https://github.com/UseMuffin/Trash)

## Setup

You can install this plugin into your CakePHP application using [composer](http://getcomposer.org).

The recommended way to install composer packages is:

Install plugin

```
composer require qobo/cakephp-cms
```

Load required plugins

```
bin/cake plugin load Qobo/Utils --bootstrap
bin/cake plugin load Muffin/Trash
bin/cake plugin load Muffin/Slug
bin/cake plugin load Burzum/FileStorage
bin/cake plugin load CakephpTinymceElfinder --routes
```

Load plugin

```
bin/cake plugin load Cms --routes --bootstrap

```

Run migrations

```
bin/cake migrations migrate -p Burzum/FileStorage
bin/cake migrations migrate -p Cms
```

Configure AdminLTE theme as per the instructions in
[Qobo/Utils](https://github.com/QoboLtd/cakephp-utils/) plugin.

Load CakePHP TinyMCE elFinder helper from `initialize()` method of `src/View/AppView.php`:

```php
public function initialize()
{
    $this->loadHelper('Form', ['className' => 'AdminLTE.Form']);
    $this->loadHelper('CakephpTinymceElfinder.TinymceElfinder');
}
```

To load site management UI component add below lines to your application's bootstrap file.

```php
// config/bootstrap.php
use Cake\Event\EventManager;
use Cms\Event\View\SitesManageListener;
EventManager::instance()->on(new SitesManageListener());
```

Note, that some of the plugin functionality relies on user authentication being implemented.
You can either follow the instructions [here](https://book.cakephp.org/3.0/en/tutorials-and-examples/blog-auth-example/auth.html)
or update the references to the Auth component in relevant controllers, models, and template.

Once all is done, navigate to `/cms/sites/` to get started with the content management.

## WYSIWYG editor

The plugin's WYSIWYG editor is [tinyMCE 4.*](https://www.tinymce.com) which is used to create/edit the article content.

## Documentation

For documentation see the [docs](docs/README.md) directory of this repository.
