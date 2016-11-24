<?php
namespace Administrator\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;


$validator = new Validator();

class UsersEquipmentsTable extends Table
{

    public function initialize(array $config) {   
            
	        $this->hasMany('Users');

            $this->displayField('equipment_id');
        
        }


    

}
?>