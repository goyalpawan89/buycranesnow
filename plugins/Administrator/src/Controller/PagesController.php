<?php
namespace Administrator\Controller;

use Administrator\Controller\AppController;

use Cake\Core\Configure;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\ORM\TableRegistry;
use Cake\ORM\Table;
use Cake\I18n\I18n;
/*use Cake\Utility\Text;*/

class PagesController extends AppController {

    var $postType = 'Page'; //variable global $this->categoryType (tipo de categoria)

    public function beforeFilter(\Cake\Event\Event $event) {
    	parent::beforeFilter($event);

    	$archives = TableRegistry::get('Administrator.Archives');
    //cargando modelo Posts
    	$this->loadModel('Posts');

	        // llamar a todos los post por type y por status.
        	$this->activos = $this->Posts->find('all', ['conditions' => ['status' => $this->active, 'type' => $this->postType]])->count(); $this->set('activos', $this->activos); //conteo por usuarios y estado activo
			$this->inactivos = $this->Posts->find('all', ['conditions' => ['status' => $this->inactive, 'type' => $this->postType]])->count(); $this->set('inactivos', $this->inactivos); //conteo por usuarios y estado inactivo
			$this->todos = $this->Posts->find('all', ['conditions' => ['type' => $this->postType]])->count(); $this->set('todos', $this->todos); //conteo todos los usuarios

			//Variables
	        $tipo=$this->Posts->schema()->column('page_theme'); // themes para la página (plantillas)
	        preg_match_all("/'(.*?)'/", $tipo['comment'], $enums1);
	        $actual=array_combine($enums1[1], $enums1[1]);
	        $this->set('themes', $actual);

	        $locations = ['Homepage' => 'Homepage', 'Testimonials' => 'Testimonials', 'Planes' => 'Planes', 'Terms' => 'Terms'];
	        $this->set('locations', $locations);
	        //Variables

	        //tipo de Post
	        $this->set('type', $this->postType);

	        //datos del tipo de plantilla
	        $datos = ['page_theme' => ['type' => 'select', 'options' => $actual, 'label' => __($this->extras['theme']), ]];
	        $this->set('datos', $datos);

	    }


	//listar paginas tipo page
	    public function index() { 

	    	$pages = TableRegistry::get('Administrator.Posts');

	    	$this->paginate = ['conditions' => ['Posts.status' => $this->active, 'Posts.type' => $this->postType], 'contain'=>['Users'], 'order' => ['Posts.created DESC'],  ];
	    	$this->set('posts', $this->paginate($pages));

	    	if($this->request->is('post')) {

	    		if(isset($this->request->data['checkbox'])) {

	    			$a= 1; foreach($this->request->data['checkbox'] as $postID) {
	    				if($postID!=1){
	    					$data=['status' => $this->inactive];
	    					$dato = $pages->get($postID);
	    					$save = $pages->patchEntity($dato, $data,  ['validate' => false]);            
	    					$pages->save($save);

	    					if($a == 1)  { $this->Flash->exito(__d('administrator', 'La página se ha desactivado con éxito.')); }

	    				}else{
	    					$this->Flash->alerts(__d('administrator', 'Lo sentimos pero no se puede eliminar la categoria principal.'));
	    					$this->redirect(array('action' => 'index'));
	    				}

	    				$a++; }

	    				$this->redirect(array('action' => 'index'));
	    			}
	    		}

   	      //$this->render('/Posts/index');

	    	}

