<?php
namespace App\Controller;

use Cake\Core\Configure;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\ORM\TableRegistry;

class TrmController extends AppController
{
	
    public $uses = array('Currency', 'Trm', 'General');
	public $name = 'Trm';
	//public $components = array('Function');
	
	public function index() {
		$this->redirect(array('action' => 'view'));
	}
	
	public function monedas() {
		$this->redirect(array('action' => 'view'));
	}
	
	
	public function view() {
		$currency = TableRegistry::get('Currency');	
		$currency->paginate = [
        	'conditions' => ['Currency.status = ' => 'active'],
        ];

		$datos = $this->paginate($currency); 

		/*$this->Paginator->settings = array('Currency' =>array('conditions' => array('Currency.status = ' => 'active'), 'order'=>array('code'=> 'asc'),'limit' => 50));
		$datos = $this->Paginator->paginate('Currency'); */
		$this->set('datos', $datos);
		
		

			/*$conteo = $this->Currency->find('count', array('conditions' => array('Currency.status = ' => 'active'))); $this->set('conteo', $conteo); //conteo por usuarios y estado activo
		    $inactivos = $this->Currency->find('count', array('conditions' => array('Currency.status = ' => 'inactive'))); $this->set('inactivos', $inactivos); //conteo por usuarios y estado inactivo
		    $todos = $this->Currency->find('count'); $this->set('todos', $todos); //conteo todos los usuarios*/          

		$search = $currency->find('all', ['conditions' => ['Currency.status != ' => 'removed']]); 
        $activos = $currency->find('all', ['conditions' => ['Currency.status = ' => 'active']]); 
        $inactivos = $currency->find('all', ['conditions' => ['Currency.status = ' => 'inactive']]); 
        
        $activos = $activos->count();
        $todos = $search->count();
        $inactivos = $inactivos->count();
        
        $this->set(compact('activos', 'inactivos', 'todos'));    
		
	}

	public function trash() {
	      $this->Rol->admin();
				
				
				$this->Paginator->settings = array('Currency' =>array('conditions' => array('Currency.status = ' => 'inactive'), 'order'=>array('id'=> 'desc'),'limit' => 10));
				$datos = $this->Paginator->paginate('Currency'); 
				$this->set('datos', $datos);
				
		        $conteo = $this->Currency->find('count', array('conditions' => array('Currency.status = ' => 'active'))); $this->set('conteo', $conteo); //conteo por usuarios y estado activo
		    	$inactivos = $this->Currency->find('count', array('conditions' => array('Currency.status = ' => 'inactive'))); $this->set('inactivos', $inactivos); //conteo por usuarios y estado inactivo
		    	$todos = $this->Currency->find('count'); $this->set('todos', $todos); //conteo todos los usuarios
				
				if($inactivos==0){
					$this->Session->setFlash(__('No hay items inactivos.'), 'alerts');
					$this->redirect(array('action' => 'View'));
				}

				  
		        if($this->request->is('post')) {
						if(isset($this->request->data['Currency']['checkbox'])) {
						         foreach($this->request->data['Currency']['checkbox'] as $ID) {
								 $this->Currency->id = $ID;
								 $data=array('status' => 'active');
								 $this->Currency->save($data);
								 }
								 
								 $this->Session->setFlash(__('Categorías actualizadas'), 'exito');
								 $this->redirect(array('action' => 'index'));
						}
			    }
	  
	     $this->render('view');
		
	     }
	
	
	public function clear($id) {
		  $this->Rol->admin();
		   
			if($this->request->is('get')) { 
			//throw new MethodNotAllowedException();
			$this->Session->setFlash(__('Area de acceso restringida.'), 'alerts');
			$this->redirect(array('action' => 'view'));
			} else {
			$this->Currency->id = $id;
			$this->Currency->save(array('status' => 'inactive'));
			$this->Session->setFlash(__('La moneda se ha desactivado.'), 'alerts');
			$this->redirect(array('action' => 'view'));	 
			}
	}
	
