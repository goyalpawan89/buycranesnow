<?php 

namespace Administrator\Model\Entity;

use Cake\Auth\DefaultPasswordHasher;
use Cake\ORM\Entity;
use Cake\ORM\Behavior\TimestampBehavior;

class Generals extends Entity
{

    protected $_accessible = ['*' => true];
    //protected $_accessible = ['password' => false];

	
	
    protected function _setPassword($password)
    {
        return (new DefaultPasswordHasher)->hash($password);
    }

	/*public $displayField = "name"; 
	public $name = "User";
		  
	public $belongsTo = array('Role');

	public $validate = array(
        'first_name' => array('Campo obligatorio' => array('rule' => 'notEmpty', 'message' => "Completa el campo")),
		 
		'identification' => array('Campo obligatorio' => array('rule' => 'notEmpty', 'message' => "Completa el campo"),
		                         'El usuario ya existe' => array('rule' => 'isUnique', 'message' => 'El usuario ya existe')),
							 					 
		'email' => array('Validacion de email' => array('rule' => 'email', 'message' => "Agrega una dirección valida"),
		                'El correo ya existe' => array('rule' => 'isUnique', 'message' => 'El usuario ya existe')),
		 
		'password' => array('Campo obligatorio' => array('rule' => 'notEmpty', 'message' => 'Agrega una contraseña'),
		                   'Validar contraseñas' => array('rule' => 'matchPasswords', 'message' => 'Tus contraseñas no coinciden') ),
		 
		'password_confirmation' => array('Campo obligatorio' => array('rule' => 'notEmpty', 'message' => 'confirma la contraseña'))
  	);
	  
	public function matchPasswords($data) {
	  	if($data['password'] == $this->data['User']['password_confirmation'])  { return true; } $this->invalidate('password_confirmation', 'Tus contraseñas no coinciden'); return false;
	}
	  
	public function beforeSave($options = array()){
		  
	  if(isset($this->data['User']['password']) && $this->data['User']['nuevo']==1) {
		  $this->data['User']['password'] = AuthComponent::password($this->data['User']['password']);   return true; 
	    } else {
		  if(isset($this->data['User']['nuevo'])) { $this->data['User']['password'] = AuthComponent::password($this->data['User']['identification']); return true; }
		}
	   
	}  */


}
?>