<?php
/*
función para los enlaces personalizados
*/
namespace Front\Controller\Component;

use Cake\Controller\Component;
use Cake\ORM\TableRegistry;

class GetComponent extends Component {

/***************************
IMAGENES
***************************/

	/***** obtener url imagen destacada*********/		

	public function get_thumbnail_url($id = NULL, $size = NULL) {
		
		$archives = TableRegistry::get('Administrator.Archives');

		$archive = $archives->find('all', ['conditions' => ['Archives.id' => $id]])->first();
		
		//validar si existe el archivo y si no esta vacio (evita errores).
		if(isset($archive->filename) && !empty($archive->filename)) {
				// tamaño mediano de la imagen
				if($size == 'medium' || $size == 'thumbnail') {
						return ['full' => $archive->folder.$archive->filename, 'medium' => $archive->folder."medium-".$archive->filename];			
				} else {
				//tamaño completo de la imagen
					return ['full' => $archive->folder.$archive->filename, 'medium' => NULL];			
				} 
		} else { 
				return NULL; 
		}

		
	}

	/*****fin obtener url imagen destacada*********/	


	/***** obtener todas las imagenes *********/	


	public function get_all_archives() {
			
			$archives = TableRegistry::get('Administrator.Archives');

			$imagesConditions = [ 'AND' => [
									            [
											        'OR' => [
												                ['mimetype' => 'image/png'],
												                ['mimetype' => 'image/jpeg'],
												                ['mimetype' => 'image/jpg'],
												                ['mimetype' => 'image/gif'],
												                ['mimetype' => 'application/stream'],
									            			]
									        	],
									        
									    	]
								];


			//$this->set('images', $archives->find('all', ['conditions' => $imagesConditions]) );
			return $archives->find('all', ['conditions' => $imagesConditions]);

	}

	/************* logo y favicon ******************/

	public function get_frontend_images_url($image) {	// puede recibir las variables logo y favicon (con minusculas como esta en la DB)
	$archives = TableRegistry::get('Archives');
    $generals = TableRegistry::get('Generals');
    	
    	//validar la variable que recibimos de logo o favicon
    	if(!empty($image) || $image == 'logo' || $image == 'favicon') {
	            
	            $file = $generals->findByOptionKeyAndType($image, 'Frontend')->first();
	            $id = $file->option_value;
                $imageLogo = $archives->find('all', ['conditions' => ['id' => $id] ] )->first();

                if(!empty($file) && !empty($imageLogo->filename) && file_exists($imageLogo->folder.$imageLogo->filename)) { 
                	return $imageLogo->folder.$imageLogo->filename;
                } else {
                   return '/img/'.$image.'.png';
                }



        } else {
        		return NULL;
        }

    }
    


	/***** fin obtener todas las imagenes *********/	


/***************************
CATEGORIAS
***************************/


	public function get_all_categories($recursive, $excludeid = NULL) {
			
			$categories = TableRegistry::get('Administrator.Categories');

			if(isset($recursive)) { $categories->recursive = $recursive; }
			$all_categories_actives = $categories->find('all', ['conditions' => ['status' => 'active', 'id !=' => $excludeid], 'fields' => ['id', 'name', 'description', 'archive_id', 'slug', 'type'] ])->toArray();

			return $all_categories_actives;

	}


	public function get_categories_by_parent($parent, $exclude = NULL) {
			$categories = TableRegistry::get('Administrator.Categories');

			if(isset($recursive)) { $categories->recursive = $recursive; }
			$all_categories_actives = $categories->find('all', ['conditions' => ['parent_id' => $parent, 'status' => 'active'], 'fields' => ['id', 'name', 'description', 'archive_id', 'slug', 'type'] ])->toArray();

			return $all_categories_actives;

	}

	//obtener las categorias de un post $total puede ser 1 o varias, dependiendo si existe o no
	public function get_categories_by_post_id($postid, $totalCats = NULL, $excludeId = NULL) {
			$posts = TableRegistry::get('Administrator.Posts');
			$categories = TableRegistry::get('Administrator.Categories');

			if(isset($excludeid) && !empty($excludeid)) {
				$getPost = $posts->get($postid, ['contain' => ['Categories' => ['conditions' => ['Categories.id != ' => $excludeid] ] ]]);
			} else {
				$getPost = $posts->get($postid, ['contain' => ['Categories']]);
			}

			if(!empty($getPost)) {
					if($totalCats == 1) { 
						return $getPost->categories[0];
					} else {
						return $getPost->categories;
					}
			} else {
				 return NULL;
			}

	}


/**********************
POSTS
***********************/

/*** get post by custom fields (Fieldsposts) *****/

   
    public function get_field_by_post_id($id, $key) {
        
        if(isset($id) && !empty($id) && isset($key) && !empty($key)) {
              
              $fieldsPosts = TableRegistry::get('Administrator.FieldsPosts');
              $fields = TableRegistry::get('Administrator.Fields');

              $campo = $fields->find('all', ['conditions' => ['Fields.option_key' => $key, 'Fields.type' => 'Post']])->first();
              $postValue = $fieldsPosts->find('all', ['conditions' => ['FieldsPosts.field_id' => $campo->id, 'FieldsPosts.post_id' => $id]])->first();
                   
              if(isset($postValue) && !empty($postValue) && !empty($campo)  && !empty($campo)) { 
                  return $postValue->value;
              } else {
                return NULL;
              }
        }
                   
    }



/***************************
PAGINAS
***************************/

