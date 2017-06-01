<?php
namespace Cms\View;

use Cake\View\View;
use Cms\Model\Entity\Article;
use DirectoryIterator;
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
            $it = new DirectoryIterator(WWW_ROOT . 'uploads' . DIRECTORY_SEPARATOR . $path);
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

            $image = $view->Html->image('/uploads/' . $path . '/' . $file->getFilename(), ['class' => 'thumbnail']);
            $result .= '<div class="col-xs-6 col-md-3">' . $image . '</div>';
        }
        $result .= '</div>';

        return $result;
    }
}
