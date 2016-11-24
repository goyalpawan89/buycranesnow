<?php
namespace Administrator\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

$validator = new Validator();

class ZipCodesTable extends Table
{

    public function initialize(array $config) {   
           
            $this->addBehavior('Timestamp');
            
            $this->table('zip_codes');
                
    }


}
?>