	//papelera de las Páginas
	    	public function trash() {
	    		$pages = TableRegistry::get('Administrator.Posts');


	    		$this->paginate = ['conditions' => ['Posts.status' => $this->inactive, 'Posts.type' => $this->postType], 'contain'=>['Users'], 'order' => ['Posts.created DESC'],  ];
	    		$this->set('posts', $this->paginate($pages));

	    		if(isset($this->request->data['Post']['checkbox'])) {
	    			foreach($this->request->data['Post']['checkbox'] as $postID) {
	    				$this->Post->id = $postID;
	    				if($this->request->data['Post']['opciones']== 'restart') { 
	    					$data=array('status' => $this->active);
	    					$this->Post->save($data);
	    				} else {
	    					$this->Post->delete($postID);
	    				}
	    			}

	    			$this->Session->setFlash(__d('administrator', 'Páginas actualizadas'), 'exito');
	    			$this->redirect(array('action' => 'index'));
	    		}

	    		$this->render('/Posts/index');

	    	}


	//añadir publicacion   
	    	public function add() {

	    		$archives = TableRegistry::get('Administrator.Archives');
	    		$posts = TableRegistry::get('Administrator.Posts');

	    		$post = $posts->newEntity();
	    		$this->set('post',$post);

          $this->set('id', NULL); // el id es nulo porque no se tiene un id, al momento de guardar se genera el id (GALERIA DE IMAGENES LLAMA LA VARIABLE ID)

          $this->set('creado', date('Y-m-d'));
          $this->set('modificado', date('Y-m-d'));


          if($this->request->is('post')) {   

	  		  		//slug automatico de la entrada
          	if($this->request->data('Archive')[0]){
						$idImage= $this->Upload->uploadFields ($this->request->data('Archive')[0], ''); // funcion para subir y adjuntar las imagenes a la Publicación correspondiente. (mandar el archivo en array $upImage)
					}
					
					/***********autocompletar slug*******************/

					if(isset($this->request->data['name']) && !empty($this->request->data['name']) ) {

									// completar el slug
						$this->request->data['slug'] = $this->Url->urlSlug($this->request->data['name'], 'Posts').'-'.$id;

					} else {

						//si el titulo esta vacio
						$this->request->data['slug'] = $this->Url->urlSlug($this->extras['without_title'], 'Posts').'-'.$id;
						$this->request->data['name'] = $this->extras['without_title'].'-'.$id;

					}

					/***********autocompletar slug*******************/

						// agregar usuario y tipo de publicacion (Page).
					$data=['user_id'=>$this->Auth->user('id'), 'type' => 'Page']; 
					$final=array_merge($data, $this->request->data);
					$createPost = $this->Posts->patchEntity($post, $final, ['associated' => ['Archives']]);

					if ($posts->save($createPost)) {

						$id = $post->id; 

				       	   // guardar imagenes de la galeria como relacion con HABTM y TableRegistry (GUARDAR RELACION EN CONTROLADOR DIFERENTE MODELO)
						$data = ['id' => $id, 'archives' => $this->request->data['archives']];
						$saveRelation = $posts->newEntity($data, ['associated' => ['Archives']]);
						$posts->save($saveRelation);

						$this->Flash->exito(__d('administrator', 'Página generada'));
						$this->redirect(['action' => 'edit',$id]);
					}

				}

				$this->render('Posts/edit');				


			} 

