<?php
namespace Administrator\Controller;

use Administrator\Controller\AppController;

use Cake\Core\Configure;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\ORM\TableRegistry;

use Cake\Filesystem\Folder;
use Cake\Filesystem\File;

class ReportsController extends AppController {

	

	public function index() {
	
	   $user = TableRegistry::get('Administrator.Players');
       $retos = TableRegistry::get('Administrator.Posts');

       $usuarios=$user->find('All',['conditions'=>['Players.status'=>'active', 'Players.terminos'=>1], 'order' => ['Players.rank' => 'DESC'], 'limit'=>15, 'contain'=>['ranking']])->toArray();
       $reto=$retos->find('All',['conditions'=>['Posts.type'=>'post'], 'contain'=>['ranking', 'Categories'=>['conditions'=>['Categories.id'=>2]]]])->toArray();

       $todos=$user->find('All')->count();
       $this->set('totales', $reto);
       $this->set('todos', $todos);

       $this->set('usuarios', $usuarios);


		
	}


	public function export() {
	//parent::admin();
		$ruta = TableRegistry::get('Rutas');
		$ciudades =$ruta->find('list', ['keyField' => 'id', 'valueField' => 'ciudad', 'conditions' => ['ciudad !=' => ''], 'group' => ['ciudad']])->toArray();
		$this->set('listado',$ciudades);
		
	}


	public function import() {
	//parent::admin();
		$player = TableRegistry::get('Players');
		$music = TableRegistry::get('Music');
		$players =$player->find('All')->toArray();
		
		//Key => ID de retos - llevo la musica - 2. para la semana - 3. para el mes
		$retos=['9'=>1,'10'=>'(Semanal)','11'=>'(Mensual)'];
		
		foreach ($retos as $key => $reto) {
			# code...
		if($key==9){
			foreach($players as $value){

				
				$registro =$music->find('All',['conditions'=>['email'=>$value->music]])->count();

				if($registro==$reto){
				$estado=$this->Function->retos($value->id, $key, 0);

                    if($estado['mensaje']=='Guardado'){

                        $add='Ha cumplido el RETO > '.$estado['name'].'.';
                        $this->Function->logs($value->id,$add);
                        $add='Acumuló '.$estado['millas'].' Millas.';
                        $this->Function->logs($value->id,$add);
                        //$this->Flash->exito(__('Felicitaciones. Haz cumplido el reto '.$estado['name'].''));

                    } 
                }


	        }

		}else{

			foreach($players as $value){
				//echo  $reto;
				echo $value->music.' - ';
	        	echo $registro =$music->find('All',['conditions'=>['email'=>$value->music, 'tipo LIKE'=>'%'.$reto.'%']])->count();
	        	echo '<br>';

	        	if($registro==1){

	        		$estado=$this->Function->retos($value->id, $key, 0);

			        if($estado['mensaje']=='Guardado'){

			            $add='Ha cumplido el RETO > '.$estado['name'].'.';
			            $this->Function->logs($value->id,$add);
			            $add='Acumuló '.$estado['millas'].' Millas.';
			            $this->Function->logs($value->id,$add);
			            //$this->Flash->exito(__('Felicitaciones. Haz cumplido el reto '.$estado['name'].''));

					}

	        	}
	        	 
	        }



		}
			/*foreach($players as $value){
				echo $value->music.' - ';
				echo $registro =$music->find('All',['conditions'=>['email'=>$value->music]])->count();

				echo '<br>';
			}*/

		}


		$this->render('index');
		


		
	}





	public function upgrade() {
	//parent::admin();
		$player = TableRegistry::get('Administrator.Players');
		
		$players =$player->find('All')->toArray();
		
		//Key => ID de retos - Manager, Promotor
	
			# code...
			
			foreach($players as $value){

				
				$perfil=$player->get($value->id, ['contain'=>['Ranking'=>['conditions'=>['Ranking.post_id !='=>0]]]]);

				/*if($registro==$reto){
				$estado=$this->Function->retos($value->id, $key, 0);

                    if($estado['mensaje']=='Guardado'){

                        $add='Ha cumplido el RETO > '.$estado['name'].'.';
                        $this->Function->logs($value->id,$add);
                        $add='Acumuló '.$estado['millas'].' Millas.';
                        $this->Function->logs($value->id,$add);
                        //$this->Flash->exito(__('Felicitaciones. Haz cumplido el reto '.$estado['name'].''));

                    } 
                }*/

                

                $conteo=0;
                foreach ($perfil->ranking as $datos) {

                	$conteo=$conteo+$datos->millas;
                	# code...
                }	

                $data=['rank'=>$conteo];
                $save = $player->patchEntity($perfil, $data); 
                $player->save($save);

                echo $perfil->name.' - ';
                echo $conteo;
                echo '<br>';


	        }

		$this->render('index');
		
	}




