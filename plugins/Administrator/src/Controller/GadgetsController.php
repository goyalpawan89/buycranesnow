<?php
namespace Administrator\Controller;

use Administrator\Controller\AppController;

use Cake\Core\Configure;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\ORM\TableRegistry;



class GadgetsController extends AppController {

	public function beforeFilter(\Cake\Event\Event $event) {
    parent::beforeFilter($event);

        // llamar a tdas las categorias por type y por status.
        $this->activos = $this->Gadgets->find('all', ['conditions' => ['status = ' => $this->active]])->count(); $this->set('activos', $this->activos); //conteo por usuarios y estado activo
		$this->inactivos = $this->Gadgets->find('all', ['conditions' => ['status = ' => $this->inactive]])->count(); $this->set('inactivos', $this->inactivos); //conteo por usuarios y estado inactivo
		$this->todos = $this->Gadgets->find('all', ['conditions' => ['status != ' => 'deleted']])->count(); $this->set('todos', $this->todos); //conteo todos los usuarios

        //Variables
          $tipo = $this->Gadgets->schema()->column('type');
          preg_match_all("/'(.*?)'/", $tipo['comment'], $enums1);
          
          $actual = array_combine($enums1[1], $enums1[1]);
          $this->set('types', $actual);
        //Variables

    }
		 
 
/****************************************
INDEX GADGETS
****************************************/

	public function index() { 

	  	$all = $this->Gadgets->find('all', ['conditions' => ['Gadgets.status' => $this->active]]);
		$this->set('gadgets', $this->paginate($all));

	}
		  
/****************************************
PAPELERA GADGETS
****************************************/

	public function trash() {  

    $all = $this->Gadgets->find('all', ['conditions' => ['Gadgets.status' => $this->inactive]]);
		$this->set('gadgets', $this->paginate($all));

        if($this->request->is('post')) {

            foreach($this->request->data['checkbox'] as $gadgetID) {
                  
                  if($gadgetID != 2){
                          
                         $dato = $this->Gadgets->get($gadgetID);
                         $this->Gadgets->delete($dato);

                            $this->Flash->alerts(__d('administrator', 'Los gadgets se han eliminado correctamente.'));
                            $this->redirect(['action' => 'index']);

                  } 

             }



        }


    $this->render('index');



	}
		  

/****************************************
EDITAR GADGETS
****************************************/

    public function edit() {
    
    // $this->id variable de id llamado desde el appcontroller
	  $id=$this->id;

		if(!$this->request->is('get')) {
      
  			$entity = $this->Gadgets->get($id);
  			$save = $this->Gadgets->patchEntity($entity, $this->request->data, [ 'associated' => ['Archives'] ]);
  			$this->Gadgets->save($save);

  			$this->Flash->exito(__d('administrator', 'Gadget actualizado'));

		}

  	$gadget = $this->Gadgets->get($id, ['contain'=>['Archives']]);
  	$this->set('gadget', $gadget);

  	// fecha de creación de la categoría
  	$creado = $gadget['created']; $this->set('creado', date_format($creado, 'Y-m-d H:i'));
  	// fecha de creación de la categoría
  	$modificado = $gadget['modified']; $this->set('modificado', date_format($modificado, 'Y-m-d H:i'));

    $this->set('tipo', 'Gadgets');

		
  }


/****************************************
AGREGAR GADGETS
****************************************/

	public function add() {

	$gadget = $this->Gadgets->newEntity();
    $this->set('gadget',$gadget);

    $this->set('creado', date('Y-m-d'));
    $this->set('modificado', date('Y-m-d'));

    if($this->request->is('post')) {  

      $datos = array_merge(['user_id' => $this->Auth->user('id'), $this->request->data]);
    	$save = $this->Gadgets->patchEntity($gadget, $datos,  ['associated' => ['Archives']]);
    		
    		if ($this->Gadgets->save($save)) {    			
					$id = $save->id; 
					$this->Flash->exito(__d('administrator', 'Gadget generado'));
					$this->redirect(array('action' => 'edit',$id));
			}

    }

  $this->set('tipo', 'Gadgets');
	$this->render('edit');
		  
		  
	} 



    //mandar a gadgets eliminados
    public function delete($id) {
           
            if($this->request->is('get')) { 
            	throw new MethodNotAllowedException();
            } else {

                   $data=['status' => 'deleted'];
                   $dato = $this->Gadgets->get($id);
                   $post = $this->Gadgets->patchEntity($dato, $data,  ['validate' => false]);            
                   $this->Gadgets->save($post);
                   $this->Flash->alerts(__d('administrator', 'El gadget se ha eliminado correctamente'));
                   $this->redirect(['action' => 'index']);     
            }
    }
	 

    //mandar usuarios a papelera individualmente
    public function clear($id) {
           
            if($this->request->is('get')) { 
            	throw new MethodNotAllowedException();
            } else {

                   $data=['status' => $this->inactive];
                   $dato = $this->Gadgets->get($id);
                   $post = $this->Gadgets->patchEntity($dato, $data,  ['validate' => false]);            
                   $this->Gadgets->save($post);
                   $this->Flash->alerts(__d('administrator', 'El gadget se ha enviado a papelera'));
                   $this->redirect(['action' => 'index']);     
            }
    }
    

    //restaurar usuarios de papelera individualmente
    public function restore($id) {
           
            if($this->request->is('get')) { 
            	throw new MethodNotAllowedException();
            } else {

                   $data=['status' => $this->active];
                   $dato = $this->Gadgets->get($id);
                   $post = $this->Gadgets->patchEntity($dato, $data,  ['validate' => false]);            
                   $this->Gadgets->save($post);
                   $this->Flash->exito(__d('administrator', 'Gadget actualizado'));
                   $this->redirect(['action' => 'index']);     
            }
    }



    public function deleteArchive() {
    
        if($this->request->is('ajax')) { 
            
            $archive_id = $this->request->query['archive_id'];
            $id = $this->request->query['id'];

            $filtro = $this->Gadgets->GadgetsArchives->find('All', ['conditions'=>['gadget_id' => $id, 'archive_id' => $archive_id]])->first();

            $entity = $this->Gadgets->GadgetsArchives->get($filtro->id);

            //$entity = $this->Gadgets->gadgetsArchives->get(1038);
            $this->Gadgets->GadgetsArchives->delete($entity);

            die();

        }

    }

		

}
