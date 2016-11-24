<?php
namespace Administrator\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;


$validator = new Validator();

class AlertsTable extends Table
{

    public function initialize(array $config) {
            
        	$this->addBehavior('Timestamp');

        	$this->belongsTo('Users', ['conditions' => ['Users.status' => 'active']] ); 
                    
        }




}