	public function restore($id) {
		  $this->Rol->admin();
		   
			if($this->request->is('get')) { 
			//throw new MethodNotAllowedException();
			$this->Session->setFlash(__('Area de acceso restringida.'), 'alerts');
			$this->redirect(array('action' => 'view'));
			} else {
			$this->Currency->id = $id;
			$this->Currency->save(array('status' => 'active'));
			$this->Session->setFlash(__('La moneda se ha reactivado.'), 'exito');
			$this->redirect(array('action' => 'view'));	 
			}
	}

	
	public function add() {
		
		$this->set('data', '');
		if($this->request->is('post')) {
				        	
	        	$general = TableRegistry::get('Generals');
	        	$dato=$general->findAllByOption_key('Default TRM')->toArray();
				$query= $dato[0]->option_value;
				
				$value=$general->findAllByOption_key($query)->toArray();
				$valor= $value[0]->option_value;
				
				
				if($query=='Porcentaje % TRM'){
					$copFinal=$this->request->data['default_trm']*$valor/100+$this->request->data['default_trm'];	
				}else{
					$copFinal=$this->request->data['default_trm']+$valor;
				}
				
				$copFinal=number_format($copFinal,2,'.','');
				$fecha=date('Y-m-d H:i:s');
				//echo pr($this->request->data);
		        	
		        	$upgrade=[
					//$this->request->data,
					'name'=>$this->request->data['name'],
					'code'=>$this->request->data['code'],
					'usd'=>$this->request->data['usd'],
					'default_trm'=>$this->request->data['default_trm'],
					'value_trm'=>$copFinal,
					//'status'=>$this->request->data['status'],
					'trm' => [
				         'usd' => $this->request->data['usd'], 'default_trm' => $this->request->data['default_trm'], 'value_trm' => $copFinal, 'date'=>$fecha,
				    	],
				    ];
	                
				    $currency = TableRegistry::get('Currency');
	                $save = $currency->newEntity($upgrade, ['associated'=>['trm']]);            
			        if($currency->save($save)){
			        	$this->Flash->exito(__('Los datos han sido almacenados correctamente.'));
			        	$this->redirect(array('action' => 'view'));
			        }else{
			        	$this->Flash->validation('Ha ocurrido un error.',[
                            'params' => [
                                'error' => [$save->errors()],
                            ]]);
			        }
	
				
				
	
		}
			
	}
	
	public function edit($var = null) {
		  $this->Rol->admin();
		  	 
			if($this->request->is('get')) {

				$currency = TableRegistry::get('Currency');

		 		$estado=$currency->schema()->column('status');
	            $estado=$estado['comment'];
	            preg_match_all("/'(.*?)'/", $estado, $enums1);
	        
	            $status = $enums1[1];
	            $status=array_combine($status, $status);
	            $this->set(compact('status')); // tipos de estado  
				
				$currency=$currency->get($var);
				$this->set('data', $currency);
				
			} else { //peticion post guardar
            		
					//echo pr($this->request->data);
					$currency = TableRegistry::get('Generals');
					$dato=$currency->findAllByOption_key('Default TRM')->toArray();
					$query= $dato[0]->option_value;

					$value=$currency->findAllByOption_key($query)->toArray();
					$value= $value[0]->option_value;
					//echo $value;
					
					if($query=='Porcentaje % TRM'){
						$copFinal=$this->request->data['default_trm']*$value/100+$this->request->data['default_trm'];	
					}else{
						$copFinal=$this->request->data['default_trm']+$value;
					}
					
					//$COP=number_format($COP,2,'.','');
					$copFinal=number_format($copFinal,2,'.','');
					$fecha=date('Y-m-d H:i:s');
					
					//Guardar los datos
					/*$data=array('currency_id' => $this->Currency->id, 'usd' => $this->request->data['Currency']['usd'], 'trm' => $this->request->data['Currency']['trm'], 'value' => $copFinal, 'date' => $fecha); 
					$this->Trm->Save($data);	*/

					//$dato = $currency->get($moneda);
					$upgrade=[
					'id'=>$var,
					'name'=>$this->request->data['name'],
					'code'=>$this->request->data['code'],
					'usd'=>$this->request->data['usd'],
					'default_trm'=>$this->request->data['default_trm'],
					'value_trm'=>$copFinal,
					'status'=>$this->request->data['status'],
					'trm' => [
				        'currency_id' => $var, 'usd' => $this->request->data['usd'], 'default_trm' => $this->request->data['default_trm'], 'value_trm' => $copFinal, 'date'=>$fecha,
				    ],
				    ];
	                
				    $currency = TableRegistry::get('Currency');
	                $save = $currency->newEntity($upgrade, ['associated'=>['Trm']]);            
			        $currency->save($save);


					//Fin Historico
		
					 $this->Flash->exito(__('Moneda actualizada'));
					 $this->redirect(array('action' => 'View'));
				  //} else { $this->Flash->alerts(__('No se pudo guardar')); }
            }
			$this->render('add');
	}


