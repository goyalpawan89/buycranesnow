<?php
namespace App\Controller;

use Cake\ORM\TableRegistry;
use Cake\Core\Configure;
/*use Cake\Core\Configure;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
*/


class ErrorsController extends AppController {

	
    public $uses = '';
	public $name = 'Errors';
	public $components = array('Function', 'Auth' );
	
	/**** Conexión JSON - Datos ****/
	public function jsonApi($cliente=null){
	
		$url='http://elymki.com/interactiva/Licenses/error.json';
		$json = file_get_contents($url);
		$json = json_decode(utf8_encode($json),true);
		
		$cliente='Interactiva';
		//echo pr($json);

		$titulo=$json['Elymki'][$this->request->session()->read('Auth.License.State')]['Titulo'];
		$tipo=$json['Elymki'][$this->request->session()->read('Auth.License.State')]['Tipo'];
		$msj=$json['Elymki']['Mensaje'];
		$item=$json['Elymki']['item'];
		$msj2=$json['Elymki']['Mensaje2'];
		$msj3=$json['Elymki']['Mensaje3'];

		if(array_key_exists($cliente,$json['Elymki']['Cliente'])){
		$contacto=$json['Elymki']['Cliente'][$cliente]['Contacto'];
		$logo=$json['Elymki']['Cliente'][$cliente]['Logo'];
		}else{
			$logo=$json['Elymki']['Cliente']['Interactiva']['Logo'];
			$contacto=$json['Elymki']['Cliente']['Interactiva']['Contacto'];
		}
		
		$data = array("titulo","tipo", "msj", "item", "msj2", "msj3", "contacto", "logo");
		$data = compact($data);
		
		return $data;
		
	}
	/**** Conexión JSON - Datos ****/
	
	
	
	    //pagina principal 
	public function suspendida() {
	   
		$data=$this->jsonApi();
		$this->set('informacion', $data);
		
	}
	
	
	public function license() {
	//parent::admin();
		//echo $this->Session->read('Auth.User.id');
	//$this->Function->onlyUser($this->request->session()->read('Auth.User.id'));
	$general = TableRegistry::get('Generals');
	$datoGeneral =$general->find('all', array('conditions' => array('option_key = ' => 'Licencia')))->first(); 
	$this->set('datoGeneral', $datoGeneral);
		
		$data=$this->jsonApi();
		$this->set('informacion', $data);
		
	
	if($this->request->is('post')) {
			if(isset($this->request->data['key'])) {
			     
				$this->loadModel('Generals');
				
					$licencia = $general->find('all', array('conditions' => array('option_key = ' => 'Licencia')))->first();
					
					$id = $general->get($licencia->id);
					$data=array('option_value' => $this->request->data['key']);
	                $save = $general->patchEntity($id, $data,  ['validate' => false]);            
	                $general->save($save);

				
				$this->Flash->exito(__('Licencia Modificada'));
				$this->redirect(array('controller' => 'users', 'action' => 'profile'));	
				
			}
	}
		
		
	}
	

	
	
}
