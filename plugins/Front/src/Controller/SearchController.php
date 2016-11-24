<?php

namespace Front\Controller;

use Cake\Core\Configure;
use Front\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Controller\Component;
use Cake\Database\Type;
use Cake\I18n\I18n;


class SearchController extends AppController { 

    public $sidebarData;

    public $id;

 	public function initialize() {
        parent::initialize();

        $find = TableRegistry::get('Administrator.Categories');
        	
		
 	}

 	public $paginate = ['limit' => 1000];


 	function filtro(){
		    	$filtro=[];
		    	$llave=[];
				foreach( $this->request->query as $key => $value )
					{
						//Se filtra los resultados de la busqueda sacando asi los valores vacios y campos no necesario en Fields
					    if(!empty($value) and $key!='tons_since' and $key!='tons_until' and $key!='year_since' and $key!='year_until' and $key!='Category')
					    {
					    	array_push($filtro, $value);
					    	array_push($llave, $key);
					       //unset( $this->request->query[$key] );
					    }
					}
				
				//$filtro=array_combine($filtro);
					return $filtro;
				//echo pr($filtro);
	}	


	//vista principal del search
	public function index() {

	//STRING URL DE LAS VARIABLES DEL QUERY
	$slug = '?'.http_build_query($this->request->query) . "\n";
	$this->set('slug', $slug);


	$categories = TableRegistry::get('Administrator.Categories');
	$fields = TableRegistry::get('Administrator.Fields');
	$posts = TableRegistry::get('Administrator.Posts');


	    if($this->request->is('get')) {


	    $fieldsPosts = $fields->find('all', ['conditions' => ['type' => 'Post', 'sidebar' => 'yes'], 'fields' => ['id', 'option_value', 'option_key', 'option_label'] ] ); // filtro los campos por sidebar (con YES son los que deben apareceer)

        //crear un  array de llaves (campos personalizados y values vacios para los campos por defecto en el sidebar).
        $llavesSidebar = [];
        $valuesSidebar = [];

        foreach ($fieldsPosts as $key => $dato) {
            array_push($llavesSidebar, $dato['option_key']);
            if(isset($this->request->query[$dato['option_key']])) {
            	array_push($valuesSidebar, $this->request->query[$dato['option_key']]);
            } else {
            	array_push($valuesSidebar, '');
            }
        }

        $sides = array_combine($llavesSidebar, $valuesSidebar);
        
        if(isset($this->request->query['tons_since'])) {
        	//toneladas
        	$tonsSince = $this->request->query['tons_since'];
        	$tonsUntil = $this->request->query['tons_until']; 

        	//año
        	//$yearSince = $this->request->query['year_since'];
        	//$yearUntil = $this->request->query['year_until']; 

        	$yearSince = '';
        	$yearUntil = '';

        	$model = $this->request->query['model']; 

        	$catSide = $this->request->query['Category'];

        
        } else {

        	//toneladas
        	$tonsSince = '';
        	$tonsUntil = '';

        	//año
        	$yearSince = '';
        	$yearUntil = '';

        	//modelo
        	$model = '';

        	$catSide = "";

        }
        
        // datos se mandan estaticos al ser categories fuera del fields y toneladas por manejar el DESDE y HASTA.
        //$sidebar = array_merge($sides, ['Category' => $this->request->query['Category'], 'tons_since' => $tonsSince, 'tons_until' => $tonsUntil, 'year_since' => $yearSince, 'year_until' => $yearUntil, 'model' => $model ]); 
        $sidebar = array_merge($sides, ['Category' => $catSide, 'tons_since' => $tonsSince, 'tons_until' => $tonsUntil, 'model' => $model ]); 
        $this->set('sidebarData', $sidebar);


	    	//Validacion de campos para filtro
	    	
		    //funcion de filtro (buscar post por categoría)
			$query = $posts->find('all', ['conditions' =>['Posts.status' => $this->active, 'Posts.type' => 'Post'], 'group'=>'Posts.id'])->contain(['Categories', 'FieldsPosts']);
		   		
		   		$conteo=count($this->filtro());
		   		
		   		if(isset($this->request->query['Category']) && $this->request->query['Category'] != 0) { 

				   		$query->matching('Categories', function ($q) {
					  		 return $q->where(['Categories.id' => $this->request->query['Category']]);
					 	});

		   		}


				if($conteo >= 1) { 


							//Validacion de POST
					        $query->matching('FieldsPosts', function ($q) {
					        	    $category =$this->filtro();
					    	  		return $q->where(['FieldsPosts.value IN' => $category]);

					      	});

					        $query->having([
					                $posts->query()->newExpr('COUNT(DISTINCT FieldsPosts.value) = '.$conteo.'')
					        ]);
					        
			    
			    	
			    }
		   
		    
			$this->set('posts', $this->paginate($query));


		}


	}




