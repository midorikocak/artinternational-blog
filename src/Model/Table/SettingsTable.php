<?php
namespace App\Model\Table;

use App\Model\Entity\Setting;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Settings Model
 *
 */
class SettingsTable extends Table
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

        $this->table('settings');
        $this->displayField('value');
        $this->primaryKey(['collection', 'name']);

    }


        public function getKeyValueFields(){
          $query = $this->find('list',[
            'keyField' => 'name',
            'valueField' => 'value',
            'groupField' => 'collection'
            ]);

          return $query->toArray();
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
            ->allowEmpty('collection', 'create');

        $validator
            ->allowEmpty('name', 'create');

        $validator
            ->allowEmpty('value');

        return $validator;
    }
}
