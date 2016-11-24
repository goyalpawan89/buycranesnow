<?php
namespace Administrator\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;


$validator = new Validator();

class RankTable extends Table
{

    public function initialize(array $config)  {   

            $this->addBehavior('Timestamp');
            
        }




}
?>