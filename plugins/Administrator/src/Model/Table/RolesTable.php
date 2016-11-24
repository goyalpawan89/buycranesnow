<?php 

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\Table;

class RolesTable extends Table
{

 public function initialize(array $config)
        {
        	$this->table('roles');
            $this->primaryKey('id');
            $this->displayField('name');
            $this->addBehavior('Timestamp');
        //$this->table('roles');        
        //$this->table('Roles');

        }
}

?>