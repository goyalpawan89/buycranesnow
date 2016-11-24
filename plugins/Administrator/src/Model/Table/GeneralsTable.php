<?php
namespace Administrator\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;


$validator = new Validator();

class GeneralsTable extends Table
{

    public function initialize(array $config)
        {   
           /* $this->table('users');
            $this->primaryKey('id');
            $this->displayField('email');*/
            $this->addBehavior('Timestamp');

			$this->addBehavior('Translate', ['fields' => ['option_value']]);
        
        }


    

}
?>