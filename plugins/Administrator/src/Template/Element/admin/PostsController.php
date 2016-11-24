<?php
namespace Administrator\Controller;

use Administrator\Controller\AppController;

use Cake\Core\Configure;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\ORM\TableRegistry;
use Cake\I18n\I18n;

class PostsController extends AppController {

    var $postType = 'Post'; //variable global $this->categoryType (tipo de categoria)
	var $recursive = 2;
	var $sologruasId = 3;

	public function beforeFilter(\Cake\Event\Event $event) {
    parent::beforeFilter($event);

    $archives = TableRegistry::get('Administrator.Archives');
    $users = TableRegistry::get('Administrator.Users');

	        // llamar a todos los post por type y por status.

    		if($this->Auth->user('role_id') != 1) {
	      		
				$activeConditions = ['status' => $this->active, 'type' => $this->postType, 'Posts.user_id' => $this->Auth->user('id')];
				$inactiveConditions = ['status' => $this->inactive, 'type' => $this->postType, 'Posts.user_id' => $this->Auth->user('id')];
				$allConditions = ['type' => $this->postType, 'Posts.user_id' => $this->Auth->user('id')];

	      	} else {
		  		
		  		$activeConditions = ['status' => $this->active, 'type' => $this->postType];
				$inactiveConditions = ['status' => $this->inactive, 'type' => $this->postType];
				$allConditions = ['type' => $this->postType];

		  	}

		  	$this->activos = $this->Posts->find('all', ['conditions' => $activeConditions ])->count(); $this->set('activos', $this->activos); //conteo por usuarios y estado activo
			$this->inactivos = $this->Posts->find('all', ['conditions' => $inactiveConditions ])->count(); $this->set('inactivos', $this->inactivos); //conteo por usuarios y estado inactivo
			$this->todos = $this->Posts->find('all', ['conditions' => $allConditions ])->count(); $this->set('todos', $this->todos); //conteo todos los usuarios

        	

			//Variables
	        $tipo=$this->Posts->schema()->column('post_theme');
	        preg_match_all("/'(.*?)'/", $tipo['comment'], $enums1);
	        
	        $themeOptions=array_combine($enums1[1], $enums1[1]);
	        $this->set('themes', $themeOptions);

	       	
	       	$craneStatus = [0 => __($this->extras['avalible_crane']), 1 => __($this->extras['sold']), 2 => __($this->extras['rented']), 3 => __($this->extras['pending'])];
	        $this->set('craneStatus', $craneStatus);
	        //Variables

	        //tipo de Post
	        $this->set('type', $this->postType);

	        //datos del tipo de plantilla

	        $listUsers = $users->find('list', ['keyField' => 'id', 'valueField' => 'company_name', 'conditions' => ['Users.company_name !=' => '', 'Users.status' => $this->active, 'Users.role_id !=' => 3, 'Users.type !=' => 'Basic' ]]);
	        $this->set('listUsers', $listUsers);
	        

	        if($this->Auth->user('role_id') != 1) { 
					
					$datos = ['crane_status' => ['type' => 'select', 'options' => $craneStatus, 'label' => __($this->extras['crane_status'])] ];

	        } else {

	        		$datos = ['user_id' => ['type' => 'select', 'options' => $listUsers, 'label' => __($this->extras['author'])], 
	        				  'post_theme' => ['type' => 'select', 'options' => $themeOptions, 'label' => __($this->extras['theme'])], 'crane_status' => ['type' => 'select', 'options' => $craneStatus, 'label' => __($this->extras['crane_status'])] 
	        				 ];
	        }

	        $this->set('datos', $datos);


	        //todas las categorías
	        $this->set('categories', $this->Get->get_list_categories());


    }
		 
 
/****************************************
INDEX POSTS
****************************************/

