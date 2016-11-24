<?php 

namespace Administrator\Controller\Component;

use Cake\Controller\Component;
use Cake\ORM\TableRegistry;

class RolComponent extends Component {
    
    public $components = array('Session',  'RequestHandler', 'Auth');
	public $helpers = array('Session');

		// permisos para usuario como administrador
        public function admin() { 
        	//echo $this->Auth->user('role_id');
        	if($this->Auth->user('role_id')>= 2) { 
        		$this->redirect(array('controller' => 'users', 'action' => 'profile')); 
        	} 
        }



}