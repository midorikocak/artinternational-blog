<?php
namespace App\View\Cell;

use Cake\View\Cell;

/**
 * Featured cell
 */
class FeaturedCell extends Cell
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
     *
     * @return void
     */
    public function display()
    {
      $this->loadModel('Articles');
      $featuredArticles = $this->Articles->getFeaturedArticles()->toArray();
      $this->set(compact('featuredArticles'));
      $this->set('_serialize', ['featuredArticles']);
    }
}
