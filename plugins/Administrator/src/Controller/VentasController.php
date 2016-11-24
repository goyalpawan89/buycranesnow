<?php
namespace App\Controller;

use Cake\Core\Configure;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\ORM\TableRegistry;

class VentasController extends AppController {

	//pagina principal 
	public function index() {

		//Moneda
		$general = TableRegistry::get('Generals');
		$tv = TableRegistry::get('Tv');
		$internet = TableRegistry::get('Internet');
		$user = TableRegistry::get('Users');

		$datoGeneral = $general->find('all',['fields' => ['option_key', 'option_value', 'type']]); 
		//$datoGeneral=$datoGeneral->toArray();
		$datoTv = $tv->find('list', ['keyField' => 'id', 'valueField' => 'name'])->toArray();
		$datoInternet = $internet->find('list', ['keyField' => 'id', 'valueField' => 'name'])->toArray();

		$cantidad=[1=>1,2,3,4]; 
		$cantidad2=[1=>1,2,3,4,5]; 


		$this->set(compact('datoTv', 'datoInternet', 'cantidad', 'cantidad2'));

		$dato = $this->Ventas->find('all'); 
		$this->set('datoGeneral', $dato);

		$venta = $this->Ventas->newEntity();
        $this->set('venta',$venta);


        if($this->request->is('post')) {

        	$num = $general->find('All',['conditions'=>['Option_key'=>'Consecutivo formulario']])->first(); 
        	
        	$id = $general->get($num->id);
			$num= $num->option_value+1;
			$data=array('option_value' => $num);
            $save2 = $general->patchEntity($id, $data,  ['validate' => false]);  

        	//Rol 2: Validador
        	$admin = $user->find('All',['conditions'=>['role_id'=>'2']]); 
        	
        	if($admin->count()>=1){

        		$admin->toArray();
        		
        		$backend=rand(1, $admin->count());
        		$FirtsId=array();
        		$SecondId=array();
        		foreach ($admin->toArray() as $key => $value) {
        			$id=$value['id'];
        			$con = $this->Ventas->find('All',['conditions'=>['backend'=>$value['id']]])->count();
        			array_push($FirtsId, $id);
        			array_push($SecondId, $con);
        		}
        		$tt=array_combine($FirtsId, $SecondId);
        		asort($tt);
        		
        		$info=['user_id'=>$this->request->session()->read('Auth.User.id'), 'backend'=>key($tt), 'contrato'=>$num];
	        	$data=array_merge($info,$this->request->data);
	        	//$dato=['user_id'=>1];
	            $save = $this->Ventas->patchEntity($venta, $data);

		           	if ($this->Ventas->save($save) and $general->save($save2)) {
						$this->Flash->exito(__('Los datos se han actualizado correctamente. Número del Caso:'.$num.''));
						$this->redirect(array('action' => 'index'));
					}


        		}else{
        			$this->Flash->alerts(__('Lo sentimos no hay usuarios disponibles para validar el contrato.'));

        	}



        	
						
		}
		
	}


	public function historial() {
          
          //Define el Theme del Formulario.
          $this->set('template', Configure::read('Template_Form.pass'));

		$user = TableRegistry::get('Ventas');

        $pendientes = $user->find('all', ['conditions' => ['Ventas.actual = ' => 'Pendiente']])->count(); 
        $aprobados = $user->find('all', ['conditions' => ['Ventas.actual = ' => 'Aprobado']])->count(); 
        $rechazados = $user->find('all', ['conditions' => ['Ventas.actual = ' => 'Rechazado']])->count();
        $vencidos = $user->find('all', ['conditions' => ['Ventas.actual = ' => 'Vencido']])->count(); 

        $todos= $pendientes+$aprobados+$rechazados+$vencidos;
        $this->set(compact('pendientes', 'aprobados', 'vencidos', 'rechazados', 'todos')); 

          $this->paginate = [
	            'limit'=>10,

	        ];
          $userId = $this->Auth->user('id');
          $profile=$user->find('all', ['contain' => ['Internet', 'Tv'], 'order'=>['Ventas.prioridad'=> 'DESC', 'Ventas.created'=> 'DESC', ],]);

          $search=$this->paginate($profile);
          $this->set('user', $search->toArray());
         
        
    }




    public function edit($id = null) {
          
          //Define el Theme del Formulario.
    	if($id==null){
    		$this->Flash->alerts(__('Area de acceso restringido.'));
			$this->redirect(array('action' => 'index'));
    	}

    	$val = $this->Ventas->find('all',['conditions' => ['id' => $id, 'user_id'=>$this->Auth->user('id')]])->count();

	    if($val!=0){
	    $this->set('template', Configure::read('Template_Form.pass'));

		$general = TableRegistry::get('Generals');
		$tv = TableRegistry::get('Tv');
		$internet = TableRegistry::get('Internet');
		$user = TableRegistry::get('Users');

		$datoGeneral = $general->find('all',['fields' => ['option_key', 'option_value', 'type']]); 
		//$datoGeneral=$datoGeneral->toArray();
		$datoTv = $tv->find('list', ['keyField' => 'id', 'valueField' => 'name'])->toArray();
		$datoInternet = $internet->find('list', ['keyField' => 'id', 'valueField' => 'name'])->toArray();

		$cantidad=[1=>1,2,3,4]; 
		$cantidad2=[1=>1,2,3,4,5]; 


		$this->set(compact('datoTv', 'datoInternet', 'cantidad', 'cantidad2'));


		$venta = $this->Ventas->get($id);
        $this->set('venta',$venta);
		$this->render('index');

		}else{
	    	$this->Flash->alerts(__('Lo sentimos. No tienes acceso a este contrato.'));
			$this->redirect(array('action' => 'historial'));
	    }
         
        
    }    

		
	
	
	
}