	public function excel() {
	//parent::admin();
		
			if($this->request->is('post')) {

					$ruta = TableRegistry::get('Rutas');
					
					$ciclo=$this->request->data['Ciclo'];
					$ciudad=$this->request->data['Ciudad'];
					$rutaPost=$this->request->data['Ruta'];
					$usuario=$this->request->data['Usuario'];
					$inicial=$this->request->data['Inicial'];
					$final=$this->request->data['Final'];

					if($this->Auth->user('role_id')!=1){
						$var=array('status'=>'aprobado');
					}else{
						$var=array('status'=>'aprobado', 'status'=>'pendiente');
					}
					//$this->Paginator->settings = array('Ruta'=>array('conditions' => array('Rutas.ciclo' => $var), 'order' => array('Rutas.created ASC'), 'limit'=>2));
					if($inicial!='' and $final!='' and $ciclo!=''){
						$rutas=$ruta->find('all',['conditions' => ['ciclo = ' => $ciclo, $var, 'fecha >=' => $inicial, 'fecha <=' => $final], 'order' => ['created ASC']])->toArray();
						//$this->paginate = ['conditions' => ['ciclo = ' => $ciclo, 'ciudad'=>$ciudad, $var, 'fecha >=' => $inicial, 'fecha <=' => $final], 'order' => ['created ASC'], 'limit'=>30,];
					}elseif($rutaPost!='' and $inicial!='' and $final!=''){
						$rutas=$ruta->find('all',['conditions' => ['ciclo = ' => $ciclo, 'ciudad'=>$ciudad, 'ruta'=>$rutaPost, $var, 'fecha >=' => $inicial, 'fecha <=' => $final], 'order' => ['created ASC']])->toArray();
					}
					elseif($rutaPost!='' and $usuario!='' and $inicial!='' and $final!=''){
						$rutas=$ruta->find('all', ['conditions' => ['ciclo = ' => $ciclo, 'ciudad'=>$ciudad, 'usuario'=>$usuario, 'ruta'=>$rutaPost, $var, 'fecha >=' => $inicial, 'fecha <=' => $final], 'order' => ['created ASC']])->toArray();
						
					}
					elseif($rutaPost!='' and $usuario!='' and $inicial=='' and $final==''){
						$rutas=$ruta->find('all', ['conditions' => ['ciclo = ' => $ciclo, 'ciudad'=>$ciudad, $var, 'usuario'=>$usuario, 'ruta'=>$rutaPost,], 'order' => ['created ASC']])->toArray();

					}
					elseif($rutaPost!='' and $inicial=='' and $final==''){
						$rutas=$ruta->find('all', ['conditions' => ['ciclo = ' => $ciclo, 'ciudad'=>$ciudad,  $var, 'ruta'=>$rutaPost,], 'order' => ['created ASC']])->toArray();

					}

					elseif($usuario!='' and $rutaPost=='' and $inicial=='' and $final==''){
						$rutas=$ruta->find('all', ['conditions' => ['ciclo = ' => $ciclo, 'ciudad'=>$ciudad, $var, 'usuario'=>$usuario,], 'order' => ['created ASC']])->toArray();

					}
					elseif($ciudad!='' and $ciclo!=''){
						
						$rutas=$ruta->find('all', ['conditions' => ['ciclo = ' => $ciclo, 'ciudad'=>$ciudad, $var], 'order' => ['created ASC'] ])->toArray();
					}

					else{
						$rutas=$ruta->find('all', ['conditions' => ['ciclo = ' => $ciclo, $var], 'order' => ['created ASC'] ])->toArray();
						
					}
					
					$this->set('usuarios', $rutas);

					/*$producto = TableRegistry::get('Productos');
					$productos=$producto->find('all',['conditions'=>['Productos.ciclo ='=>$ciclo]])->toArray();
					$this->set('productos', $productos);*/

						if(empty($rutas)){
							$this->Flash->alerts('Lo sentimos, no hay datos');
							//$this->redirect(array('action' => 'export'));
						}

				}else{
					$this->Flash->alerts('Acceso Restringido.');
					$this->redirect(array('controller'=>'reports', 'action' => 'search'));
				}



		
	}

	public function search() {
	//parent::admin();
		$ruta = TableRegistry::get('Rutas');
		$ciudades =$ruta->find('list', ['keyField' => 'id', 'valueField' => 'ciudad', 'conditions' => ['ciudad !=' => ''], 'group' => ['ciudad']])->toArray();
		$this->set('listado',$ciudades);

		$usuario = TableRegistry::get('Rutas');
		$usuarios =$usuario->find('list', ['keyField' => 'id', 'valueField' => 'usuario', 'conditions' => ['ciudad !=' => ''], 'group' => ['usuario'], 'order'=>'usuario ASC'])->toArray();
		$this->set('usuarios',$usuarios);


	
			
		
	}


	
	
}
