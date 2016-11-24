<?php

namespace Administrator\Controller;

use Administrator\Controller\AppController;

use Cake\Core\Configure;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\ORM\TableRegistry;




class CodesController extends AppController {

   function codigo($num){
			$codigo='';
			$characters = array("A","B","C","D","E","F","G","H","J","K","L","M",
						"N","P","Q","R","S","T","U","V","W","X","Y","Z",
						"1","2","3","4","5","6","7","8","9");
			$keys = array();
			while(count($keys) < $num) {
			$x = mt_rand(0, count($characters)-1);
				if(!in_array($x, $keys)) {
	   				$keys[] = $x;
				}
			}
			foreach($keys as $key){
		   		$codigo .= $characters[$key];
			}
		return $codigo;
	}


	/* devuelve la url corta */  
function get_bitly_short_url($url,$login,$appkey,$format='txt') {   
  $connectURL = 'http://api.bit.ly/v3/shorten?login='.$login.'&apiKey='.$appkey.'&longUrl='.urlencode($url).'&format='.$format;   
  return $this->curl_get_result($connectURL);  
}    
/* devuelve la url expandida */  
function get_bitly_long_url($url,$login,$appkey,$format='txt') {    
  $connectURL = 'http://api.bit.ly/v3/expand?login='.$login.'&apiKey='.$appkey.'&shortUrl='.urlencode($url).'&format='.$format;   
  return $this->curl_get_result($connectURL);  
}    
/* devuelve la URL con varios datos */  
function curl_get_result($url) {    
  $ch = curl_init();    
  $timeout = 5;   
  curl_setopt($ch,CURLOPT_URL,$url);    
  curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);    
  curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);   
  $data = curl_exec($ch);   
  curl_close($ch);    
  return $data;  
}




	
	public function beforeFilter(\Cake\Event\Event $event)
    {
        parent::beforeFilter($event);

        	$conteo = $this->Codes->find('all', array('conditions' => array('Codes.status = ' => 'active')))->count(); $this->set('conteo', $conteo); //conteo por usuarios y estado activo
		    $inactivos = $this->Codes->find('all', array('conditions' => array('Codes.status = ' => 'inactive')))->count(); $this->set('inactivos', $inactivos); //conteo por usuarios y estado inactivo
		    $todos = $this->Codes->find('all')->count(); $this->set('todos', $todos); //conteo todos los usuarios
    }


  
	       //listar Categorias
	      public function index() { 
				
				$this->paginate = [
			        'conditions' => ['Codes.status = ' => 'active'],
			        'contain'=>['Posts'],
			        'limit'=>300,
				];

      			$this->set('categorias', $this->paginate());
				  		 
				//$treelist = $this->Codes->generateTreeList(null, null, null, '— ');
				$treelist =$this->Codes->find('all', ['contain'=>['Posts']])->toArray();
				$this->set('arbol', $treelist);				  			  
							  
				if($this->request->is('post')) {
					
					if(isset($this->request->data['checkbox'])) {
					    
					    foreach($this->request->data['checkbox'] as $catID) {
					       
							   $data=['status' => 'inactive'];
			                   $dato = $this->Codes->get($catID);
			                   $user = $this->Codes->patchEntity($dato, $data,  ['validate' => false]);            
			                   $this->Codes->save($user);
		                   	   $this->Flash->exito(__('Los códigos se han desactivado.'));

						 }
						 
						 
						 $this->redirect(array('action' => 'index'));
					}
				}
								
		  }
		  
		  public function trash() {
	      
				 $this->paginate = [
			        'conditions' => ['Codes.status = ' => 'inactive'],
			        'contain'=>['Posts'],
			        'limit'=>300,
				];

      			$this->set('categorias', $this->paginate());
				  		 
				$treelist =$this->Codes->find('all', ['contain'=>['Posts']])->toArray();
				$this->set('arbol', $treelist);	

				        if($this->request->is('post')) {

								if(isset($this->request->data['checkbox'])) {
							         foreach($this->request->data['checkbox'] as $catID) {

									   $data=['status' => 'active'];
					                   $dato = $this->Codes->get($catID);
					                   $user = $this->Codes->patchEntity($dato, $data,  ['validate' => false]);            
					                   $this->Codes->save($user);
									 }
									 
									 echo $this->Flash->exito(__($this->actualizado));
									 $this->redirect(array('action' => 'index'));
								}
					    }
	  
	     	$this->render('index');
		
	     }
		  
		  
	       
		   public function add() {
			
			/*$categories = TableRegistry::get('Administrator.Categories');
		    $post = $categories->find('all', ['conditions' => ['Categories.id' => 2], 'contain'=>['Posts']])->first()->ToArray(); 
			echo pr($post);*/

		  	$category = $this->Codes->newEntity();
        	$this->set('form',$category);

		   	//Variables
            $tipo=$this->Codes->schema()->column('type');
            $tipo=$tipo['comment'];
            preg_match_all("/'(.*?)'/", $tipo, $enums1);
            $status = $enums1[1];
            $actual=array_combine($status, $status);
            $this->set('tipo', $actual);


            $tipo=$this->Codes->schema()->column('status');
            $tipo=$tipo['comment'];
            preg_match_all("/'(.*?)'/", $tipo, $enums1);
            $status = $enums1[1];
            $actual=array_combine($status, $status);
            $this->set('estado', $actual);



            $tipo=$this->Codes->schema()->column('metodo');
            $tipo=$tipo['comment'];
            preg_match_all("/'(.*?)'/", $tipo, $enums1);
            $status = $enums1[1];
            $actual=array_combine($status, $status);
            $this->set('metodo', $actual);
            //Variables

             $this->set('template', Configure::read('Template_Form.pass'));


			   if($this->request->is('post')) {
			   	
			   	//echo pr($this->request->data);

			   	
				$codes=[];
				$urls=[];
				for($a=1;$a<=$this->request->data['cantidad'];$a++){
					
					if($this->request->data['metodo']=='codigo'){
						$codigo=$this->codigo(10);
						$url=null;
					}else{
						$codigo=$this->codigo(20);

						
						if(!empty($this->request->data['cc'])){
							$dd=strtoupper($this->request->data['cc']);
							$ccc=$dd.'-'.$codigo;
						}else{
							$ccc=$codigo;
						}


						$url = $this->get_bitly_short_url('https://vuelateclaromusica.com/codes/'.$ccc.'','o_6iht69ca5d','R_c7179645777f48cb8ae38a8ddba227d5');    
						array_push($urls, $url);	
					}
					


					if(!empty($this->request->data['cc'])){
						$dd=strtoupper($this->request->data['cc']);
						$codigo=$dd.'-'.$codigo;
					}
					array_push($codes, $codigo);


						$data=['value'=>$codigo, 'user_id'=>$this->Auth->user('id'), 'url'=>$url];
						$final=array_merge($this->request->data, $data);
						
						$save = $this->Codes->patchEntity($this->Codes->newEntity(), $final, ['associated' => ['Posts']]);  

            			if ($this->Codes->save($save)) {
            				$this->Flash->exito(__('Códigos generados con éxito'));
            			}


				}
				if($this->request->data['metodo']=='codigo'){
					$this->set('codigos',$codes);
				}else{
					$this->set('codigos',$urls);
				}

			   }
			   
			   $this->render('edit');		
	      } 

	//mandar categorias a papelera individualmente
	public function clear($id) {
		   
			if($this->request->is('post')) { 
				//Evitamos eliminar la categoria principal.
			
				$Codes = $this->Codes->get($id);
				$data=['status' => 'inactive', 'user_id'=>$this->Auth->user('id')];
				$categoria = $this->Codes->patchEntity($Codes, $data);     	
	   			
					if ($this->Codes->save($categoria) ){
						$this->Flash->exito(__('El código se ha desactivado.'));
						$this->redirect(array('action' => 'index'));	 	
					}
					
				
			}else{
				$this->Flash->alerts(__('Area de acceso restringida.'));
				$this->redirect(array('action' => 'index'));	 	
			}
	}
	
	//restaurar categorias a papelera individualmente
	public function restore($id) {
	   
			if($this->request->is('post')) { 
				//Evitamos eliminar la categoria principal.
				
				$Codes = $this->Codes->get($id);
				$data=['status' => 'active', 'user_id'=>$this->Auth->user('id')];
				$categoria = $this->Codes->patchEntity($Codes, $data);     	
	   			
				if ($this->Codes->save($categoria) ){
					$this->Flash->exito(__('Código restaurado con éxito.'));
					$this->redirect(array('action' => 'index'));	 	
				}
					
			}else{
				$this->Flash->alerts(__('Area de acceso restringida.'));
				$this->redirect(array('action' => 'index'));	 	
			}
	}

	public function search() {
	   
		if($this->request->is('post')) { 
			

			$this->paginate = [
			        'conditions' => ['Codes.value LIKE ' => '%'.$this->request->data['search'].'%'],
			        'contain'=>['Posts'],
			        'limit'=>300,
				];

      			$this->set('categorias', $this->paginate());
				
		}

	}
	
		
	
}
