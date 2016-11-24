<?php 
namespace Administrator\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;


$validator = new Validator();

class GadgetsTable extends Table {	

		public function initialize(array $config) {   

			$this->addBehavior('Timestamp');
            $this->addBehavior('Translate', ['fields' => ['name', 'description']]);

            $this->HasMany('GadgetsArchives');

            $this->belongsToMany('Archives', ['joinTable' => 'gadgets_archives']);
           
			  
		}
		  


}

