<?php

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\ORM\TableRegistry;


class HomepagesController extends AppController {

	
	// comienza el before render
	/*public function beforeRender() { 
	parent::beforeRender(); 

			$this->theme  = 'Frontpage';  
			if($this->view == 'categoryJson' || $this->view == 'postJson' || $this->view == 'pageJson') { $this->layout = 'default'; } else { $this->layout = 'home'; } // DEFINIMOS LOS ESTILOS Y LAYOUTS DESDE AQUÍ

	   	    //colores administrables.
	       	$colores = $this->General->getObjectFunction('Colores', 'Web');
		    $this->set('colores', $colores);
			
			// arreglo para las redes sociales con el modelo General
 		    $social = $this->General->getObjectFunction('Social', 'Web');
			$this->set('social', $social); // terminamos con la variable social para arrojar las variables de las redes sociales en array.
				
			// menu administrable
		    $main = $this->General->find('first', array('conditions' => array('General.option_key' => 'Menu', 'General.type' => 'Web')));

				if(isset($main) && !empty($main['General']['option_value'])) {  // validar si el campo colores existe o no para mostrar o no las variables y no generar errores (también validado en la vista)
					    $mainInicio = $this->General->find('first', array('conditions' => array('General.option_key' => 'Menu Inicio', 'General.type' => 'Web'))); //texto menu inicio, en la vista llama el link del home.
						if(!empty($mainInicio)) { $this->set('mainInicio', $mainInicio['General']['option_value']); }
						$menu = json_decode($main['General']['option_value'], true); //terminamos de crear el menu llamandolo desde la DB campo menu (tabla General).

							// insertar el id del link que se busca y determinar si esta activo o no el link del menu.
							foreach($menu as $key => $elmenu) {
								if(isset($this->request->params['pass'][0]) && $this->request->params['pass'][0] == $elmenu['id']) {
									array_push($menu[$key], 'active');
								} else {
									array_push($menu[$key], false);
								}
							}

						$this->set('menu', $menu); // se manda el menu como variable.
				}

		/************* variables principales del sitio ********************/	
/*
		$fondo = $this->General->getOptionValue('Fondo');

		if(is_numeric($fondo)) { 
			$files = new FilesController();
			$bg = $files->getImageById($fondo);
			$background = "url(".$this->webroot.$bg['folder'].$bg['filename'].")";

		} else { 

		   $background = $fondo;
		}

		$this->set('fondo', $background);

					    
	} // fin before render
	*/
	
	/*************variables generales **************************/

	 	// funcion para obtener los datos de un post
		public function postInfo($id) {
		$this->loadModel('Post'); 

		$postData = $this->Post->getPostById($id); 
						if(!empty($postData)) { // validar si existe el id para evitar errores
						    return $postData;
						} else {
							return false;
						}
		}
		
		// url de las páginas post o categorias
		public function getUrl() {
			$this->loadModel('Category');
			$this->loadModel('Post');
			$this->loadModel('File');
						
						if(isset($this->params['named']['id']) && isset($this->params['named']['model'])) { // validar si existe el id para evitar errores
						    
						    $model = $this->params['named']['model'];
						    $id = $this->params['named']['id'];

						    $data = $this->$model->findById($id);
						    return Router::url('/', true).$model."/".$data[$model]['slug'];

						} else {
							return Router::url('/', true).$this->name."/error";
						}
		}

		// obtener url de una imagen por id con o sin tamaño
		public function getImageUrl() {
 	    $this->loadModel('File');

 	    	if (isset($this->params['named']['id'])){
 	    		$dataImage = $this->File->findById($this->params['named']['id']);
 	    		if(!empty($dataImage)) {
 	    			if(isset($this->params['named']['size']) && $this->params['named']['size'] == 'thumbnail') {
 	    				$getImageUrl = $this->webroot.$dataImage['File']['folder'].$dataImage['File']['thumbnail']."-".$dataImage['File']['filename'];
 	    			} else {
 	    				$getImageUrl = $this->webroot.$dataImage['File']['folder'].$dataImage['File']['filename'];
 	    			}

 	    			return $getImageUrl;
 	    		}
 	    	}
						
		}

