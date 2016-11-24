<?php
namespace Administrator\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;


$validator = new Validator();

class FieldsPostsTable extends Table
{

    public function initialize(array $config)
        {   
            $this->table('fields_posts');
            //$this->primaryKey('id');*/
            
            //$this->addBehavior('Timestamp');

            $this->addBehavior('Translate', [
		            'fields' => ['value']
		            //translationTable' => 'PostsI18n'
		        ]);

	        $this->belongsTo('Posts');
	        $this->belongsTo('Fields');

         
        
        }


    

}
?>