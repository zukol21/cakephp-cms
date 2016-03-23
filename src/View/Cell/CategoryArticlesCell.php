<?php
namespace Cms\View\Cell;

use Cake\View\Cell;
use Cake\Utility\Text;

/**
 * CategoryArticles cell
 */
class CategoryArticlesCell extends Cell
{
    const EXCERPT_LENGTH = 150;

    /**
     * List of valid options that can be passed into this
     * cell's constructor.
     *
     * @var array
     */
    protected $_validCellOptions = [];

    /**
     * Default display method.
     *
     * @todo : At the moment, default view file is empty and SHOULD be extended by the application.
     * We need to create a generic view to demonstrate the functionallity of the action.
     * @param  string $category Category's name
     * @return void
     */
    public function display($category = null)
    {
        $this->loadModel('Cms.Articles');
        $articles = $this->Articles->find('ByCategory', ['category' => $category, 'featuredImage' => true]);

        if (!$articles->isEmpty()) {
            foreach ($articles as $article) {
                $article->excerpt = strip_tags($article->excerpt);
                $article->excerpt = Text::truncate($article->excerpt, self::EXCERPT_LENGTH, ['ellipsis' => '...']);
            }
        } else {
            $articles = false;
        }

        $this->set(compact('articles'));
    }

    /**
     * Single method for retrieving single article by category.
     *
     * @todo : At the moment, default view file is empty and SHOULD be extended by the application.
     * We need to create a generic view to demonstrate the functionallity of the action.
     * @param  string $category Category's name
     * @param  string $title    Category's title
     * @return void
     */
    public function single($category, $title, $excerptLength = self::EXCERPT_LENGTH)
    {
        $this->loadModel('Cms.Articles');
        $article = $this->Articles->find('ByCategory', ['category' => $category, 'featuredImage' => true])->first();
        if ($article) {
            $article->excerpt = strip_tags($article->excerpt);
            $article->excerpt = Text::truncate($article->excerpt, $excerptLength, ['ellipsis' => '...']);
        }
        $this->set(compact('category', 'title', 'article'));
    }
}
