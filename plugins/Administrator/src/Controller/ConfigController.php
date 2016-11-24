<?php
namespace Administrator\Controller;

use Administrator\Controller\AppController;
use Cake\ORM\TableRegistry;

class ConfigController extends AppController {

/**********************
BACKEND AJAX
**********************/

public function initialize()
    {
        parent::initialize();
        $this->loadComponent('RequestHandler');
    }

	//Submir imagnes 
	public function upload() {
	    			 
		//$idImageUpload = $this->Upload->uploadFields ($this->request->data[$upImage], NULL); 
			$posts = TableRegistry::get('Administrator.Posts');
			$users = TableRegistry::get('Administrator.Users');

			//echo pr($this->request->data());

			if(isset($this->request->data['upload'])) {
					
					$idImage = $this->Upload->uploadFields($this->request->data['upload'], '');
					
					if(isset($this->request->data['post_id'])) {
						//si existe la variable post_id hacemos la respectiva relacion con los Posts
						$datosRelacion= ['post_id' => $this->request->data['post_id'], 'archive_id' => $idImage];
						$saveField = $posts->ArchivesPosts->newEntity();

						$save = $posts->ArchivesPosts->patchEntity($saveField, $datosRelacion); 
						$posts->ArchivesPosts->save($save);	

					}

					if(isset($this->request->data['user_id'])) {
						//si existe la variable post_id hacemos la respectiva relacion con los Posts
						$user = $users->get($this->request->data['user_id']);

						$save = $users->patchEntity($user, ['archive_id' => $idImage]); 
						$users->save($save);	

					}


					//Subir 
					if(isset($this->request->data['category'])) {

						$datosRelacion= ['post_id' => $this->request->data['post_id'], 'archive_id' => $idImage];
						$saveField = $posts->ArchivesPosts->newEntity();

						$save = $posts->ArchivesPosts->patchEntity($saveField, $datosRelacion); 
						$posts->ArchivesPosts->save($save);	


					}


			$var=['result'=>$idImage];
			$this->set('File', $var);
			$this->set('_serialize', ['File']);


					
			}

			

		$this->render('index');
		
	}


/**********************
FRONTEND AJAX
**********************/

	//llamamos las ciudades por ajax para el buscador.
	public function api_cities(){ 

	$countries = TableRegistry::get('Administrator.Countries');
	$cities = TableRegistry::get('Administrator.Cities');
	$states = TableRegistry::get('Administrator.States');

    $this->autoRender = false;
    $this->response->type('json');


    $error = ['status'=>'error', 'tp'=>0, 'msg'=>'Not found'];

    	if(isset($this->request->query['type'])) {


			    if($this->request->query['type'] == 'getCountries') {

				    	$paises = $countries->find('list', ['keyField' => 'id', 'valueField' => 'name'])->toArray();	
				    	
				    	if(isset($paises) && !empty($paises)) {
				    		
				    		$data = array('status'=>'success', 'tp'=>1, 'msg'=>"Countries fetched successfully.", 'result'=>$paises);
				    	
				    	} else {

				    		$data = $error;
				    	}

			    
			    } elseif($this->request->query['type'] == 'getStates' && isset($this->request->query['countryId'])) {

				    	$estados = $states->find('list', ['keyField' => 'id', 'valueField' => 'name', 'conditions' => ['States.country_id' => $this->request->query['countryId']] ])->toArray();	
				    	
				    	if(isset($estados) && !empty($estados)) {
				    		
				    		$data = array('status'=>'success', 'tp'=>1, 'msg'=>"States fetched successfully.", 'result' => $estados);
				    	
				    	} else {

				    		$data = $error;
				    	}

			    
			    } elseif($this->request->query['type'] == 'getCities' && isset($this->request->query['stateId'])) {

				    	$ciudades = $cities->find('list', ['keyField' => 'id', 'valueField' => 'name', 'conditions' => ['Cities.state_id' => $this->request->query['stateId']] ])->toArray();	
				    	
				    	if(isset($ciudades) && !empty($ciudades)) {
				    		
				    		$data = array('status'=>'success', 'tp'=>1, 'msg'=>"Cities fetched successfully.", 'result' => $ciudades);
				    	
				    	} else {

				    		$data = $error;
				    	}

			    }


			    else {

			    	$data = $error;
			    }

		} else {

			$data = $error;

		}



    //creamos el json de los datos a enviar (esto lo sacamos de la api de paises con los valores tal cual)
  	$json = json_encode($data);   	
    $this->response->body($json);

   }



	//llamamos las ciudades por ajax para el buscador.
	public function api_citiesid(){ 
	
	$this->viewBuilder()->layout('ajax'); 
    $this->render('default');

    $countries = TableRegistry::get('Administrator.Countries');
    $cities = TableRegistry::get('Administrator.Cities');

       if($this->request->is('ajax')) { 

       		$pais = $countries->find('all', ['conditions' => ['id' => $this->request->data['pais']], 'fields' => ['code'] ])->first()->toArray();
       		//$ciudades = $cities->find('list', ['conditions' => ['country_code' => $pais['code'] ]])->toArray(); 

       		$ciudades = $cities->find('list', ['conditions' => ['country_code' => $pais['code']], 'keyField' => 'id', 'valueField' => 'name', 'group' => 'name'])->toArray();

       		echo json_encode($ciudades);
           
       }
       
   }


	
	
}
