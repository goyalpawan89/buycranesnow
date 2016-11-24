<?php
namespace Front\Controller;

use Front\Controller\AppController;
use Cake\ORM\TableRegistry;

class ApiController extends AppController { 
		


		public function initialize()
			{
			    parent::initialize();
        		$this->loadComponent('RequestHandler');
			}


        public function mensajes() {

        	$variable=['mensaje 1', 'mensaje 2', 'los mejores en gruas.'];

	        $this->set([
	            'Mensajes' => $variable,
	            '_serialize' => ['Mensajes']
	        ]);
			//$this->set('_serialize', true);
	        $this->viewBuilder()->theme('Front');
        	$this->viewBuilder()->layout('Front.api');
            $this->render('api'); 
 
	}
		
	
	

}
