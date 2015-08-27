<?php
namespace App\Model\Behavior;

use Cake\Event\Event;
use Cake\ORM\Behavior;
use Cake\ORM\Entity;
use Cake\ORM\Query;
use Cake\Utility\Inflector;

class SluggableBehavior extends Behavior
{
    protected $_defaultConfig = [
        'field' => 'title',
        'slug' => 'slug',
        'replacement' => '-',
    ];
    
    public function findSlugId(Query $query, array $options){
        $query->where(['slug' => $options['slug']]);
        $query->find('list', [
        'keyField' => 'slug',
        'valueField' => 'id'
        ]);
        return $query;
    }
    
    public function initialize(array $config)
    {
        // Some initialization code here
    }
    
    public function slug(Entity $entity)
    {
        $config = $this->config();
        $value = $entity->get($config['field']);
        $entity->set($config['slug'], Inflector::slug(mb_strtolower($value), $config['replacement']));
    }
    
    public function beforeSave(Event $event, Entity $entity)
    {
        $this->slug($entity);
    }
    
    public function findSlug(Query $query, array $options)
    {
        return $query->where([$this->_table->alias().'.'.'slug' => $options['slug']]);
    }
    
}