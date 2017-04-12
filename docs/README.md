# Documentation

This plugin is a content management system (CMS) for [CakePHP](http://cakephp.org/) [3](https://github.com/cakephp/cakephp).

## Sites

Site slugs are unique throughout the system.

This plugin has multi-site support, so you can generate categories and articles on a per-site basis.

## Categories

Category slugs are unique on per-site basis, meaning you can have a category with slug `foobar` for each of your sites.

## Articles

Article slugs are unique throughout the system and each article must be assigned a site category.

You can view all articles, in a masonry layout, under a specific category by accessing the following url:
`/cms/site/[site_slug]/category/[category_slug]/view`

## Article types

Article types are configured in `Configure::read('CMS.Articles.types')`.

The plugin defines four standard article types:
- Article
- Gallery
- Link
- FAQ

Types can be overriden/extended/removed by modifying the `CMS.Articles.types` configuration.

Each article type requires a configuration as shown in `config/cms.php`.

There are two rendering layouts for each article type, one for the listing and one for the single view. Both layouts have default elements which are used as fallbacks.

When you define a new article type, you can control its layout by creating two elements in the following paths (you can copy the plugin's ones as a starting point):
```
src/Template/Element/Plugin/Cms/[type_name_camel_cased]/list.ctp
src/Template/Element/Plugin/Cms/[type_name_camel_cased]/single.ctp
```

You can view all articles under a specific type by accessing the following url:
`/cms/site/[site_slug]/type/[type_slug]/view`