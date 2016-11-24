<?php

namespace Administrator\Controller;

use Administrator\Controller\AppController;

use Cake\Core\Configure;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\ORM\TableRegistry;




class CategoriesController extends AppController {

	var $categoryType = 'Category'; //variable global $this->categoryType (tipo de categoria)
	
	public function beforeFilter(\Cake\Event\Event $event) {
        parent::beforeFilter($event);

        // llamar a tdas las categorias por type y por status.
        $this->activos = $this->Categories->find('all', ['conditions' => ['status = ' => $this->active, 'type' => $this->categoryType]])->count(); $this->set('activos', $this->activos); //conteo por usuarios y estado activo
		$this->inactivos = $this->Categories->find('all', ['conditions' => ['status = ' => $this->inactive, 'type' => $this->categoryType]])->count(); $this->set('inactivos', $this->inactivos); //conteo por usuarios y estado inactivo
		$this->todos = $this->Categories->find('all', ['conditions' => ['type' => $this->categoryType]])->count(); $this->set('todos', $this->todos); //conteo todos los usuarios

		//Variables
	    $tipo=$this->Categories->schema()->column('category_theme');
	    preg_match_all("/'(.*?)'/", $tipo['comment'], $enums1);
	        
	    $actual=array_combine($enums1[1], $enums1[1]);
	    $this->set('themes', $actual);
	    //Variables

	    //tipo de categoria
	    $this->set('type', $this->categoryType);

    }

  
/****************************************
INDEX CATEGORIAS
****************************************/

	       //listar Categorias
	      public function index() { 
					
				$this->paginate = ['conditions' => ['Categories.status = ' => $this->active, 'Categories.type' => $this->categoryType], 'order' => ['Categories.lft ASC'],];

      			$this->set('categorias', $this->paginate());
				  		 
				//$treelist = $this->Categories->generateTreeList(null, null, null, '— ');
				$treelist =$this->Categories->find('treeList', ['spacer' => '— '])->toArray();
				$this->set('arbol', $treelist);	

				//boton de restaurar
				$this->set('editRestore', 'edit');

				//boton de restaurar
				$this->set('trashDelete', 'trash');	

							  
				if($this->request->is('post')) {
					
					if(isset($this->request->data['checkbox'])) {
					    
					    foreach($this->request->data['checkbox'] as $catID) {

					       //categorias que no se pueden elimiar (categoria principal y las catgorias de disponiblidad)
					       if($catID!=1 && $catID != 10 && $catID != 11 && $catID != 12){
							   $data=['status' => $this->inactive];
			                   $dato = $this->Categories->get($catID);
			                   $user = $this->Categories->patchEntity($dato, $data,  ['validate' => false]);            
			                   $this->Categories->save($user);
		                   	   
			                   //categorias eliminadas correctamente
		                   	   $this->Flash->exito($this->extras['category_papercut']);

		                   }else{

		                   		//categorias que no se pueden eliminar
		                   	    $this->Flash->alerts($this->extras['category_dont_remove']);
						 		$this->redirect(['action' => 'index']);
		                   }

						 }
						 
						 
						 $this->redirect(['action' => 'index']);
					}
				}
								
		  }

/****************************************
PAPELERA CATEGORIAS
****************************************/

		  public function trash() {
	      
				  $this->Categories->recursive = 12; 
				  
				  $this->paginate = ['conditions' => ['Categories.status = ' => $this->inactive, 'Categories.type' => $this->categoryType], 'order' => ['Categories.lft ASC']];

        		  $this->set('categorias', $this->paginate());
				  		 
				  $treelist =$this->Categories->find('treeList', ['spacer' => '— '])->toArray();
				  $this->set('arbol', $treelist);

				  //boton de restaurar
				$this->set('editRestore', 'restore');

				//boton de restaurar
				$this->set('trashDelete', 'delete');

				  
				        if($this->request->is('post')) {

								if(isset($this->request->data['checkbox'])) {
							         foreach($this->request->data['checkbox'] as $catID) {

									   $data=['status' => $this->active];
					                   $dato = $this->Categories->get($catID);
					                   $user = $this->Categories->patchEntity($dato, $data,  ['validate' => false]);            
					                   $this->Categories->save($user);
									 }
									 
									 echo $this->Flash->exito($this->extras['category_updated']);
									 $this->redirect(['action' => 'index']);
								}
					    }
	  
	     	$this->render('index');
		
	     }


/****************************************
EDITAR CATEGORIAS
****************************************/