	      public function index() { 


	      	if($this->Auth->user('role_id') != 1) {

	      		$all = $this->Posts->find('all', ['conditions' => ['Posts.status' => $this->active, 'Posts.type' => $this->postType, 'Posts.user_id' => $this->Auth->user('id')], 'contain'=>['Categories', 'Fields', 'Users'], 'order' => ['Posts.created DESC'],  ]);

	      	} else {

		  		$all = $this->Posts->find('all', ['conditions' => ['Posts.status' => $this->active, 'Posts.type' => $this->postType], 'contain'=>['Categories', 'Fields',  'Users'], 'order' => ['Posts.created DESC'],  ]);

		  	}

			    if($this->request->is('post')) {
					
					if(isset($this->request->data['checkbox'])) {
					    
					    foreach($this->request->data['checkbox'] as $catID) {
					        if($catID!=1){
							   $data=['status' => $this->inactive];
			                   $dato = $this->Posts->get($catID);
			                   $save = $this->Posts->patchEntity($dato, $data,  ['validate' => false]);            
			                   $this->Posts->save($save);
		                    } else {
		                   	    $this->Flash->alerts(__('Lo sentimos pero no se puede eliminar la categoria principal.'));
						 		$this->redirect(array('action' => 'index'));
		                    }

						 }
						
						$this->Flash->exito(__('Los cambios se han realizado correctamente'));
						$this->redirect(array('action' => 'index'));

					}

						//filtrar resultados por 
						if(isset($this->request->data['cat'])) {
		  					
		  					//funcion de filtro (buscar post por categoría)
							$all = $this->Posts->find('all', ['conditions' => ['Posts.status' => $this->active, 'Posts.type' => $this->postType], 'contain' => ['Users', 'Categories'] ]);
							$all->matching('Categories', function ($q) {
							    return $q->where(['Categories.id' => $this->request->data['cat']]);
							});


						}

				}
				
				//					
				$this->set('posts', $this->paginate($all));


		  }
		  
/****************************************
PAPELERA POSTS
****************************************/

 		    public function trash() {
		  
		  	$opciones=array('delete' => 'Eliminar', 'restart' => 'Restaurar'); //estados llamados dsede el enum DB
		  	$this->set(compact('opciones'));

		    $this->paginate = ['conditions' => ['Posts.status' => $this->inactive, 'Posts.type' => $this->postType], 'contain'=>['Categories', 'Users'], 'order' => ['Posts.created DESC'],  ];
			$this->set('posts', $this->paginate());


				if($this->inactivos == 0){

	            		$this->Flash->alerts(__('No hay publicaciones en la papelera.'));
	           		 	//$this->redirect(['action' => 'index']);

			    } else {

			            if($this->request->is('post')) {
				            if($this->request->data['checkbox']) {
				                 
				                foreach($this->request->data['checkbox'] as $postID) {
				                    //$this->Posts->id = $postID;
				                   $data=['status' => $this->active];
				                   $dato = $this->Posts->get($postID);
				                   $user = $this->Posts->patchEntity($dato, $data,  ['validate' => false]);            
				                   $this->Posts->save($user);
				                }
				                
				                $this->Flash->exito(__('Publicaciones restauradas'));
				                $this->redirect(['action' => 'trash']);
			                
			                }
			            }
			        
			      }  
		
		 $this->render('index');

	     }
		  

/****************************************
EDITAR POSTS
****************************************/

