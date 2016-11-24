<?php
namespace Administrator\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;


$validator = new Validator();

class RankingTable extends Table
{

    public function initialize(array $config)
        {   
           /* $this->table('users');
            $this->primaryKey('id');
            $this->displayField('email');*/
            $this->addBehavior('Timestamp');
            
           /* $this->belongsTo('Roles');
            $this->belongsTo('Offices');
            $this->HasMany('Ventas');*/
            
        
        }


    

}
?>