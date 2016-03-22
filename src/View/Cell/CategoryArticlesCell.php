<?php
namespace Cms\View\Cell;

use Cake\View\Cell;

/**
 * CategoryArticles cell
 */
class CategoryArticlesCell extends Cell
{

    /**
     * List of valid options that can be passed into this
     * cell's constructor.
     *
     * @var array
     */
    protected $_validCellOptions = [];

    /**
     * Default display method.
     * @param  string $category Category's name
     * @param  string $title    Category's title
     * @return void
     */
    public function single($category, $title)
    {
        $this->loadModel('Cms.Articles');
        $article = $this->Articles->find('ByCategory', ['category' => $category, 'featuredImage' => true])->first();
        if ($article) {
            //Limit the excerpt so it doesn't break the design
        }
        $this->set(compact('category', 'title', 'article'));
    }
}
