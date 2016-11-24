<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;


$validator = new Validator();

class TrmTable extends Table
{

    public function initialize(array $config)
        {   
            /*$this->table('trms');
            $this->primaryKey('id');*/

            $this->belongsTo('Currency');
            $this->addBehavior('Timestamp');
        
        }


    

}
?>