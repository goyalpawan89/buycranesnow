<?php 

/*App::uses('Component', 'Controller');
App::uses('Controller',    'Controller');
App::uses('ClassRegistry', 'Utility');

App::uses('HttpSocket', 'Network/Http');
App::uses('JsonView', 'View');*/


namespace Administrator\Controller\Component;

use Cake\Controller\Component;
use Cake\ORM\TableRegistry;
use Cake\Core\Configure;
use Cake\Network\Http\Client;

use Cake\Filesystem\Folder;
use Cake\Filesystem\File;


class FunctionComponent extends Component {
    
    public $components = array('Session', 'RequestHandler', 'Auth', 'Flash');

	public $helpers = array('Session');
	public $controller = null;

	public function onlyUser($v1) {

          if($v1==null or $v1='') {
		  	$this->Session->setFlash('Acceso denegado', 'alerts');
		  	/*echo Router::connect('/', array('controller' => 'home'));
		  	echo $url=Router::url( '/', true ).$logo;*/
		  //echo pr($_SERVER);
		  	header("Location: ".$_SERVER['REDIRECT_URL']."");
			die();
		  	//$this->redirect(array('controller' => 'users', 'action' => 'profile')); 
		  }	
	}


    public function security($action, $string) {
	    $output = false;

	    $encrypt_method = "AES-256-CBC";

	    Configure::load('security');
	    $secret_key = Configure::read('Security.TT');
	    $secret_iv = Configure::read('Security.Elymki');

	    // hash
	    $key = hash('sha256', $secret_key);
	    
	    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
	    $iv = substr(hash('sha256', $secret_iv), 0, 16);

	    if( $action == 'encrypt' ) {
	        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
	        $output = base64_encode($output);
	    }
	    else if( $action == 'decrypt' ){
	        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
	    }

	    return $output;
	}




	/**** Validacion de Licencia ****/
		

	/*** Tipo de errores ****
	
	Error 001: Licencia Terminada
	Error 404: Licencia no Coincide con BD Elymki.
	Error 505: Datos de IP, Servename y estado != active No coinciden. Usuario sin logueo
	Error 506: Datos de IP, Servename y estado != active No coinciden. Usuario logueado
	Error 600: Licencia Suspendida Usuario Deslogueado.
	Error 601: Licencia Suspendida Usuario Logueado.

	*/
	public function apiLicense($license){
		 	
		if(!isset($license)){
			$license='error';
		}
		
		$key= $this->security('encrypt', $license);


		$url='http://elymki.com/interactiva/api/license/'.$key.'.json';
		$json = file_get_contents($url);
		$json = json_decode(utf8_encode($json),true);

		$this->request->session()->write('Auth.License.Key', $license);

		//echo pr($json);

		if(isset($json['elymki'][0])){
			if($json['elymki'][0]=='No hay datos' or $json['elymki'][0]=='Error de conexion'){
				
				$mensaje='Error 404';
				$this->request->session()->write('Auth.License.State', $mensaje);				
			}
		}else{

			//$this->Session->write('Auth.License.State', $mensaje);

			$mensaje=$json['elymki']['Estado'];
			//$this->Session->write('Auth.License.State', $mensaje);
			
			$servidor=$_SERVER['SERVER_NAME'];
			$dominio=$json['elymki']['Dominio'];
			
			$dominio=str_replace("https://www.", "", $dominio);
			$dominio=str_replace("https://", "", $dominio);
			$dominio=str_replace("http://www.", "", $dominio);
			$dominio=str_replace("http://", "", $dominio);
			$dominio=str_replace("www.", "", $dominio);
			
			$cadena=stripos($servidor, $dominio);
				
				if($cadena!==false and $json['elymki']['Ip']==$_SERVER['SERVER_ADDR'] and $json['elymki']['Estado']=='active'){
				//echo 'Licencia OK';
					
					if($this->name=='Errors'){

						
						//$mensaje='GOOD';
						$mensaje=$json['elymki']['Estado'];
						$this->request->session()->write('Auth.License.State', $mensaje);
					//$this->redirect(array('controller' => 'users', 'action' => 'profile'));	

					}
					
				}elseif($json['elymki']['Estado']=='inactive'){
					//echo 'Licencia Suspendida';
					
					if($this->request->session()->read('Auth.User.id')){
						
						if($this->name!='Errors'){
							$mensaje='Error 601';
							$this->request->session()->write('Auth.License.State', $mensaje);
							//$this->redirect(array('controller' => 'errors', 'action' => 'suspendida'));
						}
					//	
					}else{
						
						$mensaje='Error 600';
						$this->request->session()->write('Auth.License.State', $mensaje);
					//$this->redirect(array('controller' => 'users', 'action' => 'profile'));		
					}
				
				}elseif($json['elymki']['Estado']=='terminate' and $this->name != 'Errors'){
					//echo 'Licencia Terminada';
					//$this->redirect(array('controller' => 'errors', 'action' => 'suspendida'));
					$mensaje='terminate';
					$this->request->session()->write('Auth.License.State', $mensaje);
				
				}elseif($json['elymki']['Estado']=='inactive' or $json['elymki']['Estado']=='terminate' and $this->view == 'licence'){
			
			
					//echo 'licencia errada';
			
				}else{
				
					if($this->request->session()->read('Auth.User.id')){
						$mensaje='Error 506';
						$this->request->session()->write('Auth.License.State', $mensaje);
						//$this->redirect(array('controller' => 'errors', 'action' => 'suspendida'));
					}else{
						$mensaje='Error 505';
						$this->request->session()->write('Auth.License.State', $mensaje);
					}
				
			//echo 'error';
			
				}
		}

		//echo $mensaje;
		
		return $mensaje;
		
		}
		/*** Fin validacion Licencia ***/


