<?php
namespace Administrator\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

$validator = new Validator();

class CountriesTable extends Table
{

    public function initialize(array $config) {

            $this->addBehavior('Timestamp');

            //$this->hasMany('Cities', ['foreignKey' => 'country_code', 'bindingKey' => 'code'] );

            $this->addBehavior('Translate', ['fields' => ['name']]);

        }

}
?>