    //editar Entradas
			public function edit() {
				$posts = TableRegistry::get('Administrator.Posts');
		 //datos generales del sitio
				$general = TableRegistry::get('Administrator.Generals');
				$datos = $general->find('list',['keyField' => 'option_key', 'valueField' => 'option_value'])->toArray(); 

		// $this->id variable de id llamado desde el appcontroller
				$id=$this->id;


          //obtengo los datos para mostrar en la categpria
				$post = $posts->get($id, ['contain'=>['Archives', 'Fields']]);
				$this->set('post', $post);

          //url de la imagen destacada

				$thumbUrl = $this->Get->get_thumbnail_url($post->archive_id, 'medium');
				$thumbnailId = $post->archive_id;

      	  //$this->set('imagenesPost', $post->file); //imagenes relacionadas del post

  		  // fecha de creación de la categoría
				$creado = $post['created']; $this->set('creado', date_format($creado, 'Y-m-d H:i'));

		  // fecha de creación de la categoría
				$modificado = $post['modified']; $this->set('modificado', date_format($modificado, 'Y-m-d H:i'));


				if($this->request->is('get')) {

				}else{

					//actualizar imagen destacada
					$thumbUrl = $this->Get->get_thumbnail_url($this->request->data('archive_id'), 'medium');
					$thumbnailId = $this->request->data('archive_id');

					
					/***********autocompletar slug*******************/

					if(isset($this->request->data['name']) && !empty($this->request->data['name'])) {

									// completar el slug
						if($this->idioma == 'en') {

							$this->request->data['slug'] = $this->Url->urlSlug($this->request->data['name'], 'Posts')."-".$id;
							//$this->request->data['slug'] = Text::slug($this->request->data['name'], '-')."-".$id;

						}

					} else {

									//si el titulo esta vacio
						$this->request->data['slug'] = $this->Url->urlSlug($this->extras['without_title'], 'Posts')."-".$id;
						//$this->request->data['slug'] = Text::slug($this->extras['without_title'], '-')."-".$id;
						$this->request->data['name'] = $this->extras['without_title'];

					}

					/***********autocompletar slug*******************/


					//guardar los datos del fomulario
					$page = $posts->get($id);
					
					$final=array_merge(['user_id'=>$this->Auth->user('id')], $this->request->data);
					$save = $posts->patchEntity($page, $final);
					$posts->save($save);

					if(isset($this->request->data['archives']) && !empty($this->request->data['archives'])) {
						// guardar imagenes de la galeria como relacion con HABTM y TableRegistry (GUARDAR RELACION EN CONTROLADOR DIFERENTE MODELO)
						$data = ['id' => $id, 'archives' => $this->request->data['archives'], 'fields' => $this->request->data['fields']];
						$saveRelation = $posts->newEntity($data, ['associated' => ['Archives', 'Fields']]);
						$posts->save($saveRelation);
					}

					$this->Flash->exito(__d('administrator', 'Página actualizada'));


				}

	    $this->set('thumbnailId', $thumbnailId); // id de la imagen destacada
	    $this->set('thumbUrl', $thumbUrl); // url imagen destacada

	    $this->render('Posts/edit');


	}  



     //borarr publicaciones
	public function delete($id) {

		if($this->request->is('get')) { 
			throw new MethodNotAllowedException();
		} else {

			$dato = $this->Posts->get($id);

			if($dato->page_theme != 'contacto' || $dato->page_theme != 'sitemap' || !empty($dato->location) ) {

				//$this->Posts->delete($dato);
				
				$save = $this->Posts->patchEntity($dato, ['status' => 'deleted']);
				$this->Posts->save($save);

				$this->Flash->alerts(__d('administrator', 'La publicación se ha eliminado por completo'));
				$this->redirect(['action' => 'index']);	

			} else {

				$this->Flash->alerts(__d('administrator', 'La página con esta plantilla no se debe eliminar'));
				$this->redirect(['action' => 'index']); 
			}

		}
	}


     //mandar usuarios a papelera individualmente
	public function clear($id) {

		if($this->request->is('get')) { 
			throw new MethodNotAllowedException();
		} else {

			$data=['status' => $this->inactive];
			$dato = $this->Posts->get($id);

			if($dato->page_theme != 'contacto') {

				$post = $this->Posts->patchEntity($dato, $data,  ['validate' => false]);            
				$this->Posts->save($post);
				$this->Flash->alerts(__d('administrator', 'La publicación se ha enviado a papelera'));
				$this->redirect(['action' => 'index']);     

			} else {

				$this->Flash->alerts(__d('administrator', 'La página con esta plantilla no se debe eliminar'));
				$this->redirect(['action' => 'index']); 

			}
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
			$this->Flash->exito(__d('administrator', 'Publicación actualizada'));
			$this->redirect(['action' => 'index']);     
		}
	}




	
}