		// funcion para obtener el titulo de un objeto (post, page, cateogry or gadget)
		public function ObjectTitle() {
			   $this->loadModel('Post');
			   $this->loadModel('Category');
			    					
	   		    if (isset($this->params['named']['id'])){
					  if (isset($this->params['named']['model'])){
						  // si existe el parametro modelo en el requestAction busca el modelo del array.
						  $elmodelo = $this->params['named']['model'];
					      $postData = $this->$elmodelo->findById($this->params['named']['id']);
						  return $postData[$elmodelo]['name']; // devuelve el titulo con el modelo dado
					  } else {
					     // si NO existe el parametro modelo en el requestAction busca en la tabla post.
					      $postData = $this->Post->findById($this->params['named']['id']);
						  return $postData['Post']['name']; // devuelve el titulo desde modelo Post.
					  }
			    } else { 
						  return false;  // si el id no existe
				}
	
		}

		// trabajando en esto
		public function ObjectData() {
			   $this->loadModel('Post');
			   $this->loadModel('Category');
			    					
			   		    if (isset($this->params['named']['id'])){
							  if (isset($this->params['named']['model'])){
								  // si existe el parametro modelo en el requestAction busca el modelo del array.
								  $elmodelo = $this->params['named']['model'];
							      $postData = $this->$elmodelo->findById($this->params['named']['id']);
								  return $postData[$elmodelo]; // devuelve el titulo con el modelo dado
							  } else {
							     // si NO existe el parametro modelo en el requestAction busca en la tabla post.
							      $postData = $this->Post->findById($this->params['named']['id']);
								  return $postData['Post']; // devuelve el titulo desde modelo Post.
							  }
					    } else { 
								  return false;  // si el id no existe
						}
			
		}




	/*************variables generales **************************/


	public function index() { 
	}
			
	//funcion index
	public function display() { 


	} //fin funcion index


	public function category($slug) {

	$this->loadModel('Category');

	$category = $this->Category->findBySlug($slug);
	$var = $category['Category']['id']; 

			if(!isset($var)) { // si no existe la variable del id del post
					$this->redirect(array('action' => 'error'));
			} 


					$cat = $this->Category->findById($var); 
					if(empty($cat)) {
						$this->redirect(array('action' => 'error'));
					}

					$this->set('cat', $cat);

					$allChildren = $this->Category->children($var);
					$this->set('childrens', $allChildren);

					//manda la publicacion a la vista con el mismo tipo post/Post.ctp, page/Page.ctp etc.
					if(empty($allChildren)) {
						$this->render('subcategories');	
					}

	}

	public function post($slug) {
	$this->loadModel('Post');
	
	$post = $this->Post->findBySlug($slug);
	$var = $post['Post']['id']; 
	$this->set('post', $post);

			if(!isset($var)) { // si no existe la variable del id del post
					$this->redirect(array('action' => 'error'));
			} 

						

					if(empty($post)) { // si no existe la variable en la DB
						$this->redirect(array('action' => 'error'));
					}

						$cusFields = new FieldsController();
						$campos = $cusFields->getAllCustomFieldsByPostId($var);
						foreach($campos as $campo) {
							$this->set($campo['Field']['field_key'], $campo['Field']['field_value']);
						}


						//echo pr($post['Gadget']);
						if(isset($post['Gadget']['gadget_value']) && !empty($post['Gadget']['gadget_value'])) {
							$gadgetObject = json_decode($post['Gadget']['gadget_value'], true);
							$this->set('gadgetObject', $gadgetObject);
						} else {
							$this->set('gadgetObject', NULL);
						}


						//manda la publicacion a la vista con el mismo tipo post/Post.ctp, page/Page.ctp etc.
						if(!empty($post['Post']['page_type']) && isset($post['Post']['page_type'])) {
							$this->render('post'.$post['Post']['page_type']); // genera o pide la vista como: post_example.ctp (agrega un guion bajo). 	
						
						} elseif(!empty($post['Post']['post_type']) && isset($post['Post']['post_type'])) {
							$this->render('post'.$post['Post']['page_type']); // genera o pide la vista como: post_example.ctp (agrega un guion bajo). 	
						
						} else {
							$this->render($post['Post']['type']);	// genera o pide la vista como el post_type = page entonces: page.ctp. 
						}
			
	}


	public function error() {

		$this->set('title_for_layout', 'Error 404');
		$this->set('Description', 'Lo sentimos, no hemos encontrado lo que buscas'); 

	}

  
	
}