	public function get_page_by_location($location, $order) {
			$pages = TableRegistry::get('Administrator.Posts');

			if(isset($pages) && !empty($pages)) { 
			$page = $pages->find('all', ['conditions' => ['Posts.type' => 'Page', 'Posts.status' => 'active', 'Posts.location' => $location], 'fields' => ['id', 'name', 'description', 'archive_id', 'slug', 'type'] ])->order($order)->first();

			return $page;

			}
	}



/**********************
USUARIOS
***********************/

    // obtener el enlace de las paginas, categorias post etc por id y por controlador
    public function get_name($id, $type) {

        
        if(isset($type) && !empty($type) && isset($id) && !empty($id)) {
              
              if($type == 'Pages' || $type == 'pages') { $tipo = 'Posts'; } else { $tipo = $type; } //valodar si es una pagina y cambiar el controlador de page a posts para ecnontrarlo en posts.
              $find = TableRegistry::get('Administrator.'.$tipo);
       
              //funcion de filtro (buscar post por categoría)
              //$object = $find->get($id);
              $object = $find->find('all', ['conditions' => [$tipo.'.id' => $id]])->first();
              return $object->name;

        } else {
           return NULL;
        } 
                   
    }


    public function get_user_email($id) {
    $users = TableRegistry::get('Administrator.Users');

        if(isset($id) && !empty($id)) {
        $user = $users->get($id);
              if(!empty($user->company_email)) {
                  return $user->company_email;
              } else {
                  return $user->email;
              }
        } else {
          return NULL;
        }

    }


/**********************
obtener latitud y longitud
***********************/

public function get_lat($address){


		    //$address = str_replace(" ", "+", $address);

		    $json = file_get_contents("http://maps.google.com/maps/api/geocode/json?address=".$address."&sensor=false");
		    $json = json_decode($json, true);

		    //$lat = @$json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'}; 
		    $lat = $json['results'][0]['geometry']['location']['lat'];


    return $lat;
}


public function get_long($address) {

		    $address1 = str_replace(" ", "+", $address);
		    $direccion = str_replace(",", "", $address1);

		    $json = file_get_contents("http://maps.google.com/maps/api/geocode/json?address=".$direccion."&sensor=false");
		    $json = json_decode($json, true);

		    //$long = @$json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};
		    $long = $json['results'][0]['location']['lng'];

    return $long;
}


/**********************
get company name
***********************/

    public function get_company_name($id) {
    $users = TableRegistry::get('Administrator.Users');

        if(isset($id) && !empty($id)) {
        $user = $users->get($id);
              if(!empty($user->company_name)) {
                  return $user->company_name;
              } else {
                  return $user->name;
              }
        } else {
          return NULL;
        }

    }


    public function get_company_tel($id) {
    $users = TableRegistry::get('Administrator.Users');

        if(isset($id) && !empty($id)) {
        $user = $users->get($id);
              if(!empty($user->company_tel)) {
                  return $user->company_tel;
              } else {
                  return $user->tel;
              }
        } else {
          return NULL;
        }

    }


    
    

/**********************
get links with translate
***********************/


    // funciona para todos los enlaces directos, no llama el id de una entrada especifica, llama el controlador y la acción
    public function get_url_translate($controller, $action = NULL, $identificator = NULL) {
    $generals = TableRegistry::get('Administrator.Generals');
    $model = $generals->find('all', ['conditions' => ['option_key' => $controller, 'type' => 'Routes']])->first();


              if(isset($action) && !empty($action)) {

                  //generar el prefijo 
                  $prefijo = $model->option_value;


                  if(!isset($this->request->params['language'])){
                          
                          $link = 'http://'.$_SERVER['HTTP_HOST'].$prefijo."/".$action;

                          if(isset($identificator) && !empty($identificator)) {
                              
                              return $link.'/'.$identificator;

                          } else {

                              return $link;

                          }
                  
                  } else {

                      $link = 'http://'.$_SERVER['HTTP_HOST'].'/'.$this->request->params['language']."/".$prefijo."/".$action;

                      	if($action == 'offer' && $controller == 'Posts') {

                      					return 'http://'.$_SERVER['HTTP_HOST'].$this->request->params['language'].'/popup/'.$identificator;

                      	} else {

				                        if(isset($identificator) && !empty($identificator)) {
				                              
				                              return $link.'/'.$identificator;

				                        } else {

				                              return $link;

				                        }
				        }


                  }

                   
              } else {

                  //return $this->Url->build('/', true)."/Front/".$action.'/'.$identificator;
                  return ['controller' => $controller];

              } 
                   
    }



/**********************
get links with translate
***********************/


    // funciona para todos los enlaces directos, no llama el id de una entrada especifica, llama el controlador y la acción
    public function get_url_translate_popup($id) {
    
    //link generado desde el routes.
    $popup = '/popup/';

                  if(isset($this->request->params['language'])){
                          
                          $lang = $this->request->params['language'];
                          $link = 'http://'.$_SERVER['HTTP_HOST'].$lang.$popup.$id;
                          return $link;

                  } else {

                    $link = 'http://'.$_SERVER['HTTP_HOST'].$popup.$id;
                    return $link;

                  }            
    }





}

?>