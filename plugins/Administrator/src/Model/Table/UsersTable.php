<?php
namespace Administrator\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;


$validator = new Validator();

class UsersTable extends Table
{

    public function initialize(array $config)  {   

            $this->addBehavior('Timestamp');
            
            $this->belongsTo('Roles');
            $this->HasMany('Posts');
            $this->belongsTo('Archives');

            $this->belongsTo('Countries', ['foreignKey' => 'company_country', 'targetForeignKey' => 'name', 'propertyName' => 'countries']);
            $this->belongsTo('Cities', ['foreignKey' => 'company_city', 'targetForeignKey' => 'name', 'propertyName' => 'cities']);

            //alquilar comprar grua
            $this->HasMany('SellRent', ['joinTable' => 'sell_rent']);

            $this->HasMany('PostsUsers', ['joinTable' => 'posts_users']);

            $this->HasMany('Payments');

            $this->belongsToMany('Equipments', ['joinTable' => 'users_equipments']);

        
        }


    public function validationDefault(Validator $validator)
    {
        $validator
            ->notEmpty('email', __('Debes ingresar un correo válido.'))

            ->add('email', [
			    'unique' => ['rule' => 'validateUnique', 
			    			 'provider' => 'table',
			    			 'message' => __('El usuario ya existe.')]
			])
            ->add('email', 'validFormat', [
                'rule' => 'email',
                'message' => __('Debes ingresar un correo válido.')
            ])

            ->add('identification', [
                'unique' => ['rule' => 'validateUnique', 
                             'provider' => 'table',
                             'message' => __('El número de identificación ya existe.')]
            ])
        

            //Validacion Contraseña
            /* ->add('password', [
                'unique' => ['rule' => 'validateUnique', 
                             'provider' => 'table',
                             'message' => __('El número de identificación ya existe.')]
            ])*/

            /*->notEmpty('password', 'Dato vacio')
            ->notEmpty('password_confirmation', 'Dato vacio')*/

           /* ->add('password',
                    'compareWith', [
                        'rule' => 'matchPasswords',
                        'message' => 'Tus contraseñas no coinciden.'
                    ]
                )
*/
           
                   // 'Validar contraseñas' => array('rule' => 'matchPasswords', 'message' => 'Tus contraseñas no coinciden') ),
           

            //Validacion Contraseña

           /* ->notEmpty('role', 'A role is required')
            ->add('role', 'inList', [
                'rule' => ['inList', ['admin', 'author', 'test123']],
                'message' => __('El rol ingresado no es valido.')
            ]);*/
;

            // pr($errors = $validator->errors($this->request->data(), false));

        return $validator;

    }





}
?>