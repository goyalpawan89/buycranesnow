<?php
namespace Administrator\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;


$validator = new Validator();

class CategoriesTable extends Table
{

    public function initialize(array $config)
        {

          //public $displayField = "name"; // con title o name lo tomaautomaticamente
		  //var $actsAs = array('Tree');
		   //public $actsAs = array('Tree');
          $this->addBehavior('Timestamp');
          $this->addBehavior('Translate', ['fields' => ['name', 'description']]);
		      $this->addBehavior('Tree');

            $this->belongsToMany('Fields', ['joinTable' => 'fields_categories']);
            $this->belongsToMany('Posts', ['joinTable' => 'categories_posts']);

            $this->belongsTo('Archives'); 

            $this->addBehavior('Translate', ['fields' => ['name', 'description']]);
 
        }


	  


   



}
?>