		  public function edit() {

 		  $users = TableRegistry::get('Administrator.Users');
 		  $archivesPosts = TableRegistry::get('Administrator.ArchivesPosts');

		  // $this->id variable de id llamado desde el appcontroller
		  $id=$this->id;
		  $this->set('id', $id);


		  //Se habilita el post en la parte inicial para evitar redireccionamiento de Idioma
					if(!$this->request->is('get')) {


								/***********autocompletar slug*******************/
								
								if(isset($this->request->data['name']) && !empty($this->request->data['name']) ) {

									// completar el slug
									$this->request->data['slug'] = $this->Url->urlSlug($this->request->data['name'], 'Posts');

								} else {

									//si el titulo esta vacio
									$this->request->data['slug'] = $this->Url->urlSlug($this->extras['without_title'], 'Posts');
									$this->request->data['name'] = $this->extras['without_title'];

								}
								
								/***********autocompletar slug*******************/

								//hay que hacer la llamada get sin los contain para que funcione correctamente (no importa que lo llame desde arriba hay q volver a llamar).
								$entity = $this->Posts->get($id);
								$save = $this->Posts->patchEntity($entity, $this->request->data(), ['associated' => ['Archives', 'Fields', 'Categories'] ]);
								$this->Posts->save($save);	
														  
								
								/************ duplicar entrada *************/

								$this->Flash->exito(__('Publicación actualizada'));



				    }

	      //Fin Post

		  
          //obtengo los datos para mostrar en la categpria
		  $post = $this->Posts->get($id,['contain'=>['Categories', 'Fields', 'Archives']]);
          $this->set('post', $post);

          if($id == 58) {
				
             	$post->fields[3]->_joinData->value = 'VENTA';
		  	 	$this->Posts->save($post, ['associated' => ['Fields']]);
		  }

          //echo pr($post->ArchivesPosts);

          //url de la imagen destacada
          $thumbnailId = $post->archive_id;
          $thumbUrl = $this->Get->get_thumbnail_url($thumbnailId, 'medium');

  		  // fecha de creación de la categoría
		  $creado = $post['created']; $this->set('creado', date_format($creado, 'Y-m-d'));

		  // fecha de creación de la categoría
		  $modificado = $post['modified']; $this->set('modificado', date_format($modificado, 'Y-m-d'));

		  
		    

	    $this->set('thumbnailId', $thumbnailId); // id de la imagen destacada
	    $this->set('thumbUrl', $thumbUrl); // url imagen destacada

	    $this->set('tipo', 'Posts');


  }


/****************************************
AGREGAR POSTS
****************************************/


		public function add() {
		
		  
		  $archives = TableRegistry::get('Administrator.Archives');
		  $field = TableRegistry::get('Administrator.Fields');

		  
		  $post = $this->Posts->newEntity();
          $this->set('post',$post);

          $this->set('id', NULL); // el id es nulo porque no se tiene un id, al momento de guardar se genera el id

		
		  $this->set('creado', date('Y-m-d'));
		  $this->set('modificado', date('Y-m-d'));

		  $this->set('thumbUrl', NULL); // url imagen destacada
 			  

	  		  	if($this->request->is('post')) {   
	  		  		//echo pr($this->request->data);	
			   		/***********Imagen Destacada*******************/
					if($this->request->data('Archive')[0]){
						$idImage= $this->Upload->uploadFields ($this->request->data('Archive')[0], ''); // funcion para subir y adjuntar las imagenes a la Publicación correspondiente. (mandar el archivo en array $upImage)
					}
					/***********Imagen Destacada*******************/
					
					if(!$this->request->data('categories')){
						$cat=[0=>['id'=>1]];
						}else{
						$cat=null;
					} 

						/***********autocompletar slug*******************/
								
						if(isset($this->request->data['name']) && !empty($this->request->data['name']) ) {

									// completar el slug
									$this->request->data['slug'] = $this->Url->urlSlug($this->request->data['name'], 'Posts');

						} else {

									//si el titulo esta vacio
									$this->request->data['slug'] = $this->Url->urlSlug($this->extras['without_title'], 'Posts');
									$this->request->data['name'] = $this->extras['without_title'];
									
						}
							
						/***********autocompletar slug*******************/


						// agregar usuario y tipo de publicacion por defecto se crea con Post.
    					$data=['user_id'=>$this->Auth->user('id')]; 
						$final=array_merge($data, $this->request->data);
			   			$createPost = $this->Posts->patchEntity($post, $final, ['associated' => ['Archives', 'Categories', 'Fields']]);
            			
            			if ($this->Posts->save($createPost)) {
            			
				       	   $id = $post->id; 

							$this->Flash->exito(__('Publicación generada'));
							$this->redirect(array('action' => 'edit',$id));
						}

			   }

			   //renderizar la vista edit de los posts			   
			   $this->render('edit');	

			    
			    //si el usuario es 2 solamente puede subir 1 grua (debe estar debajo del render)
				if($this->Auth->user('role_id') < $this->companyRoleId && $this->Auth->user('type') != 'Premium') {

					  			$postsUser = $this->Posts->find('list', ['conditions' => ['Posts.user_id' => $this->Auth->user('id')]])->count();

							  	if($postsUser >= 1) { 
							  		
									  		if($this->request->is('get')) {
									  				
									  				$this->Flash->alerts(__('No puedes publicar más grúas, cambiate a Premium para agregar más grúas'));
									  				$this->redirect(['controller' => 'Posts', 'action' => 'index']);
									  		}
							  	}
				}



	      } 