		public function url2seo1($url) {
			       strtolower($url);
							  $find = array('\r\n', '\n', '+', 'ñ', 
							   "\\", "¨", "º", "-", "~",
										"#", "@", "|", "!", "\"",
										"·", "$", "%", "&", "/",
										"(", ")", "?", "'", "¡",
										"¿", "[", "^", "`", "]",
										"+", "}", "{", "¨", "´",
										">", "< ", ";", ",", ":",
										" ");
							
							$final = str_replace ($find, '-', $url);
							return $final;
		}


		// información general del blog (nombre, descripcion, email admin etc)
		public function webInfo($dato) {
			$this->loadModel('General');
			$opciones = $this->General->find('first', array('conditions' => array('General.option_key' => $dato)));
			echo $opciones['General']['option_value'];
		}


		/***** Moneda ******/
		public function moneda(){

				$currency=ClassRegistry::init('Currency');
				$general=ClassRegistry::init('General');

				$monedas = $currency->find('all'); 
				
				$up = $general->find('first', array('conditions' => array('General.option_key = ' => 'Moneda Principal')));
				$id=$up['General']['option_value'];

				$moneda = $currency->find('first', array('conditions' => array('Currency.id = ' => $id)));
				return $moneda;
				
		}

		/***** Moneda ******/
		public function All_moneda(){

				$currency=ClassRegistry::init('Currency');
				$general=ClassRegistry::init('General');

				$monedas = $currency->find('all'); 
				
				$moneda = $currency->find('all');
				return $moneda;
				
		}

		// si la varialbe dada es igual al usuario logueado
		
			
		public function siExiste($id, $action, $controller) {
			if(isset($id)) { 
			 return true;  
			  } else {  
			  if($controller==null) { $this->redirect(array('action' => $action)); } else { $this->redirect(array('controller' => $controller, 'action' => $action)); }
			}
		}
		
		public function logs($id, $msj) {

			$log = TableRegistry::get('Administrator.Logs');
	    	$msj='El usuario ha: '.$msj.'';
			$data=['player_id'=>$id, 'action'=>$msj];
	        $save=$log->newEntity($data);

	        return $log->save($save);
        
		}


		public function millas($id) {

			$usuario = TableRegistry::get('Administrator.Players');
			$user=$usuario->find('All',['conditions'=>['Players.id'=>$id], 'contain'=>['Ranking'=>['conditions'=>['Ranking.status'=>'active']]]])->first();

			$conteo=0;
			foreach ($user->ranking as $key => $value) {
				$conteo=$value['millas']+$conteo;
			}

			$data=['rank'=>$conteo];
	        $save = $usuario->patchEntity($user, $data); 
	        if ($usuario->save($save) ){

	        	$resultado=$conteo;
	        }

			return $resultado;
		}


		

		public function retos($id, $idreto, $code) {

		$retos = TableRegistry::get('Administrator.Posts');
		$ranking = TableRegistry::get('Administrator.Ranking');

    	$reto=$retos->find('all',['conditions'=>['Posts.status'=>'active', 'Posts.id'=>$idreto], 'contain'=>['Fields']])->first();
    	if(!empty($reto)){
    		foreach ($reto->fields as $key=>$value) {
				if($value['option_key']=='Millas'){
					$millas=$value['_joinData']['value'];
				}
			}

			$rank=$ranking->find('All',['conditions'=>['Ranking.player_id'=>$id, 'Ranking.post_id'=>$reto->id]])->count();
			if($rank==0){
				$data=['post_id'=>$reto->id, 'player_id'=>$id, 'code_id'=>$code, 'millas'=>$millas];
		        $save=$ranking->newEntity($data);

		        if($ranking->save($save)){
		        	$this->millas($id);	
		        	$mensaje=['name'=>$reto->name,'millas'=>$millas,'mensaje'=>'Guardado'];
		        }

			}else{
				$mensaje=['name'=>$reto->name,'millas'=>$millas,'mensaje'=>'Existe'];
			}


    	}else{
    		$mensaje=['mensaje'=>'Inactive'];
    	}

        
        return $mensaje;
        
	}



}