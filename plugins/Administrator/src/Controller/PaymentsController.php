<?php
namespace Administrator\Controller;

use Administrator\Controller\AppController;

use Cake\Core\Configure;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\ORM\TableRegistry;
use Cake\ORM\Table;

class PaymentsController extends AppController {

	public function beforeFilter(\Cake\Event\Event $event) {
    parent::beforeFilter($event);

    		// llamar a todos los post por type y por status.
        	$this->activos = $this->Payments->find('all', ['conditions' => ['status' => $this->active]])->count(); $this->set('activos', $this->activos); //conteo por usuarios y estado activo
			$this->inactivos = $this->Payments->find('all', ['conditions' => ['status' => $this->inactive]])->count(); $this->set('inactivos', $this->inactivos); //conteo por usuarios y estado inactivo
			$this->todos = $this->Payments->find('all')->count(); $this->set('todos', $this->todos); //conteo todos los usuarios


    }

	
	//listar las transacciones
	public function index() { 
		 
		
		$this->paginate = ['conditions' => ['Payments.status' => $this->active], 'contain'=>['Users' => ['fields' => ['company_name', 'name', 'company_email', 'company_tel', 'company_code_tel', 'company_area_tel', 'type'] ] ], 'order' => ['Payments.created DESC'],  ];
		$this->set('payments', $this->paginate());
/*
		  	if($this->request->is('post')) {
					
					if(isset($this->request->data['checkbox'])) {
					    
					    $a= 1; foreach($this->request->data['checkbox'] as $postID) {
					       if($postID!=1){
							   $data=['status' => $this->inactive];
			                   $dato = $pages->get($postID);
			                   $save = $pages->patchEntity($dato, $data,  ['validate' => false]);            
			                   $pages->save($save);
		                   	   
		                   	   if($a == 1)  { $this->Flash->exito(__('La página se ha desactivado con éxito.')); }

		                   }else{
		                   	    $this->Flash->alerts(__('Lo sentimos pero no se puede eliminar la categoria principal.'));
						 		$this->redirect(array('action' => 'index'));
		                   }

						$a++; }
						 
						$this->redirect(array('action' => 'index'));
					}
				}
										
   	      //$this->render('/Posts/index');
   	      */
		
	}
		  
	

   	
		
	
}
