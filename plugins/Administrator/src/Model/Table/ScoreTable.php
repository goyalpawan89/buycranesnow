<?php
namespace Administrator\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;


$validator = new Validator();

class ScoreTable extends Table
{

    public function initialize(array $config)
        {   
            $this->table('score');
            //$this->primaryKey('id');*/
            
            $this->addBehavior('Timestamp');

           /* $this->addBehavior('Translate', [
		            'fields' => ['value']
		            //translationTable' => 'PostsI18n'
		        ]);

	        $this->belongsTo('Posts');
	        $this->belongsTo('Fields');*/  

         
        
        }


    

}
?>