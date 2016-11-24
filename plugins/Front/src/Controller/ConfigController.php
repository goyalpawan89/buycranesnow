<?php

namespace Front\Controller;

use Cake\Core\Configure;
use Front\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Controller\Component;
use Cake\I18n\I18n;


class ConfigController extends AppController {

/**********************
BACKEND AJAX
**********************/

public function initialize()
    {
        parent::initialize();
        $this->loadComponent('RequestHandler');
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
