<?php
namespace App\Controller\Config;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\ORM\TableRegistry;
use Cake\Utility\Text;

class AcomodacionController extends AppController{
	
	 //pagina principal 
	public function index() {
	    

	    $acomodacion = TableRegistry::get('Acomodacion');
	    $this->paginate = [
        'conditions' => ['Acomodacion.status = ' => 'active'],
            'limit'=>10,
        ];

        
        $datos = $this->paginate($acomodacion); 

        $this->set('datos', $datos);


        $search = $acomodacion->find('all', ['conditions' => ['Acomodacion.status != ' => 'removed']]); 
        $activos = $acomodacion->find('all', ['conditions' => ['Acomodacion.status = ' => 'active']]); 
        $inactivos = $acomodacion->find('all', ['conditions' => ['Acomodacion.status = ' => 'inactive']]); 
        
        $activos = $activos->count();
        $todos = $search->count();
        $inactivos = $inactivos->count();
        
        $this->set(compact('activos', 'inactivos', 'todos')); 

        /*			 
		$this->Paginator->settings = array('conditions' => array('Acomodacion.status = ' => 'active'), 'limit' => 10);
		$losusuarios = $this->paginate(); 
		$this->set('datos', $losusuarios);
		
		$activos = $this->Acomodacion->find('count', array('conditions' => array('Acomodacion.status = ' => 'active'))); $this->set('conteo', $activos); //conteo por usuarios y estado activo
		$inactivos = $this->Acomodacion->find('count', array('conditions' => array('Acomodacion.status = ' => 'inactive'))); $this->set('inactivos', $inactivos); //conteo por usuarios y estado inactivo
		$todos = $this->Acomodacion->find('count'); $this->set('todos', $todos); //conteo todos los usuarios
		
		//Validacion de datos
		if($activos==0){
			$this->Session->setFlash(__('No hay datos que mostrar. Debes agregar una nueva Acomodación.'), 'infos');
			$this->redirect(array('action' => 'add'));
		}
		
		//Checkbox
		if($this->request->is('post')) {
			
			if(isset($this->request->data['Acomodacion']['checkbox'])) {
			     //echo pr($this->request->data['Acomodacion']['checkbox']);
				foreach($this->request->data['Acomodacion']['checkbox'] as $ID) {
					$this->Acomodacion->id = $ID;
					$data=array('status' => 'inactive');
					$this->Acomodacion->Save($data);
				}
				
				$this->Session->setFlash(__('Items desactivados con éxito.'), 'exito');
				$this->redirect(array('action' => 'index'));
				
			}
		}
		//Checkbox
		*/
		
		$this->render('view');
		
		 		
		
	}

