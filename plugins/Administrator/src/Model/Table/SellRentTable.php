<?php
namespace Administrator\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;


$validator = new Validator();

class SellRentTable extends Table
{

    public function initialize(array $config)
        {   
            $this->table('sell_rent');
            //$this->primaryKey('id');*/
            
            $this->addBehavior('Timestamp');

            $this->belongsTo('Posts', ['joinTable' => 'sell_rent']);
            $this->belongsTo('Users', ['joinTable' => 'sell_rent']);
            $this->hasMany('Offers', ['joinTable' => 'sell_rent']);

         
        
        }


    

}
?>