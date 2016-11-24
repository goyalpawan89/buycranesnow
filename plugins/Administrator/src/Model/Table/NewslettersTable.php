<?php
namespace Administrator\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;


$validator = new Validator();

class NewslettersTable extends Table {

    public function initialize(array $config) {   
            
            $this->addBehavior('Timestamp');
    
    }


 public function validationDefault(Validator $validator) {
        $validator->notEmpty('email', __('Debes ingresar un correo válido.'))
                  ->add('email', ['unique' => ['rule' => 'validateUnique', 
			                  				   'provider' => 'table',
			                  				   'message' => __('El usuario ya se ha registrado.')
			                  				  ]
                  				 ])
				  
				  ->add('email', 'validFormat', ['rule' => 'email',
				  								 'message' => __('Debes ingresar un correo válido.')
				  								]
				  		);

        return $validator;

    }

    

}