	/* Acomodacion*/
	public function Config_add() {
		
		$datos=$this->Acomodacion->find('all');
		$this->set('datos', $datos);
		
		if($this->request->is('post')) {
			     
				 if ($this->Acomodacion->save($this->request->data)) {
					$this->Session->setFlash(__('Se ha agregado correctamente una nueva acomodación.'), 'exito');	
					 $this->redirect(array('action' => 'index'));
				 }else{
				 	$this->Session->setFlash(__('Ha ocurrido un error.'), 'alerts'); 
				 }
		} // Fin POST
		
		$this->render('edit');
	}
	
	
	public function Config_view() {
		
		$this->Paginator->settings = array('conditions' => array('Acomodacion.status = ' => 'active'), 'limit' => 10);
		$datos = $this->Paginator->paginate(); 
		$this->set('datos', $datos);
		
		$activos = $this->Acomodacion->find('count', array('conditions' => array('Acomodacion.status = ' => 'active'))); $this->set('conteo', $activos); //conteo por usuarios y estado activo
		$inactivos = $this->Acomodacion->find('count', array('conditions' => array('Acomodacion.status = ' => 'inactive'))); $this->set('inactivos', $inactivos); //conteo por usuarios y estado inactivo
		$todos = $this->Acomodacion->find('count'); $this->set('todos', $todos); //conteo todos los usuarios
		
		//Validacion de datos
		if($activos==0){
			$this->Session->setFlash(__('No hay datos que mostrar. Debes agregar una nueva Acomodación.'), 'infos');
			$this->redirect(array('action' => 'add'));
		}
		
		//Checkbox
		if($this->request->is('post')) {
			
			if(isset($this->request->data['Acomodacion']['checkbox'])) {
			     //echo pr($this->request->data['Acomodacion']['checkbox']);
				foreach($this->request->data['Acomodacion']['checkbox'] as $ID) {
					$this->Acomodacion->id = $ID;
					$data=array('status' => 'inactive');
					$this->Acomodacion->Save($data);
				}
				
				$this->Session->setFlash(__('Items desactivados con éxito.'), 'exito');
				$this->redirect(array('action' => 'index'));
				
			}
		}
		//Checkbox
		
		$this->render('view');
		
	}
	
	
	public function Config_edit($id = null) {
	parent::siExiste($id, 'index', null);
			
			$this->Acomodacion->id = $id;
							
		    parent::admin(); // ingreso valida usuario y administrador
			
			//Busqueda de datos por ID
			$datosAcomodacion = $this->Acomodacion->find('first', array('conditions' => array('Acomodacion.id' => $id))); 
			$this->set('datosAcomodacion', $datosAcomodacion);
			
			//Verificar el dato del ID
			if($datosAcomodacion['Acomodacion']['id']==$id) {
			
				$estados = $this->Acomodacion->getColumnType('status'); preg_match_all("/'(.*?)'/", $estados, $enums1); 
				$status=array_combine($enums1[1], $enums1[1]);
				//$status=array($status[0]=>$status[0],$status[1]=>$status[1]); //estados llamados dsede el enum DB
				$this->set(compact('status'));
							
				if($this->request->is('get')) {
				//si mandan los datos hay q llenar los datos			
				$this->request->data = $this->Acomodacion->read();
				
				} else { //peticion post guardar
				 
						if($this->Acomodacion->save($this->request->data)) {					   
					 		$this->Session->setFlash(__("Se han modificado los datos con éxito."), 'exito');
	  				        $this->redirect(array('action' => 'index'));	
					  	} else {
					  		 $this->Session->setFlash(__('Ha ocurrido un error.'), 'alerts'); }
				  		}
				
			} else {
				 $this->redirect(array('action' => 'index'));
			}
		
		$this->render('edit');
	}
	
	
	public function Config_clear($id) {
		  parent::admin();
		   
			if($this->request->is('get')) { 
			//throw new MethodNotAllowedException();
			$this->Session->setFlash(__('Area de acceso restringida.'), 'alerts');
			$this->redirect(array('action' => 'index'));
			} else {
			$this->Acomodacion->id = $id;
			$this->Acomodacion->save(array('status' => 'inactive'));
			$this->Session->setFlash(__('La acomodación se ha enviado a la papelera.'), 'alerts');
			$this->redirect(array('action' => 'index'));	 
			}
	}
	
	public function Config_active($id) {
		  parent::admin();
		   
			if($this->request->is('get')) { 
			//throw new MethodNotAllowedException();
			$this->Session->setFlash(__('Area de acceso restringida.'), 'alerts');
			$this->redirect(array('action' => 'index'));
			} else {
			$this->Acomodacion->id = $id;
			$this->Acomodacion->save(array('status' => 'active'));
			$this->Session->setFlash(__('La acomodación se ha activado con éxito.'), 'exito');
			$this->redirect(array('action' => 'index'));	 
			}
	}
	
	
	public function Config_trash() {
	parent::admin();

        $this->Paginator->settings = array('conditions' => array('Acomodacion.status = ' => 'inactive'), 'limit' => 10);
		$datos = $this->Paginator->paginate(); 
		$this->set('datos', $datos);
		
		$conteo = $this->Acomodacion->find('count', array('conditions' => array('Acomodacion.status = ' => 'active'))); $this->set('conteo', $conteo); //conteo por usuarios y estado activo
		$inactivos = $this->Acomodacion->find('count', array('conditions' => array('Acomodacion.status = ' => 'inactive'))); $this->set('inactivos', $inactivos); //conteo por usuarios y estado inactivo
		$todos = $this->Acomodacion->find('count'); $this->set('todos', $todos); //conteo todos los usuarios
		
		if($inactivos==0){
			$this->Session->setFlash(__('No hay items inactivos.'), 'alerts');
			$this->redirect(array('action' => 'index'));
		}
		
		//Checkbox
		if($this->request->is('post')) {
			
			if(isset($this->request->data['Acomodacion']['checkbox'])) {
			     //echo pr($this->request->data['Acomodacion']['checkbox']);
				foreach($this->request->data['Acomodacion']['checkbox'] as $ID) {
					$this->Acomodacion->id = $ID;
					$data=array('status' => 'active');
					$this->Acomodacion->Save($data);
				}
				
				$this->Session->setFlash(__('Items activados con éxito.'), 'exito');
				$this->redirect(array('action' => 'trash'));
				
			}
		}
		//Checkbox
	
	$this->render('view');
		
	}
	
	
	
}
