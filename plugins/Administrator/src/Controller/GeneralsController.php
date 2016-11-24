<?php
namespace Administrator\Controller;

use Administrator\Controller\AppController;

use Cake\Core\Configure;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\ORM\TableRegistry;
use Cake\I18n\I18n;
use Cake\Controller\Component;


class GeneralsController extends AppController {

    public $extras; //variable publica extras para los textos

	public function beforeFilter(\Cake\Event\Event $event) {
    parent::beforeFilter($event);

	    //todas las categorías
		$categories = $this->Get->get_list_categories();
		$posts = $this->Get->get_list_posts();
		$pages = $this->Get->get_list_pages();

		//listar posts, pages y categorias para el menú en Generals / appearence
		$contents = ['Categories' => $categories, 'Posts' => $posts, 'Pages' => $pages];
		$this->set('contents', $contents); 

	    $textos = $this->Texts->text($this->request->params['controller'], $this->request->params['action']);
	    $this->extras = $textos['Extras'];  

    }


	//pagina principal 
	public function index() {
	$gadgets = TableRegistry::get('Administrator.Gadgets');

		//datos por tipo = General con campos especificos
		$datoGeneral = $this->Generals->find('all',['conditions' => ['type' => 'General'], 'fields' => ['id', 'option_key', 'option_value', 'type']])->toArray(); 
		$this->set('generals', $datoGeneral);

		$routes = $this->Generals->find('all',['conditions' => ['type' => 'Routes']])->toArray(); 
		$this->set('routes', $routes);

		//llamamos todos las funciones personalizadas desde este punto (GADGETS ADMINISTRABLES DESDE EL GENERALS)
		$customs = $this->Generals->find('all',['conditions' => ['type' => 'Customs']])->toArray(); 
		$this->set('gadgets', $customs);

		//LISTAMOS TODOS LOS GADGETS ACTIVOS PARA PODER SELECCIONARLOS
		$gadgetsList = $gadgets->find('list',['conditions' => ['Gadgets.status' => 'active']]); 
		$this->set('gadgetsList', $gadgetsList);
		
		//POST		
		if($this->request->is('post')) {

				
				//guardar opciones generales
				if(isset($this->request->data['general']) && !empty($this->request->data['general'])) {
					foreach ($this->request->data['general'] as $key => $dato) {
						$data = $this->Generals->findByOptionKey($key)->first();
						$save = $this->Generals->patchEntity($data, ['option_value' => $dato]);            
					    $this->Generals->save($save);
					}
				}


				// COLORES PERSONALIZABLES DE LA WEB.
				$colores = 'backend_colors';
				$colors = $this->Generals->findByOptionKey($colores)->first();
				$defaultColors = '["4b4b4b","00afdc","adc22e","b6b7b6","FFFFFF"]';

				if(isset($this->request->data['colors']) && !empty($this->request->data['colors'])) {
					$color = json_encode($this->request->data['colors']);
					$saveColors = $this->Generals->patchEntity($colors, ['option_value' => $color]);            
					$this->Generals->save($saveColors);
				}

				if(isset($this->request->data['restart_colors'])) {
					$saveReset = $this->Generals->patchEntity($colors, ['option_value' => $defaultColors]);            
					$this->Generals->save($saveReset);
				}

				$this->Flash->exito(__d('administrator', 'Los datos se han actualizado correctamente.'));
				$this->redirect(array('action' => 'index'));


				echo pr($this->request->data);
						
		}

		
	}


//apariencia web
	public function appearance() { 

    //datos por tipo = General con campos especificos
	$datoGeneral = $this->Generals->find('all',['conditions' => ['type' => 'General'], 'fields' => ['id', 'option_key', 'option_value', 'type']])->toArray(); 
	$this->set('generals', $datoGeneral);

    $frontDefaultColors = '["ffffff","ffcc00","444444","212121"]';

    $main = $this->Generals->findByOptionKeyAndType('frontend_main', 'Menus')->first();
    $this->set('main', json_decode($main->option_value, true));

    $main_about_us = $this->Generals->findByOptionKeyAndType('main_about_us', 'Menus')->first();
    $this->set('main_about_us', json_decode($main_about_us->option_value, true));

    $main_services = $this->Generals->findByOptionKeyAndType('main_services', 'Menus')->first();
    $this->set('main_services', json_decode($main_services->option_value, true));

    $main_members = $this->Generals->findByOptionKeyAndType('main_members', 'Menus')->first();
    $this->set('main_members', json_decode($main_members->option_value, true));

    //echo pr($this->Generals->find('all')->toArray());
    //echo "";
    //echo (json_decode($main_members->option_value, true));


    $menus = ['frontend_main' => json_decode($main->option_value, true), 'main_about_us' => json_decode($main_about_us->option_value, true), 'main_services' => json_decode($main_services->option_value, true), 'main_members' => json_decode($main_members->option_value, true)];
    $this->set('menus', $menus);

		    //POST		
			if($this->request->is('post')) {


				//guardar menu
				if(isset($this->request->data['general']) && !empty($this->request->data['general'])) {
					foreach ($this->request->data['general'] as $key => $dato) {
						$data = $this->Generals->findByOptionKey($key)->first();
						$save = $this->Generals->patchEntity($data, ['option_value' => $dato]);            
					    $this->Generals->save($save);
					}
				}

				// COLORES PERSONALIZABLES DE LA WEB.
				$colores = 'frontend_colors';
				$colors = $this->Generals->findByOptionKey($colores)->first();

				if(isset($this->request->data['colors']) && !empty($this->request->data['colors'])) {
					$color = json_encode($this->request->data['colors']);
					$saveColors = $this->Generals->patchEntity($colors, ['option_value' => $color]);            
					$this->Generals->save($saveColors);
				}

				if(isset($this->request->data['restart_colors'])) {
					$saveReset = $this->Generals->patchEntity($colors, ['option_value' => $frontDefaultColors]);            
					$this->Generals->save($saveReset);
				}

				$this->Flash->exito(__d('administrator', 'Los datos se han actualizado correctamente.'));
				$this->redirect(['action' => '']);


			}

	}
	
	
	
