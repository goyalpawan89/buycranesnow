<?php 

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\Table;

class EquipmentsTable extends Table
{

 public function initialize(array $config) {

 		$this->addBehavior('Translate', ['fields' => ['name']]);
        $this->addBehavior('Timestamp');
        
        //$this->table('roles');        
        //$this->table('Roles');

        }
}

?>