<?php
namespace App\Model\Table;

use App\Model\Entity\Article;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
/**
 * Articles Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Categories
 * @property \Cake\ORM\Association\BelongsTo $Users
 */
class ArticlesTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('articles');
        $this->displayField('title');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsToMany('Media', [
            'foreignKey' => 'article_id',
            'targetForeignKey' => 'media_id',
            'joinTable' => 'articles_media'
        ]);

        $this->belongsTo('FeaturedMedia', [
            'className' => 'Media',
            'propertyName' => 'featured_media',
            'foreignKey' => 'featured_image',
        ]);

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id'
        ]);

        $this->belongsTo('Categories', [
            'foreignKey' => 'category_id',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->add('id', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('id', 'create');

        $validator
            ->allowEmpty('title');

        $validator
            ->allowEmpty('body');

        return $validator;
    }

    public function validationAdd(Validator $validator)
    {
        $validator
            ->add('id', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('id', 'create');
        // $validator
        //     ->add('is_featured', 'custom', [
        //         'rule' =>
        //         function ($value,$context) {
        //           if(empty($context['data']['featured_image']['name']) && $value == "1")
        //           {
        //             return false;
        //           }
        //           return true;
        //         }
        //         ,
        //         'message' => 'Cannot make article featured without a featured image'
        //     ]);

        $validator
            ->allowEmpty('title');

        $validator
            ->allowEmpty('body');

        return $validator;
    }


    private function extractImages($string){
      $return  = [];

      $doc = new \DOMDocument();

      $doc->loadHTML($string);
      $xpath = new \DOMXPath($doc);
      $serverName = Router::url('/', true);
      $query = "//img/@src[starts-with(., '$serverName')]";
      $nodelist = $xpath->query($query);
      foreach ($nodelist as $element) {
        //print_r($element->value);
        array_push($return, $element->value);
        //echo $element->attributes->getNamedItem('src')->nodeValue;
      }
      return $return;
    }

    public function beforeMarshal( $event, \ArrayObject $data, \ArrayObject $options)
    {
      $media = TableRegistry::get('Media');
      $mediaArray = $this->extractImages($data['body']);
      $data['media']['_ids'] = [];
      foreach($mediaArray as $filename){
        array_push($data['media']['_ids'], $media->getIdFromFilename(str_replace(Router::url('/', true)."img/","",$filename)));
      }

  if(isset($data['featured_image']) && $data['featured_image']['name']!=''){
    $featuredImage = $media->newEntity(['filename'=>$data['featured_image']]);
    $media->save($featuredImage);
    $data['featured_image'] = $featuredImage->id;
  }

    }

    public function getFeaturedArticles(){
      $query = $this->find('all',['contain'=>['FeaturedMedia'],'conditions'=>['Articles.is_featured = 1','Articles.featured_image IS NOT NULL']]);
      return $query;
    }

    // public function prepareFeatured(&$article){
    //   var_dump($article);
    //   //$article = preg_replace("/<img[^>]+\>/i", "", $article);
    // }

    // public function getArticlesOnMain(){
    //
    //   $filterArticles = function ($article, $key, $mapReduce){
    //     $article['body'] = preg_replace("/<img[^>]+\>/i", "", $article['body']);
    //     if(isset($article->featuredMedia->filename)){
    //       $featuredImage = $article->featuredMedia->filename;
    //     }
    //     else{
    //       $featuredImage = null;
    //     }
    //     $mapReduce->emitIntermediate($article,$featuredImage);
    //   };
    //
    //   $prepareArticles = function ($articles, $featuredImage, $mapReduce) {
    //   $mapReduce->emit($articles, $featuredImage);
    //   };
    //
    //
    //   $query = $this
    //     ->find('all',['contain'=>['FeaturedMedia','Users']])
    //     ->mapReduce($filterArticles, $prepareArticles);
    //
    //   return $query;
    // }

    public function limitWords($string, $wordLimit)
{
    $words = explode(" ",$string);
    return implode(" ",array_splice($words,0,$wordLimit));
}

    public function getArticlesOnMain($categoryId = null){

        $query = $this
          ->find('all',['contain'=>['FeaturedMedia','Users']]);
          if($categoryId !=null){
            $query->where(['category_id'=>$categoryId]);
          }
          $query->formatResults(function (\Cake\Datasource\ResultSetInterface $results) {
              return $results->map(function ($row) {
                  $row['body'] = preg_replace("/<img[^>]+\>/i", "", $this->limitWords($row['body'], 100));
                  return $row;
              });
          });
        return $query;
    }

    public function isOwnedBy($articleId, $userId)
    {
        return $this->exists(['id' => $articleId, 'user_id' => $userId]);
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['user_id'], 'Users'));
        return $rules;
    }
}