	public function custom_fields() { 
								    	
	$this->loadModel('Administrator.Fields');

    //datos generales buscando todos los campos personalizados q tengan el tipo post, page o term.
	$datoGeneral = $this->Generals->find('all')->toArray();
																											
	//obtengo los campos personalizados para post, 																															
	$this->set('datoGeneral', $datoGeneral);
	
	//variable de opciones
	$inputTypes = ['text' => 'Caja de texto', 'textarea' => 'Editor de texto', 'select' => 'Selector', 'checkbox' => 'Checkbox ', 'radio' => 'Radio', 'number' => 'Numérico', 'password' => 'Contraseña', 'email' => 'E-mail', 'date' => 'Fecha', 'file' => 'Archivo', 'tel' => 'Teléfono'];
	$this->set(compact('inputTypes'));


	$location = ['technical_specifications' => $this->extras['technical_specifications'], 'crane_structure' => $this->extras['crane_structure'], 'truck_structure' => $this->extras['truck_structure'], 'other' => $this->extras['other']];
	$this->set(compact('location'));


	//variables del tipo de objeto q se esta editando (categorias paginas publicaciones).
	$customFields = array('Category' => 'categories', 'Post' => 'posts', 'Page' => 'pages');
	$this->set(compact('customFields'));
						
			//enviar campos tipo POST	
			if($this->request->is('post')) {

				//guardar nuevos campos personalizables
				if(isset($this->request->data['custom']) && !empty($this->request->data['custom'])) {
					foreach ($this->request->data['custom'] as $key => $dato) {

						if(!empty($dato['option_key'])) {
							$json = json_encode(['input' => $dato['input'], 'placeholder' => $dato['placeholder'], 'options' => $dato['options']]);

							$data = $this->Fields->newEntity();
							$save = $this->Fields->patchEntity($data, ['option_key' => $dato['option_key'], 'option_label' => $dato['option_label'], 'type' => $key, 'option_value' => $json]);            
					    	$this->Fields->save($save);

					    	$this->Flash->exito(__d('administrator', 'El campo se ha generado correctamente.'));
							$this->redirect(['action' => '']);

						}


					}
				}

				//actualizar campos personalizables
				if(isset($this->request->data['fields']) && !empty($this->request->data['fields'])) {
					foreach ($this->request->data['fields'] as $id => $field) {

						$json = json_encode(['input' => $field['input'], 'placeholder' => $field['placeholder'], 'options' => $field['options']]);

						$fieldEdit = $this->Fields->get($id);
						$save = $this->Fields->patchEntity($fieldEdit, ['option_value' => $json, 'option_label' => $field['option_label']]);            
					    $this->Fields->save($save);
					    
					}

					$this->Flash->exito(__d('administrator', 'Los campos se han actualizado correctamente.'));
					$this->redirect(['action' => '']);

				}

				  
			}
	
		
	}



	//pagina principal 
	public function newsletter() {
	$newsletters = TableRegistry::get('Administrator.Newsletters');

		//datos por tipo = General con campos especificos
		$registrados = $newsletters->find('all',['conditions' => ['status' => $this->active]]); 
		
		$this->set('newsletters', $this->paginate($registrados));


				if($this->request->is('post')) {

		            if($this->request->data['checkbox']) {
		                 
		                foreach($this->request->data['checkbox'] as $userID) {
		                    //$this->Users->id = $userID;
		                   $data=['status' => 'inactive'];
		                   $dato = $newsletters->get($userID);
		                   $user = $newsletters->patchEntity($dato, $data);            
		                   $newsletters->save($user);
		                }
		                
		                $this->Flash->exito(__d('administrator', 'Registros actualizados con éxito.'));
		                $this->redirect(['action' => 'newsletter']);
		                
		            }
		        
		        }

		
	}




	
}