		  public function edit() {

		  // $this->id variable de id llamado desde el appcontroller
		  $id = $this->id;


		  // METODO GET
		  	if($this->request->is('get')) {
												  	
			} else { //peticion post guardar


						/***********autocompletar slug*******************/
								
						if(isset($this->request->data['name']) && !empty($this->request->data['name']) ) {

									// completar el slug
									$this->request->data['slug'] = $this->Url->urlSlug($this->request->data['name'], 'Categories');

						} else {

									//si el titulo esta vacio
									$this->request->data['slug'] = $this->Url->urlSlug($this->extras['without_title'], 'Categories');
									$this->request->data['name'] = $this->extras['without_title'];
									
						}
								
						/***********autocompletar slug*******************/


						$final=array_merge($this->request->data, ['user_id' => $this->Auth->user('id')]);
						$entity = $this->Categories->get($id);
						$save = $this->Categories->patchEntity($entity, $final, ['associated' => ['Fields']]);
   						$this->Categories->save($save);
							
						$this->Flash->exito($this->extras['category_updated']);
						//$this->redirect(array('action' => 'edit', $id));								
            }

			// FIN METODO GET

		  //obtengo los datos para mostrar en la categpria
		  $category = $this->Categories->get($id, ['contain' => ['Archives', 'Fields'] ]);
          $this->set('category', $category);

          $thumbUrl = $this->Get->get_thumbnail_url($category->archive_id, 'medium');
          $thumbnailId = $category->archive_id;

          //categorias superuiores diferentes al $id
		 // $superiores =$this->Categories->find('treeList', ['conditions' => ['status' => 'active', 'id != ' => $id], 'spacer' => '— '])->toArray();
           $superiores =$this->Categories->find('treeList', ['conditions' => ['status' => 'active'], 'spacer' => '— '])->toArray();
		  $this->set('superiores', $superiores);


		  $cat=$this->Categories->find('all', ['conditions'=>['id'=>$id]]);

		  if($cat){
		  	$cat = $this->Categories->get($id); 
		  }else{
		  	$this->Flash->error(__('No has datos'));
			$this->redirect(['action' => 'index']);
		  }

		  // fecha de creación de la categoría
		  $creado = $cat['created']; $this->set('creado', date_format($creado, 'Y-m-d H:i'));

		  // fecha de creación de la categoría
		  $modificado = $cat['modified']; $this->set('modificado', date_format($modificado, 'Y-m-d H:i'));
			

            $this->set('thumbnailId', $thumbnailId); // id de la imagen destacada
	    	$this->set('thumbUrl', $thumbUrl); // url imagen destacada

	    	$this->set('tipo', 'Categories');


		  }


		  
		  
	       
		   public function add() {

		  $category = $this->Categories->newEntity();

          $this->set('category',$category);

          $this->set('creado', date('Y-m-d'));
		  $this->set('modificado', date('Y-m-d'));

		  /*************** obtener todas los campos personalizados ****************/

		  $customFields = new FieldsController();
		  $customFields = $customFields->getAllCustomFieldsByCategories(NULL, 'term'); //obetener todos los campos con tipo "term"
		  $this->set('customFields', $customFields);

		  /*************** obtener todas los campos personalizados ****************/

				//$superiores = $this->Categories->generateTreeList(null, null, null, ' — ');
		  		$superiores =$this->Categories->find('treeList', ['conditions' => ['status' => 'active'], 'spacer' => '— '])->toArray();
				$this->set('superiores', $superiores);


			   if($this->request->is('post')) {

						/***********autocompletar slug*******************/
								
						if(isset($this->request->data['name']) && !empty($this->request->data['name']) ) {

									// completar el slug
									$this->request->data['slug'] = $this->Url->urlSlug($this->request->data['name'], 'Categories');

						} else {

									//si el titulo esta vacio
									$this->request->data['slug'] = $this->Url->urlSlug($this->extras['without_title'], 'Categories');
									$this->request->data['name'] = $this->extras['without_title'];
									
						}

						/***********autocompletar slug*******************/


						$data=['user_id'=>$this->Auth->user('id')];
						$final=array_merge($data, $this->request->data);
			   			$categoria = $this->Categories->patchEntity($category, $final, ['associated' => ['Fields']]);
            			if ($this->Categories->save($categoria)) {
            			
				       	   $id = $categoria->id; 

							$this->Flash->exito($this->extras['category_created']);
							$this->redirect(['action' => 'edit', $id]);
							
						} 
			   }

			   $this->render('edit');		
	
	} 

         
    //borarr Categorias
	public function delete($id) {
		  
			if($this->request->is('get')) { 
			throw new MethodNotAllowedException();
			} else {
			if($this->Categories->delete($id))
				$this->Flash->alerts($this->extras['category_deleted']);
				$this->redirect(['action' => 'index']);	 
			}
	}
	

	//mandar categorias a papelera individualmente
	public function clear($id) {
		   
			if($this->request->is('post')) { 
				//Evitamos eliminar la categoria principal.
				if($catID!=1 && $catID != 10 && $catID != 11 && $catID != 12){
						
						$cat = $this->Categories->get($id);
						$data=['status' => $this->inactive, 'user_id'=>$this->Auth->user('id')];
						$categoria = $this->Categories->patchEntity($cat, $data);     	
			   			
            				if ($this->Categories->save($categoria) ){
            					$this->Flash->alerts($this->extras['category_deleted']);
								$this->redirect(['action' => 'index']);	 	
            				}
					
				}else{

					$this->Flash->alerts($this->extras['this_category_dont_remove']);
					$this->redirect(['action' => 'index']);	 	

				}
				
			}else{
				$this->Flash->alerts($this->extras['restricted_area']);
				$this->redirect(['action' => 'index']);	 	
			}
	}
	
	//restaurar categorias a papelera individualmente
	public function restore($id) {
		 
		   
			if($this->request->is('post')) { 
				//Evitamos eliminar la categoria principal.
				
				$cat = $this->Categories->get($id);
				$data=['status' => $this->active, 'user_id'=>$this->Auth->user('id')];
				$categoria = $this->Categories->patchEntity($cat, $data);     	
	   			
				if ($this->Categories->save($categoria) ){
					$this->Flash->exito($this->extras['category_restored']);
					$this->redirect(['action' => 'index']);	 	
				}
					
			}else{

				$this->Flash->alerts($this->extras['restricted_area']);
				$this->redirect(['action' => 'index']);	 	

			}
	}
	
		
	
}
