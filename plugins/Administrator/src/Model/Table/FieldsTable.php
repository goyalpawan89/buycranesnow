<?php
namespace Administrator\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;


$validator = new Validator();

class FieldsTable extends Table
{

    public function initialize(array $config) {   

            
            $this->addBehavior('Timestamp');

            $this->addBehavior('Translate', ['fields' => ['option_label', 'option_value']]);
            
            $this->belongsToMany('Posts', ['through' => 'FieldsPosts',]);

             
    }


    

}
?>