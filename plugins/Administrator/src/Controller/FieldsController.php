<?php
namespace Administrator\Controller;

use Administrator\Controller\AppController;

use Cake\Core\Configure;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\ORM\TableRegistry;

class FieldsController extends AppController {

	//campos personalizados administrables
	public function getCustomFields() {
			if (isset($this->request->params['type'])) {
				 $getCustomFields = $this->Fields->find('all', array('conditions' => array('Fields.type = ' => $this->request->params['type'])));
				 $this->response->body($getCustomFields);
			    return $this->response;

			}
	}
	
	//campos personalizados administrables




	//obtener campos personalizados totales y buscar los que apareecn.
	public function getAllCustomFieldsByPost() {
	
	if ($this->request->is('requested')) {

	$post = TableRegistry::get('Administrator.Posts');
	$generals = TableRegistry::get('Administrator.Generals');

	$var=$this->request->params['id'];
	$type=$this->request->params['type'];
	
	if(isset($var) and $var!=''){
		$post = $post->find('all', array('conditions' => array('Posts.id = ' => $var), 'contain'=>['Fields']))->first(); 	
	}else{
		$post = $post->find('all',['contain'=>['Fields']])->ToArray(); 
	}
			//$type='post';
			
			$allCustomFields = $this->Fields->find('all', array('conditions' => array('Fields.type = ' => $type)))->ToArray();


			$Fields=array();
			foreach($allCustomFields as $key => $archivo){
				
				//echo pr($post->Field);	
				if(isset($post['fields']) && !empty($post['fields'])) {
					
					for($a=0;$a<count($post['fields']);$a++){
						if($post['fields'][$a]['_joinData']['field_id']==$archivo['id'] ){
							$value = $post['fields'][$a]['_joinData']['value'];
									$idValue = $post['fields'][$a]['_joinData']['id'];
									//$a=count($post['Fields']);
						}else{
							$value = NULL;  $idValue = NULL; 
						}
					}
					
				} else { 
					$value = NULL; $idValue = NULL;
				 }
				
				//echo pr($archivo);
					if(!isset($value) || !isset($idValue)) { 
					$value = NULL; $idValue = NULL; 
					} // si no existe $value generarla como nula. (evita errores cuando la entrada no tiene categorias seleccionadas)

					$empty='Selecciona una opción';
					$inputOption = json_decode($archivo['option_value'], true);
					array_push($Fields, array('id' => $idValue,
											  'field_id' => $archivo['id'], 
											  'field_value' => $value, 
											  'field_key' => $archivo['option_key'],
											  'input' => $inputOption['input'],
											  'placeholder' => $inputOption['placeholder'],	
											  'options' => $inputOption['options'],												  
											  'type' => $archivo['type'],
											  'empty' => $empty,

											 )
					  );

					}


				
					//return $Fields;

					$this->response->body($Fields);
			    	return $this->response;
			    }
	
		 }


	//obtener campos personalizados totales y buscar los que apareecn.
	public function getAllCustomFieldsByCategories() {
	
	if ($this->request->is('requested')) {

		$Categories = TableRegistry::get('Administrator.Categories');
		$general = TableRegistry::get('Administrator.Generals');
		$var=$this->request->params['id'];
		$type=$this->request->params['type'];

		$cat = $Categories->find('all', array('conditions' => array('id' => $var), 'contain'=>'Fields'))->first(); 
				//echo pr($cat);
				
				$allCustomFields = $this->Fields->find('all', array('conditions' => array('Fields.type = ' => $type)))->ToArray();

				$Fields=array();

				foreach($allCustomFields as $key => $archivo){
					

					if(isset($cat['fields']) && !empty($cat['fields'])) {
					
						for($a=0;$a<count($cat['fields']);$a++){
							if($cat['fields'][$a]['_joinData']['field_id']==$archivo['id'] ){
								$value = $cat['fields'][$a]['_joinData']['value'];
								$idValue = $cat['fields'][$a]['_joinData']['id'];
										
							}else{
								$value = NULL;  $idValue = NULL; 
							}
						}
						
					} else { $value = NULL; $idValue = NULL; }
						
						if(!isset($value) || !isset($idValue)) { $value = NULL; $idValue = NULL; } // si no existe $value generarla como nula. (evita errores cuando la entrada no tiene categorias seleccionadas)
								$inputOption = json_decode($archivo['option_value'], true);

	    						$empty='Selecciona una opción';

								array_push($Fields, array('id' => $idValue,
														  'field_id' => $archivo['id'],
														  'field_value' => $value, 
														  'field_key' => $archivo['option_key'],
														  'input' => $inputOption['input'],
														  'placeholder' => $inputOption['placeholder'],	
														  'options' => $inputOption['options'],
														  'empty' => $empty,												  
														  'type' => $archivo['type'],
														 )
								  );
						}
		
						$this->response->body($Fields);
				    	return $this->response;
		}	
	}


	//obtiene el campo personalizado por id del post y por la llave del campo (field_key).
	public function getFieldByPostId() {
			if (isset($this->params['named']['postId']) && isset($this->params['named']['fieldKey']) && !empty($this->params['named']['postId']) && !empty($this->params['named']['fieldKey'])) {
				$field = $this->Field->find('first', array('conditions' => array('Field.post_id = ' => $this->params['named']['postId'], 'Field.field_key = ' => $this->params['named']['fieldKey'])));
			} elseif(isset($this->params['named']['postId'])  && !empty($this->params['named']['postId'])) {
				$field = $this->Field->find('first', array('conditions' => array('Field.post_id = ' => $this->params['named']['postId'])));
			} else {
				$field = NULL;
			}
				if(!empty($field)) {
					return $field['Field']['field_value'];
				} else { 
					return NULL;
				 }
	}

	//obtiene el campo personalizado por id del post y por la llave del campo (field_key).
	public function getAllCustomFieldsByPostId($id) {

			if (isset($id)) {
				$field = $this->Field->find('all', array('conditions' => array('Field.post_id = ' => $id)));
				return $field;
			} else {
				return array();
			}


	}


	//obtiene el campo personalizado por id de la categoria y por la llave del campo (field_key).
	public function getFieldbyCategoriesId() {
			if (isset($this->params['named']['CategoriesId']) && isset($this->params['named']['fieldKey']) && !empty($this->params['named']['CategoriesId']) && !empty($this->params['named']['fieldKey'])) {
				$field = $this->Field->find('first', array('conditions' => array('Field.Categories_id = ' => $this->params['named']['CategoriesId'], 'Field.field_key = ' => $this->params['named']['fieldKey'])));
			} elseif(isset($this->params['named']['CategoriesId'])  && !empty($this->params['named']['CategoriesId'])) {
				$field = $this->Field->find('first', array('conditions' => array('Field.Categories_id = ' => $this->params['named']['CategoriesId'])));
			} else {
				$field = NULL;
			}
				if(!empty($field)) {
					return $field['Field']['field_value'];
				} else { 
					return NULL;
				 }
	}
	
	
	
	
}
