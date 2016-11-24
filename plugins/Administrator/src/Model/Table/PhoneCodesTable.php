<?php
namespace Administrator\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

$validator = new Validator();

class PhoneCodesTable extends Table
{

    public function initialize(array $config) {

            $this->addBehavior('Timestamp');

            //$this->hasMany('Countries', ['foreignKey' => 'iso3', 'bindingKey' => 'code'] );
            //$this->hasMany('Cities', ['foreignKey' => 'iso3', 'bindingKey' => 'country_code'] );

        }

}
?>