<?php
// in src/Form/ContactForm.php
namespace App\Form;

use Cake\Form\Form;
use Cake\Form\Schema;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;

class SettingsForm extends Form
{

    public function getKeyValueFields(){
      $settings = TableRegistry::get('Settings');
      $query = $settings->find('list',[
        'keyField' => 'name',
        'valueField' => 'value',
        'groupField' => 'collection'
        ]);

      return $query->toArray();
    }

    protected function _buildSchema(Schema $schema)
    {
      $fields = $this->getKeyValueFields();
      foreach($fields as $formGroup => $groupValues){
        foreach($groupValues as $name => $value){
          $schema->addField($formGroup.'.'.$name,'string');
        }
      }
        return $schema;
    }

    protected function _buildValidator(Validator $validator)
    {
        return $validator;
    }

    protected function _execute(array $data)
    {
      $dataToSave = [];
      $list =[];

      foreach($data as $formGroup => $groupValues){
        foreach($groupValues as $name => $value){
          array_push($dataToSave,['collection'=>$formGroup, 'name'=> $name, 'value'=>$value]);
          array_push($list,['collection'=>$formGroup, 'name'=> $name]);
        }
      }

        $settings = TableRegistry::get('Settings');
        $patched = $settings->patchEntities($list,$dataToSave);

        foreach ($patched as $entity) {
          $settings->save($entity);
        }

        return true;
    }
}
