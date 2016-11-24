<?php

namespace Administrator\Controller;

use Administrator\Controller\AppController;

use Cake\Core\Configure;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\ORM\TableRegistry;




class LogsController extends AppController {

   
	
	public function beforeFilter(\Cake\Event\Event $event)
    {
        parent::beforeFilter($event);
        	$user = TableRegistry::get('Administrator.Players');
		    


		    if($this->request->params['action']=='logs'){
		    	$todos = $this->Logs->find('all',['conditions'=>['player_id'=>$this->request->params['pass'][0]]])->count();
		    }else{
		    	 $todos = $user->find('all')->count(); 
		    }

		    $this->set('todos', $todos); //conteo todos los usuarios
    }


  
	       //listar Categorias
	      public function index() { 
				
				$user = TableRegistry::get('Administrator.Players');
				$usuario=$user->find('All',['contain'=>['Logs'], 'order'=>['rank'=>'DESC'], 'limit'=>300,]);
      			$this->set('categorias', $this->paginate($usuario));
				
		  }
		  
		 
		 public function logs() { 
			
	            $id=$this->request->params['pass'][0];

				$user = TableRegistry::get('Administrator.Players');
				 $this->paginate = [
					'conditions'=>['Player_id'=> $id],
					'contain'=>['Players'],
					'order'=>['created'=>'DESC'],
			        'limit'=>100,
				];

      			$this->set('categorias', $this->paginate());

      			
      			$perfil=$user->get($id);
      			$this->set('usuario', $perfil);

      			$this->render('index');
							
		  }


		  public function codes() { 
			
	            $id=$this->request->params['pass'][0];

				$user = TableRegistry::get('Administrator.Players');

				$this->Logs->Players->hasMany('Ranking');
				$usuario=$this->Logs->find('All', ['conditions'=>['Player_id'=> $id, 'action LIKE'=>'%digo%'],
					'contain'=>['Players'=>['Ranking']],
					//'order'=>['created'=>'DESC'],
			        'limit'=>100,]);

      			$this->set('categorias', $this->paginate($usuario));

      			$perfil=$user->get($id);
      			$this->set('usuario', $perfil);

      			
							
		  }


	
		
	
}