	//Usd 
	public function currency($var=null) {
		

		if(!isset($var)){
			$this->Flash->alerts('No hay registros.');
			$this->redirect(array('action' => 'View'));
		}else{

			$currency = TableRegistry::get('Currency');
			$datos = $currency->find('all', ['conditions'=>['Currency.code ='=>$var], 'order' => ['Currency.created' => 'DESC']])->contain(['Trm'])->order(['Trm.created' => 'ASC']);
			$id = $datos->first()->toArray();

			//echo pr($id);
			if($id==null){
				$this->Flash->infos(__('Lo sentimos la moneda no existe.'));
				$this->redirect(['action' => 'Add']);
			}
			if(!isset($id) and isset($var)){
				$this->Flash->infos(__('Lo sentimos no hay historial.'));
				$this->redirect(array('action' => 'edit/'.$id->id.''));
			}

					$this->set('CODE', $id['code']);
					$this->set('name', $id['name']);
					
					$this->set('usd', $id['usd']);
					$this->set('cotizacion', $id['value_trm']);
					$this->set('trm', $id['default_trm']);
					$this->set('fecha', $id['modified']);
			

			$this->paginate = [
	        'conditions' => ['Trm.currency_id = ' => $id['id']],
	        'order'=>array('id'=> 'desc'),
	            'contain' => ['Currency'],
	            'limit'=>10,
	        ];

	        $datos = $this->paginate(); 
	        $this->set('datos', $datos);	

        //echo pr($datos->toArray());	
		}

	}
	
	public function sync(){
		//$this->Rol->admin();


	}




	public function syncfull(){
		$this->Rol->admin();

				if($this->Session->read('Auth.User.role_id')==1){

				//$license='000';
				$license = $this->General->find('first', array('conditions' => array('General.option_key' => 'Licencia')));
				$license=$license['General']['option_value'];
				$key= $this->Function->security('encrypt', $license);
				//$url='http://elymki.com/interactiva/api/license/'.$key.'.json';
				$url='http://elymki.com/interactiva/api/currency/'.$key.'.json';

				$this->Http = new HttpSocket();
				$json = $this->Http->get($url);
				$json=json_decode($json, true);
				//echo pr($json);


				$COP=$json['Elymki']['Monedas']['COP'];
				//$fecha=$exchangeRates['timestamp'];
				//$fecha=date('Y-m-d H:i:s', $json['Elymki']['Fecha']);
				$fecha=$json['Elymki']['Fecha'];
				
				$data=array();
				$trm=array();
				foreach($json['Elymki']['Monedas'] as $key => $dat){
					//Guardar los datos
					$up = $this->Currency->find('first', array('conditions' => array('Currency.code = ' => $key)));
					$id=$up['Currency']['id'];
					$dat=number_format($dat,2,'.','');
					$final=array('id'=>$id,'code' => $key, 'usd' => $dat); 
					array_push($data,$final);

					//Historial
					$idTrm=$up['Trm'][0]['id'];
					$datos=array('currency_id'=>$id, 'usd'=>$dat);
					array_push($trm, $datos);

				}
				
				if ($this->Currency->saveAll($data)) {

					if($this->Trm->saveAll($trm)){

						$this->Session->setFlash('Datos sincronizados con exito.', 'exito');
						$this->redirect(array('action' => 'View'));
					}	
					
				}else{
					$this->Session->setFlash('Ha ocurrido un error_log(message).', 'alerts');
					$this->redirect(array('action' => 'View'));
				}
				
				//$this->Currency->saveMany($data, array('deep' => true));

			}else{
				$this->Session->setFlash('Area de acceso restringida.', 'alerts');
				$this->redirect(array('action' => 'View'));
			}
			
	}

	public function api($id=null) {

			$this->loadModel('General');
			$license = $this->General->find('first', array('conditions' => array('General.option_key' => 'Licencia')));
			$id=explode('_',$id);
			$key='FF3b0qyJfIxfs2guVoUubWwvniR2G0FgaC9mi';
			$license = $license['General']['option_value'];

			$this->loadModel('Licenses');
			$license = $this->Licenses->find('count', array('conditions' => array('Licenses.license' => $id[0], 'status'=> 'active')));

			if(!isset($id) or !isset($id[1]) or $id[1]!=$key or $license!=1){
			
				$variable=array('Error de conexion');
			   
			}else{
			
				if($license and $id[1]==$key){
					$license = $this->Currency->find('all', array('fields' => array('Currency.code', 'Currency.usd')));
					$name=array();
					$valor=array();
					foreach($license as $llave){
						
						array_push($name, $llave['Currency']['code']);
						array_push($valor, $llave['Currency']['usd']);
					}

					$ano=date('Y');
					$variable=array_combine($name, $valor);
					$grupo = $this->Currency->find('all', array('group' => array('Currency.modified')));
					//echo pr($grupo);
					$fecha=$grupo[0]['Currency']['modified'];

					$variable=array('Customer'=>'Derechos reservados T&T Interactiva SAS. 2010 - '.$ano.'', 'Fecha'=>$fecha, 'Currency'=>'USD','Monedas'=>$variable);
					//echo pr($variable);

					//$variable=$license;
					//$variable=array('Estado'=>$license['License']['status'], 'Dominio'=>$license['License']['domain'], 'Ip'=>$license['License']['ip']);

				}else{
					$variable=array('No hay datos');
				}

			}
			
			 
			$this->set(array(
            'Elymki' => $variable,
            '_serialize' => array('Elymki')));
 
	}
	
	
}
