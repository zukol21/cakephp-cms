<?php
namespace Cms\View\Cell;

use Cake\Collection\Collection;
use Cake\Utility\Text;
use Cake\View\Cell;
use DateTime;

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
        $articles = $this->Articles->find('ByCategory', ['category' => $category]);

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
     * @param  string $categorySlug Category's slug
     * @param  int    $excerptLength Article excerpt's length
     * @return void
     */
    public function single($categorySlug, $excerptLength = self::EXCERPT_LENGTH)
    {
        $category = null;
        $this->loadModel('Cms.Articles');
        $article = $this->Articles
            ->find('ByCategory', ['category' => $categorySlug])
            ->order(['Articles.publish_date' => 'DESC'])
            ->where(['Articles.publish_date <=' => new DateTime('now')])
            ->first();
        if ($article) {
            $article->excerpt = strip_tags($article->excerpt);
            $article->excerpt = Text::truncate($article->excerpt, $excerptLength, ['ellipsis' => '...']);
            //Get the category entity.
            $collection = new Collection($article->get('categories'));
            $category = $collection->firstMatch([
                'slug' => $categorySlug
            ]);
        }
        $this->set(compact('category', 'article'));
    }

    /**
     * Returns published article as of today's date.
     *
     * @param  string $categorySlug Selfexplanatory
     * @return void|bool False, when there is no article found.
     */
    public function publish($categorySlug = null)
    {
        $this->loadModel('Cms.Articles');
        $article = $this->Articles
            ->find('ByCategory', ['category' => $categorySlug])
            ->order(['Articles.publish_date' => 'DESC'])
            ->where(['Articles.publish_date <=' => new DateTime('now')])
            ->first();
        if (!$article) {
            return false;
        }
        $collection = new Collection($article->get('categories'));
        $category = $collection->firstMatch([
            'slug' => $categorySlug
        ]);
        $this->set(compact('article', 'category'));
    }
}
