<?php
namespace Administrator\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;


$validator = new Validator();

class CompareTable extends Table
{

    public function initialize(array $config)  {   

            $this->addBehavior('Timestamp');

            /*$this->hasMany('Posts', [
            	'foreignKey' => 'id',
            	]);*/

			$this->belongsTo('Posts',[
				'foreignKey' => 'post_id',
				]);
            
        }




}
?>