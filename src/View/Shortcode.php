<?php
/**
 * Copyright (c) Qobo Ltd. (https://www.qobo.biz)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Qobo Ltd. (https://www.qobo.biz)
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */
namespace Cms\View;

use Cake\Core\Configure;
use Cake\View\View;
use Cms\Model\Entity\Article;
use DirectoryIterator;
use elFinder;
use Exception;

class Shortcode
{
    protected static $imageExtensions = ['jpeg', 'jpg', 'png', 'gif'];

    /**
     * Parse article shortcodes.
     *
     * @param \Cms\Model\Entity\Article $article Article entity
     * @param array $fields Type fields
     * @param \Cake\View\View $view View instance
     * @return \Cms\Model\Entity\Article
     */
    public static function parse(Article $article, array $fields, View $view)
    {
        if (empty($fields)) {
            return $article;
        }

        foreach ($fields as $info) {
            $fieldName = $info['field'];

            // skip empty values
            if (!$article->get($fieldName)) {
                continue;
            }

            // skip non-editor fields
            if (!$info['editor']) {
                continue;
            }

            $result = $article->get($fieldName);
            preg_match_all('/\[gallery path="(.*?)"\]/', $result, $matches);

            if (empty($matches[1])) {
                continue;
            }

            foreach ($matches[1] as $path) {
                $result = str_replace($matches[0], static::renderGallery($path, $view), $result);
                $article->set($fieldName, $result);
            }
        }

        return $article;
    }

    /**
     * Render gallery shortcode.
     *
     * @param string $path Directory path
     * @param \Cake\View\View $view View instance
     * @return string
     */
    protected static function renderGallery($path, View $view)
    {
        $path = trim($path, DIRECTORY_SEPARATOR);

        try {
            $it = new DirectoryIterator(WWW_ROOT . $path);
        } catch (Exception $e) {
            return '<div class="alert alert-danger" role="alert">Failed to find files in: ' . $path . '</div>';
        }

        $result = '<div class="row">';
        foreach ($it as $file) {
            if (!$file->isFile()) {
                continue;
            }

            if (!in_array(strtolower($file->getExtension()), static::$imageExtensions)) {
                continue;
            }

            $options = Configure::read('TinymceElfinder.options');

            $elFinder = new elFinder($options);
            $volume = $elFinder->getVolume('l' . $options['roots'][0]['id'] . '_');

            $hash = $volume->getHash(dirname($file->getPathname()), $file->getFilename());
            $stat = $volume->file($hash);

            $tmbname = $stat['hash'] . $stat['ts'] . '.png';

            $thumbPath = $options['roots'][0]['path'] . DS . $options['roots'][0]['tmbPath'] . DS . $tmbname;
            $thumbUrl = $options['roots'][0]['URL'] . '/' . $options['roots'][0]['tmbPath'] . '/' . $tmbname;

            // generate non-existing thumbnail
            if (!file_exists($thumbPath)) {
                $volume->tmb($hash);
            }

            $image = $view->Html->image($thumbUrl, ['class' => 'thumbnail']);
            $link = $view->Html->link($image, '/' . $path . '/' . $file->getFilename(), [
                'data-lightbox' => 'gallery',
                'escape' => false
            ]);
            $result .= '<div class="col-xs-4 col-md-3 col-lg-2">' . $link . '</div>';
        }
        $result .= '</div>';

        return $result;
    }
}
