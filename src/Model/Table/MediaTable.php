<?php
namespace App\Model\Table;

use App\Model\Entity\Media;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Routing\Router;

/**
* Media Model
*
* @property \Cake\ORM\Association\BelongsToMany $Articles
*/
class MediaTable extends Table
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

    $this->table('media');
    $this->displayField('filename');
    $this->primaryKey('id');

    $this->hasMany('FeaturedArticles', [
        'className' => 'Articles',
        'foreignKey' => 'featured_image',
        'propertyName' => 'featured_articles'
    ]);

    $this->belongsToMany('Articles', [
      'foreignKey' => 'media_id',
      'targetForeignKey' => 'article_id',
      'joinTable' => 'articles_media'
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
      ->requirePresence('filename', 'create')
      ->notEmpty('filename');

      $validator
      ->allowEmpty('description');

      return $validator;
    }

    protected function saveFile($file){
      if(isset($file['error']) && $file['error']==0){

        $allowedExts = array("gif", "jpeg", "jpg", "png");
        $temp = explode(".", $file["name"]);
        $extension = end($temp);

        if ((($file["type"] == "image/gif")
        || ($file["type"] == "image/jpeg")
        || ($file["type"] == "image/jpg")
        || ($file["type"] == "image/pjpeg")
        || ($file["type"] == "image/x-png")
        || ($file["type"] == "image/png"))
        && ($file["size"] < 2000000)
        && in_array($extension, $allowedExts)) {
          if (file_exists(WWW_ROOT . 'img' . DS . $file["name"])) {
            return null;
          } else {
            $rand = substr(md5(microtime()),rand(0,26),5);
            move_uploaded_file($file["tmp_name"],
            WWW_ROOT . 'img' . DS . $rand . '.' . $file["name"]);
            chmod(WWW_ROOT . 'img'. DS . $rand . '.' . $file["name"], 0777);
            // Önce veritabanı sorgumuzu hazırlayalım.
            return $rand . '.' . $file["name"];
          }
        } else {
          return null;
        }
      }elseif(!empty($file)){
        return $file;
      }
      return null;
    }

    public function beforeDelete($event, $entity, $options)
    {
      @unlink(WWW_ROOT . 'img' . DS . $entity['filename']);
    }

    public function getIdFromFilename($filename){
      $query =  $this->find('all',['conditions'=>['filename'=>$filename]]);
      if(!empty($query->first())){
        return $query->first()->id;
      }
    }

    public function beforeMarshal( $event, \ArrayObject $data, \ArrayObject $options)
    {
      $data['filename'] = $this->saveFile($data['filename']);
    }

    public function afterSave($event, $entity, $options){

    }
    // public function beforeSave($event, $entity, $options)
    // {
    //   return false;
    // }
  }
