<?php
/*
función para los enlaces personalizados
*/
namespace Administrator\Controller\Component;

use Cake\Controller\Component;
use Cake\ORM\TableRegistry;

class GetComponent extends Component {

/***************************
IMAGENES
***************************/

	public $active = 'active';

	/***** obtener url imagen destacada*********/		

	public function get_thumbnail_url($id = NULL, $size = NULL) {
		
		$archives = TableRegistry::get('Administrator.Archives');

		$archive = $archives->find('all', ['conditions' => ['Archives.id' => $id]])->first();
		
		//validar si existe el archivo y si no esta vacio (evita errores).
		if(isset($archive->filename) && !empty($archive->filename)) {
		
				// tamaño mediano de la imagen
				if(file_exists($archive->folder."medium-".$archive->filename) && $size == 'medium' || $size == 'thumbnail') {
						return "/".$archive->folder."medium-".$archive->filename;			
				} else {
				//tamaño completo de la imagen
					return "/".$archive->folder.$archive->filename;			
				} 
		
		} else { 

				return NULL; 
		}

		
	}

	/*****fin obtener url imagen destacada*********/	



	 public function get_user_email($id) {
    $users = TableRegistry::get('Administrator.Users');

        if(isset($id) && !empty($id)) {
        $user = $users->get($id);
              if(!empty($user->email)) {
                  return $user->email;
              } else {
                  return NULL;
              }
        } else {
          return NULL;
        }

    }


	 public function get_company_email($id) {
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
												                ['mimetype' => 'application/pdf'],
									            			]
									        	],
									        
									    	]
								];


			//$this->set('images', $archives->find('all', ['conditions' => $imagesConditions]) );
			return $archives->find('all', ['conditions' => $imagesConditions, 'order' => ['id' => 'DESC'] ]);

	}

	/************* logo y favicon ******************/

	public function get_frontend_images_url($image) {	// puede recibir las variables logo y favicon (con minusculas como esta en la DB)
	$archives = TableRegistry::get('Administrator.Archives');
    $generals = TableRegistry::get('Administrator.Generals');
    	
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

	public function get_list_categories() {
			$categories = TableRegistry::get('Administrator.Categories');
			$all = $categories->find('treeList', ['conditions' => ['type' => 'Category', 'status' => $this->active], 'spacer' => '— '])->toArray();
			return $all;
	}


/***************************
POSTS
***************************/

	public function get_list_posts() {
			$posts = TableRegistry::get('Administrator.Posts');
			$all = $posts->find('list',['conditions' => ['type' => 'Post', 'status' => $this->active], 'fields' => ['id', 'name']])->toArray(); 
			return $all;

	}


/***************************
PAGES
***************************/

	public function get_list_pages() {
			$posts = TableRegistry::get('Administrator.Posts');
			$all = $posts->find('list',['conditions' => ['type' => 'Page', 'status' => $this->active], 'fields' => ['id', 'name']])->toArray(); 
			return $all;

	}

	public  function url_exists( $url = NULL ) { 

		if( empty( $url ) ){ return false; } 
    	
    	$options['http'] = array( 'method' => "HEAD", 'ignore_errors' => 1, 'max_redirects' => 0 ); 
    	$body = @file_get_contents( $url, NULL, stream_context_create( $options ) ); 
    
        // Ver http://php.net/manual/es/reserved.variables.httpresponseheader.php 
        if( isset( $http_response_header ) ) { sscanf( $http_response_header[0], 'HTTP/%*d.%*d %d', $httpcode ); 
        //Aceptar solo respuesta 200 (Ok), 301 (redirección permanente) o 302 (redirección temporal) 
        $accepted_response = array( 200, 301, 302 ); 

            if( in_array( $httpcode, $accepted_response ) ) { 
                return "okok";
            } else {
               return "falso"; 
            } 

        } else { 
          return "false"; 
        } 
  
  }



}

?>