	//vista como listado para las busquedas renderizando toda la funcion del index
	public function simple_search() {


			//STRING URL DE LAS VARIABLES DEL QUERY
			$slug = '?'.http_build_query($this->request->query) . "\n";
			$this->set('slug', $slug);

			$categories = TableRegistry::get('Administrator.Categories');
			$fields = TableRegistry::get('Administrator.Fields');
			$posts = TableRegistry::get('Administrator.Posts');

			//find de las categorias
			$findCats = $categories->find('all', ['conditions' => ['Categories.id !=' => $this->active, 'Categories.id !=' => 1, 'Categories.name LIKE' => '%'.$this->request->query['s'].'%']])->first();


					//crear el array de los posts por categorias y mezclarlos en uno solo
					if(!empty($findCats)) {

					$idCat = $findCats->id; 

							$postsByCat = $posts->find('all', ['conditions' => ['Posts.status' => $this->active, 'Posts.type' => 'Post']])
													->matching('Categories', function ($q) use ($idCat) {
															   return $q->where(['Categories.id' => $idCat]);
												    });

							$allPostsByCat = $postsByCat;

					}



			//find de las gruas por campos del mismo post
			$findPosts = $posts->find('all', ['conditions' => ['Posts.status' => $this->active]])
							   ->where(['name LIKE' => '%'.$this->request->query['s'].'%'])
							   ->orWhere(['description LIKE' => '%'.$this->request->query['s'].'%'])
							   ->AndWhere(['type' => 'Post'])
							   ->AndWhere(['status' => $this->active]);

			$countPost = $findPosts->count(); //conteo de los posts encontrados


			//find de los campos personalizados
			$findPostsFields = $posts->find('all', ['conditions' =>['Posts.status' => $this->active, 'Posts.type' => 'Post'], 'contain' => ['Fields']])
						   			 ->matching('FieldsPosts', function ($q) {
						   		   			return $q->where(['FieldsPosts.value LIKE' => '%'.$this->request->query['s'].'%']);
						   		   			//return $q->where(['FieldsPosts.value ' => '%'.$this->request->query['s'].'%']);
						   });


			$countFieldsPosts = $findPostsFields->count(); //conteo de los posts encontrados



			//definimos la variable $final aqui si las categorias existen y tienen posts
			if(isset($allPostsByCat) && !empty($allPostsByCat)) {

				//variable final para buscar posts por categorias
				$final = $this->paginate($allPostsByCat);
				//echo pr($allPostsByCat->toArray());

			//buscamos por posts 
			} elseif(isset($countFieldsPosts) && $countFieldsPosts > 0) {

				//variable final para buscar las gruas desde los posts
				$final = $this->paginate($findPostsFields);

			} else {
				
				//variable final para buscar las gruas por fieldsposts
				$final = $this->paginate($findPosts);

			}
			

			$this->set('posts', $final);
			
			$this->render('index');
		

	}


		

}
