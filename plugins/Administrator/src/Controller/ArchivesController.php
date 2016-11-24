<?php
namespace Administrator\Controller;

use Administrator\Controller\AppController;

use Cake\Core\Configure;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\ORM\TableRegistry;


class ArchivesController extends AppController {
	
	var $categoryType = 'Gallery'; //variable global $this->categoryType (tipo de categoria)

	public function beforeFilter(\Cake\Event\Event $event) {
        parent::beforeFilter($event);

        // llamar a tdas las categorias por type y por status.
        $this->activos = $this->Archives->find('all', ['conditions' => ['filename != ' => '']] )->count(); $this->set('activos', $this->activos); //conteo por usuarios y estado activo
		$this->inactivos = $this->Archives->find('all', ['conditions' => ['filename' => '']])->count(); $this->set('inactivos', $this->inactivos); //conteo por usuarios y estado inactivo
		$this->todos = $this->Archives->find('all', ['conditions' => ['filename != ' => '']])->count(); $this->set('todos', $this->todos); //conteo todos los usuarios

    }


	//listar Publicaciones tipo post
	public function index() { 
	
		$archives = $this->Archives->find('all', ['contain' => ['Users'], 'order' => ['Archives.created' => 'DESC'] ]);
		$this->set('posts', $this->paginate($archives));

				if($this->request->is('post')) { 
						if($this->request->data['checkbox']) {
				                 
				                foreach($this->request->data['checkbox'] as $postID) {

									$file = $this->Archives->get($postID);
									$this->Archives->delete($file);
								}

								//texto de elementos eliminados
								$this->Flash->alerts($this->extras['flash_delete_archives']);


						$this->redirect(['action' => 'index']);	

						}

				}


	}

/****************************************
BORRAR ARCHIVOS
****************************************/

	//borarr imágenes de la galería
	public function delete($id) {

			if($this->request->is('get')) { 
			throw new MethodNotAllowedException();
			} else {
				
				$file = $this->Archives->get($id);
				$this->Archives->delete($file);

				//texto de elemento (UNO) eliminados
				$this->Flash->alerts($this->extras['flash_delete_archive']);
				$this->redirect(['action' => 'index']);	

			}

	}

/****************************************
EDITAR ARCHIVOS
****************************************/

	public function edit() {

	// $this->id variable de id llamado desde el appcontroller
	$id=$this->id;

	$post = $this->Archives->get($id, ['contain'=>['Users']]);
	$this->set('post', $post);

	// fecha de creación de la categoría
	$creado = $post['created']; $this->set('creado', date_format($creado, 'Y-m-d H:i'));

	// fecha de creación de la categoría
	$modificado = $post['modified']; $this->set('modificado', date_format($modificado, 'Y-m-d H:i'));

		if($this->request->is('get')) {

		} else {

				//$data=['user_id'=>$this->Auth->user('id'), 'categories'=>$cat];
				$final=array_merge(['user_id'=>$this->Auth->user('id')], $this->request->data());

				//hay que hacer la llamada get sin los contain para que funcione correctamente (no importa que lo llame desde arriba hay q volver a llamar).
				$entity = $this->Archives->get($id);
				$save = $this->Archives->patchEntity($entity, $final);
				$this->Archives->save($save);				
		
				//texto elementos actualziados
				$this->Flash->exito($this->extras['flash_update_archive']);
		
		}


	}


	public function add() { 
	
	}
	
}
