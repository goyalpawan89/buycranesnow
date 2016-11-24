<?php
namespace Administrator\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

$validator = new Validator();

class CitiesTable extends Table
{

    public function initialize(array $config) {   
           
            $this->addBehavior('Timestamp');
            
            //$this->HasOne('Countries', ['foreignKey' => 'code', 'bindingKey' => 'country_code']);
                
    }


}
?>