    //borarr publicaciones
	public function delete($id) {
		   
			if($this->request->is('get')) { 
			throw new MethodNotAllowedException();
			} else {
				
				$post = $this->Posts->get($id, ['associated' => ['Archives', 'Categories', 'Fields']]);
				$this->Posts->delete($post);
				$this->Flash->alerts(__('La publicación se ha eliminado por completo'));
				//$this->redirect(['action' => 'index']);	

			}

	}
	 

    //mandar usuarios a papelera individualmente
    public function clear($id) {
           
            if($this->request->is('get')) { 
            	throw new MethodNotAllowedException();
            } else {

                   $data=['status' => $this->inactive];
                   $dato = $this->Posts->get($id);
                   $post = $this->Posts->patchEntity($dato, $data,  ['validate' => false]);            
                   $this->Posts->save($post);
                   $this->Flash->alerts(__('La publicación se ha enviado a papelera'));
                   $this->redirect(['action' => 'index']);     
            }
    }
    

    //restaurar usuarios de papelera individualmente
    public function restore($id) {
           
            if($this->request->is('get')) { 
            	throw new MethodNotAllowedException();
            } else {

                   $data=['status' => $this->active];
                   $dato = $this->Posts->get($id);
                   $post = $this->Posts->patchEntity($dato, $data,  ['validate' => false]);            
                   $this->Posts->save($post);
                   $this->Flash->exito(__('Publicación actualizada'));
                   $this->redirect(['action' => 'index']);     
            }
    }


    //duplicar publicaciones
	public function duplicated() {
	
	$users = TableRegistry::get('Administrator.Users');
 	$archivesPosts = TableRegistry::get('Administrator.ArchivesPosts');
	
	$this->render('delete');

			if($this->request->is('get')) { 
			throw new MethodNotAllowedException();
			} else {
				
										$entity = $this->Posts->findById($this->request->data['duplicated'])->first();

										// actualizar entrada para saber que ya se ha duplicado
										$save = $this->Posts->patchEntity($entity, ['duplicated' => 1]);
										$this->Posts->save($save);	
										// actualizar entrada para saber que ya se ha duplicado


										$new = $this->Posts->newEntity();
										
										$data=['user_id'=> $this->sologruasId, 'slug' => $this->Url->urlSlug($this->request->data['name'], 'Posts'), 'duplicated' => 1, 'archive_id' => $entity->archive_id]; 
										$final=array_merge($this->request->data, $data);

										$duplicated = $this->Posts->patchEntity($new, $final, ['associated' => ['Archives', 'Categories', 'Fields']]);
										$this->Posts->save($duplicated);

										$id = $new->id;

										//crear la asociación a las nuevas imagenes
										$imgsPosts = $archivesPosts->find('all', ['conditions' => ['ArchivesPosts.post_id' => $id]])->toArray();
										foreach ($imgsPosts as $img) {

											$img = $archivesPosts->newEntity(['archive_id' => $img['archive_id'], 'post_id' => $id]);
											$archivesPosts->save($img);

										}

										$post = $this->Posts->get($id, ['contain'=>['Categories', 'Fields']]);

										// Update an existing association.
										$post->fields[3]->_joinData->value = 'VENTA';
										//$post->categories[3]->_joinData->category_id = 11;
										$this->Posts->save($post, ['associated' => ['Fields']]);


										$this->Flash->exito(__('Publicación generada para la venta a cargo de SOLOGRUAS.COM'));
										$this->redirect($this->referer());

								/*********** fin duplicar *****************/

			}


			

	}

	
		

}
