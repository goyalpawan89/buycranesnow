<?php
/* src/View/Helper/LinkHelper.php */
namespace Front\View\Helper;

use Cake\View\Helper;
use Cake\Controller\Component;
use Cake\ORM\TableRegistry;

class GetHelper extends Helper {

//importar helpers a mi helper creado
public $helpers = ['Url', 'Html', 'Form'];


/**********************
get the content 
***********************/

    // imagenes chekeadas en la galería dependiendo del id
    public function get_excerpt($id, $limit) {
    $posts = TableRegistry::get('Administrator.Posts');
        
              //funcion de filtro (buscar post por categoría)
              $post = $posts->get($id);

              if(isset($post) && !empty($post)) {
                 if(!empty($post->excerpt)) {
                    return $post->excerpt;
                 } elseif(!empty($post->description)) { 
                   $str = strip_tags($post->description); 
                   return substr($str, 0, $limit) . '...';
                 }
              }
                   
    }


/**********************
get link
***********************/


    // obtener el enlace de las paginas, categorias post etc por id y por controlador
    public function get_link($id, $type = NULL) {

        
        if(isset($type) && !empty($type) && isset($id) && !empty($id)) {
              
              if($type == 'Pages' || $type == 'pages') { $controller = 'Posts'; } else { $controller = $type; } //valodar si es una pagina y cambiar el controlador de page a posts para ecnontrarlo en posts.

              $findLink =     TableRegistry::get('Administrator.'.$controller);
              $generals = TableRegistry::get('Administrator.Generals');
              $model = $generals->find('all', ['conditions' => ['option_key' => $type, 'type' => 'Routes']])->first();
        
              //funcion de filtro (buscar post por categoría)
              $search = $findLink->find('all', ['conditions' => [$controller.'.id' => $id] ])->first();

              if(isset($search) && !empty($search)) {
                 if(!empty($search->slug)) {
                    if(!empty($model->option_value)) { $prefijo = $model->option_value; } else { $prefijo = $model->option_key; }

                    if(!isset($this->request->params['language'])){
                      return $this->Url->build('/', true).$prefijo."/".$search->slug;
                    }else{
                      return $this->Url->build('/', true).$this->request->params['language']."/".$prefijo."/".$search->slug;  
                    }
                    
                 } else {
                   return NULL;
                 }
              
              } else {
                 return NULL;
              } 
        }
                   
    }



/**********************
get links with translate
***********************/


    // funciona para todos los enlaces directos, no llama el id de una entrada especifica, llama el controlador y la acción
    public function get_url_translate($controller, $action = NULL, $identificator = NULL) {
    $generals = TableRegistry::get('Administrator.Generals');
    $model = $generals->find('all', ['conditions' => ['option_key' => $controller, 'type' => 'Routes']])->first();


              if(isset($model) && !empty($model)) {

                  //generar el prefijo 
                  $prefijo = $model->option_value;


                  if(!isset($this->request->params['language'])){
                          
                          $link = $this->Url->build('/', true).$prefijo."/".$action;

                          if(isset($identificator) && !empty($identificator)) {
                              
                              return $link.'/'.$identificator;

                          } else {

                              return $link;

                          }
                  
                  } else {

                      $link = $this->Url->build('/', true).$this->request->params['language']."/".$prefijo."/".$action;

                        if(isset($identificator) && !empty($identificator)) {
                              
                              return $link.'/'.$identificator;

                        } else {

                              return $link;

                        }

                  }

                   
              } else {

                  //return $this->Url->build('/', true)."/Front/".$action.'/'.$identificator;
                  return ['controller' => $controller, 'action' => $action];

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
                          $link = $this->Url->build('/', true).$lang.$popup.$id;
                          return $link;

                  } else {

                    $link = $this->Url->build('/', true).$popup.$id;
                    return $link;

                  }            
    }



    // routes para los mapas en popup
    public function get_url_translate_map($id) {
    
    //link generado desde el routes.
    $popup = '/map/';

                  if(isset($this->request->params['language'])){
                          
                          $lang = $this->request->params['language'];
                          $link = $this->Url->build('/', true).$lang.$popup.$id;
                          return $link;

                  } else {

                    $link = $this->Url->build('/', true).$popup.$id;
                    return $link;

                  }            
    }


    // rotes para el simple search
    public function get_url_translate_simple_search() {
    
    //link generado desde el routes.
    $simple = 'simple_search';

                  if(isset($this->request->params['language'])){
                          
                          $lang = $this->request->params['language'];
                          $link = $this->Url->build('/', true).$lang."/".$simple;
                          return $link;

                  } else {

                    $link = $this->Url->build('/', true).$simple;
                    return $link;

                  }            
    }


/**********************
get routes
***********************/

    // crear enlaces a parttir del tipo de router de generals
    public function get_routes($type, $action = NULL) {

        
        if(isset($type) && !empty($type)) {
              
              $generals = TableRegistry::get('Administrator.Generals');
              $model = $generals->find('all', ['conditions' => ['option_key' => $type, 'type' => 'Routes']])->first();
              
              if (!empty($action)) {
                  return '/'.$model->option_value.'/'.$action;
              } else {
                  return '/'.$model->option_value;
              }
              
        } else {
           return NULL;
        }
                   
    }

/**********************
get language link
***********************/


    public function get_language_link($language) {
          if(isset($this->request->pass['0']) && !empty($this->request->pass['0'])) {
              if($this->request->params['controller'] != 'Front') {
                  $generals = TableRegistry::get('Administrator.Generals');
                  $model = $generals->find('all', ['conditions' => ['option_key' => $this->request->params['controller'], 'type' => 'Routes']])->first();
                  return $this->Url->build('/', true).$language.'/'.$model->option_value.'/'.$this->request->pass[0];
              } else {
                  return $this->Url->build('/', true).$language;
              }
          } else {

            
                return $this->Url->build('/', true).$language;
          }

    }


/**********************
get favorite crane by post id
***********************/


    public function get_favorite_by_post_id($postId, $userId) {

    $postsUsers = TableRegistry::get('Administrator.PostsUsers'); 
         
          $favorite = $postsUsers->find('all', ['conditions' => ['PostsUsers.post_id' => $postId, 'PostsUsers.user_id' => $userId] ])->count();
          
          if(isset($userId) && !empty($userId) && isset($favorite) && !empty($favorite)) {
            return $favorite;
          } else {
            return NULL;
          }

    }



/**********************
get user name
***********************/


    public function get_user_name($id) {
    $users = TableRegistry::get('Administrator.Users');
      
          if(isset($id) && !empty($id)) {
                    $user = $users->get($id);
                    if(!empty($user->last_name)) { 
                        return $user->name.' '.$user->last_name; 
                    } else {
                        return $user->name;
                    }
                }

    }


/**********************
get user data
***********************/


    public function get_user_data($id, $data) {
    $users = TableRegistry::get('Administrator.Users');
      
          if(isset($id) && !empty($id) && isset($data) && !empty($data)) {
                    $user = $users->get($id);
                    if(!empty($user->$data)) { 
                        return $user->$data; 
                    } else {
                        return NULL;
                    }
                }

    }




/**********************
get name
***********************/

    // obtener el enlace de las paginas, categorias post etc por id y por controlador
    public function get_name($id, $type) {

        
        if(isset($type) && !empty($type) && isset($id) && !empty($id)) {
              
              if($type == 'Pages' || $type == 'pages') { $tipo = 'Posts'; } else { $tipo = $type; } //valodar si es una pagina y cambiar el controlador de page a posts para ecnontrarlo en posts.
              $find = TableRegistry::get('Administrator.'.$tipo);
       
              //funcion de filtro (buscar post por categoría)
              //$object = $find->get($id);
              $object = $find->find('all', ['conditions' => [$tipo.'.id' => $id]])->first();

              if($object && !empty($object)) {
                return $object->name;
              } else {
                return NULL;
              }

        } else {
           return NULL;
        } 
                   
    }


/**********************
get content
***********************/

    // obtener el enlace de las paginas, categorias post etc por id y por controlador
    public function get_content($id, $type) {

        
        if(isset($type) && !empty($type) && isset($id) && !empty($id)) {
              
              if($type == 'Pages' || $type == 'pages') { $tipo = 'Posts'; } else { $tipo = $type; } //valodar si es una pagina y cambiar el controlador de page a posts para ecnontrarlo en posts.
              $find = TableRegistry::get('Administrator.'.$tipo);
       
              //funcion de filtro (buscar post por categoría)
              //$object = $find->get($id);
              $object = $find->find('all', ['conditions' => [$tipo.'.id' => $id]])->first();

              if($object && !empty($object)) {
                return $object->description;
              } else {
                return NULL;
              }

        } else {
           return NULL;
        } 
                   
    }




/***************************
CATEGORIAS
***************************/

  public function get_list_categories() {
      $categories = TableRegistry::get('Administrator.Categories');
      $all = $categories->find('treeList', ['conditions' => ['type' => 'Category', 'status' => 'active', 'parent_id' => 1], 'spacer' => '— '])->toArray();
      return $all;
  }


/***************************
PAISES
***************************/


  public function get_all_countries() {
      $countries = TableRegistry::get('Administrator.Countries');
      $all = $countries->find('list', ['conditions' => ['keyField' => 'name', 'valueField' => 'name']])->toArray();
      return $all;
  }


  public function get_country_by_id($id) {
      $countries = TableRegistry::get('Administrator.Countries');
      $pais = $countries->find('all', ['conditions' => ['Countries.id' => $id], 'fields' => ['name'] ])->first();
        
        if(isset($id) && !empty($pais)) {
          return $pais->name;
        } else {
           return NULL;
        }
  }


/***************************
CIUDADES
***************************/

  public function get_city_by_id($id) {
      $cities = TableRegistry::get('Administrator.Cities');
      $ciudad = $cities->find('all', ['conditions' => ['Cities.id' => $id], 'fields' => ['name'] ])->first();
      
        if(isset($id) && !empty($ciudad)) {
          return $ciudad->name;
        } else {
           return NULL;
        }
  }


/***************************
conteo de posts por usuarios
***************************/

  public function get_total_posts_count($id) {
      $posts = TableRegistry::get('Administrator.Posts');
      $count = $posts->find('all', ['conditions' => ['Posts.user_id' => $id, 'status' => 'active']])->count();
      
      if(isset($count) && !empty($count)) {
        return $count;
      } else {
        return 0;
      }

  }


/**********************
get all custom fields post
***********************/

   // obtener el enlace de las paginas, categorias post etc por id y por controlador
    public function get_field_by_post_id($id, $key) {
        
        if(isset($id) && !empty($id) && isset($key) && !empty($key)) {
              
              $fieldsPosts = TableRegistry::get('Administrator.FieldsPosts');
              $fields = TableRegistry::get('Administrator.Fields');

              $campo = $fields->find('all', ['conditions' => ['Fields.option_key' => $key, 'Fields.type' => 'Post']])->first();
              $postValue = $fieldsPosts->find('all', ['conditions' => ['FieldsPosts.post_id' => $id, 'FieldsPosts.field_id' => $campo->id]])->first();
                   
              if(isset($postValue) && !empty($postValue) && !empty($campo)  && !empty($campo)) { 
                  return $postValue->value;
              } else {
                return NULL;
              }
        
        } else {
          
          return NULL;

        }

                   
    }

    // obtener el enlace de las paginas, categorias post etc por id y por controlador
    public function get_field_by_page_id($id, $key) {
        
        if(isset($id) && !empty($id) && isset($key) && !empty($key)) {
              
              $fieldsPosts = TableRegistry::get('Administrator.FieldsPosts');
              $fields = TableRegistry::get('Administrator.Fields');

              $campo = $fields->find('all', ['conditions' => ['Fields.option_key' => $key, 'Fields.type' => 'Page']])->first();
              $postValue = $fieldsPosts->find('all', ['conditions' => ['FieldsPosts.field_id' => $campo->id, 'FieldsPosts.post_id' => $id]])->first();
                   
              if(isset($postValue) && !empty($postValue) && !empty($campo)  && !empty($campo)) { 
                  return $postValue->value;
              } else {
                return NULL;
              }
        }
                   
    }


/**********************
get breadcrumb
***********************/

    // obtener el enlace de las paginas, categorias post etc por id y por controlador
    public function get_breadcrumb($id, $separador = NULL) {
    $find = TableRegistry::get('Administrator.Posts');
    $categories = TableRegistry::get('Administrator.Categories');

        if(isset($id) && !empty($id)) {
        
        $content = $find->find('all', ['conditions' => ['Posts.id' => $id]])->contain(['Categories'])->first();
        $generals = TableRegistry::get('Administrator.Generals');
        $model = $generals->find('all', ['conditions' => ['option_key' => 'Categories', 'type' => 'Routes']])->first();

        $this->Html->addCrumb('Home', ['controller' => 'Front', 'action' => 'index'], ['class' => 'color3 colorh2']);

        if(!empty($model->option_value)) { $prefijo = $model->option_value; } else { $prefijo = $model->option_key; }

        foreach ($content->categories as $category) {

          $object = $categories->find('all', ['conditions' => ['Categories.id' => $category->id]])->first();
          $this->Html->addCrumb($object->name, "/".$prefijo."/".$category->slug, ['class' => 'color3 colorh2']);  
        }

        $this->Html->addCrumb($content->name, '', ['class' => 'color2']);
              
              if(isset($separador) && !empty($separador)) { $cosito = $separador; } else { $cosito =  ' » '; }
              return $this->Html->getCrumbs($cosito);

        }
                   
    }



/**********************
get breadcrumb
***********************/

    // obtener el enlace de las paginas, categorias post etc por id y por controlador
    public function get_categories_by_post($id) {
    $find = TableRegistry::get('Administrator.Posts');
    $categories = TableRegistry::get('Administrator.Categories');

        if(isset($id) && !empty($id)) {
        
        $content = $find->find('all', ['conditions' => ['Posts.id' => $id]])->contain(['Categories'])->first();
        $generals = TableRegistry::get('Administrator.Generals');
        $model = $generals->find('all', ['conditions' => ['option_key' => 'Categories', 'type' => 'Routes']])->first();

            if(!empty($model->option_value)) { $prefijo = $model->option_value; } else { $prefijo = $model->option_key; }

            $cats = [];

            foreach ($content->categories as $key => $category) {

              $object = $categories->find('all', ['conditions' => ['Categories.id' => $category->id]])->first();
              $cats[$key] = $object->name;  
            
            }

            return implode(", ", $cats);

        }

       
                   
    }



/**********************
get alquiler category
***********************/   

    public function get_cat_avalible($postID) {
    $posts = TableRegistry::get('Administrator.Posts');
    $categories = TableRegistry::get('Administrator.Categories');

        $post = $posts->get($postID, ['contain' => ['Categories'] ]);
        
        //return $post->categories;

        $avalible = array();

        $a = 0; foreach ($post->categories as $category) {

              if($category['parent_id'] == 10) {
                  array_push($avalible, $category['id']); 
                  break; 
              }

        }

        if(isset($avalible) && !empty($avalible)) {
          return $avalible[0];
        } else {
           return NULL;
        }


    }

/**********************
get total posts by user id
***********************/

    public function get_route_link($key) {
    $generals = TableRegistry::get('Administrator.Generals');

        $route = $generals->find('All', ['conditions' => ['Generals.option_key' => $key, 'Generals.type' => 'Routes']])->first();
        
        if(isset($route) && !empty($route)) {
          return $route->option_value;
        } else {
          return NULL;
        }

    }


/**********************
get current url
***********************/


    public function get_url() {
      return $this->Url->build('/', true).$this->request->url;
    }


/**********************
get company email
***********************/

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
get company address
***********************/

    public function get_company_address($id) {
    $users = TableRegistry::get('Administrator.Users');

        if(isset($id) && !empty($id)) {
        $user = $users->get($id);
              if(!empty($user->company_address)) {
                  return $user->company_address;
              } else {
                  return NULL;
              }
        } else {
          return NULL;
        }

    }



/**********************
get company tel
***********************/

    public function get_company_tel($id) {
    $users = TableRegistry::get('Administrator.Users');

        if(isset($id) && !empty($id)) {
        $user = $users->get($id);
              if(!empty($user->company_tel)) {
                  return $user->company_code_tel.' '.$user->company_area_tel.' '.$user->company_tel;
              } else {
                  return $user->code_tel.' '.$user->area_tel.' '.$user->tel;
              }
        } else {
          return NULL;
        }

    }


/**********************
get company city
***********************/

    public function get_company_city($id) {
    $users = TableRegistry::get('Administrator.Users');

        if(isset($id) && !empty($id)) {
        $user = $users->get($id);
              if(!empty($user->company_city)) {
                  return $user->company_city;
              } else {
                  return $user->city;
              }
        } else {
          return NULL;
        }

    }


/**********************
get company country
***********************/

    public function get_company_country($id) {
    $users = TableRegistry::get('Administrator.Users');

       

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



    
/**********************
get total offrtes to a company by id
***********************/

  public function get_offers_count($id) {
  $sellRent = TableRegistry::get('Administrator.SellRent');

      if(isset($id) && !empty($id)) {
         $user = $sellRent->find('all', ['conditions' => ['SellRent.author_id' => $id, 'SellRent.status' => 'active']])->count();
         return $user;
      }

  }



/**********************
get next post id
***********************/

    // imagenes chekeadas en la galería dependiendo del id
    public function get_next_post_id($id) {
    $posts = TableRegistry::get('Administrator.Posts');
        
        if(isset($id) && !empty($id)) {
              //funcion de filtro (buscar post por categoría)
              $post = $posts->find('all', ['conditions' => ['Posts.type' => 'Post', 'Posts.id >' => $id, 'Posts.status' => 'active']])->first();

              if(isset($post) && !empty($post)) {
                  
                  return $post->id;   
              }

        } else {

             return NULL;
        }
                   
    }


/**********************
get prev post id
***********************/

    // imagenes chekeadas en la galería dependiendo del id
    public function get_prev_post_id($id) {
    $posts = TableRegistry::get('Administrator.Posts');
        
        if(isset($id) && !empty($id)) {
              //funcion de filtro (buscar post por categoría)
              $post = $posts->find('all', ['conditions' => ['Posts.type' => 'Post', 'Posts.id <' => $id, 'Posts.status' => 'active'], 'order' => ['Posts.id' => 'DESC'] ])->first();

              if(isset($post) && !empty($post)) {
                  
                  return $post->id;   
              }

        } else {

             return NULL;
        }
                   
    }


/**********************
if is mobile
***********************/

  public function is_mobile() {
      return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
  }



/**********************
get pay form
***********************/

    //custom = user_id
    public function get_pay_form($itemName = NULL, $authUser, $amount = NULL, $button = NULL, $planDate = NULL) {

      $generals = TableRegistry::get('Administrator.Generals');

      $paypal = $generals->findByType('paypal');

      $user = $generals->findByTypeAndOptionKey('paypal', 'user')->first(); $paypalUser = $user->option_value;
      $business = $generals->findByTypeAndOptionKey('paypal', 'business')->first();  $paypalBusiness = $business->option_value;
      $pwd = $generals->findByTypeAndOptionKey('paypal', 'pwd')->first(); $paypalPass = $pwd->option_value;
      $signature = $generals->findByTypeAndOptionKey('paypal', 'signature')->first(); $paypalSignature = $pwd->option_value;
      $actn = $generals->findByTypeAndOptionKey('paypal', 'paypal_status')->first();  $action = $actn->option_value;

      if($action == 'production') {

          $formAction = 'https://www.paypal.com/cgi-bin/webscr';

      } else {

          $formAction = 'https://www.sandbox.paypal.com/cgi-bin/webscr';

      }

       $start = date('Y-m-d');
       $newDate = strtotime ( '+'.$planDate.' months' , strtotime ( $start ) ) ;
       $end = date ( 'Y-m-d' , $newDate );

      if($authUser && !empty($authUser)) {
            
            $campos = ['cmd' => ['label' => false, 'value' => '_xclick', 'type' => 'hidden'],
                      'user' => ['label' => false, 'value' => $paypalUser, 'type' => 'hidden'],
                      'business' => ['label' => false, 'value' => $paypalBusiness, 'type' => 'hidden'],
                      'pwd' => ['label' => false, 'value' => $paypalPass, 'type' => 'hidden'],
                      'signature' => ['label' => false, 'value' => $paypalSignature, 'type' => 'hidden'],
                      'item_name' => ['label' => false, 'value' => $itemName, 'type' => 'hidden'],
                      'item_number' => ['label' => false, 'value' => 1, 'type' => 'hidden'],
                      'currency_code' => ['label' => false, 'value' => 'USD', 'type' => 'hidden'],
                      'no_note' => ['label' => false, 'value' => 1, 'type' => 'hidden'],
                      'no_shipping' => ['label' => false, 'value' => 1, 'type' => 'hidden'],
                      'custom' => ['label' => false, 'value' => $authUser["id"], 'type' => 'hidden'],
                      'on0' => ['label' => false, 'value' => 'Premium', 'type' => 'hidden'],
                      'on1' => ['label' => false, 'value' => $start, 'type' => 'hidden'],
                      'on2' => ['label' => false, 'value' => $end, 'type' => 'hidden'],
                      'email' => ['label' => false, 'value' => $authUser["company_email"], 'type' => 'hidden'],
                      'no_shipping' => ['label' => false, 'value' => 1, 'type' => 'hidden'],
                      'amount' => ['label' => false, 'value' => $amount, 'type' => 'hidden'],
                      'return' => ['label' => false, 'value' => $this->Url->build(["controller" => "Users", "action" => "return_pay"], true), 'type' => 'hidden'],
                      'cancel_return' => ['label' => false, 'value' => $this->Url->build(["controller" => "Users", "action" => "profile"], true), 'type' => 'hidden'],
                      'notify_url' => ['label' => false, 'value' => $this->Url->build(["controller" => "Users", "action" => "notify_pay"], true), 'type' => 'hidden'],
                      $button => ['label' => false, 'class' => 'pay_button btn fondo1 fondoh3 color3 colorh1', 'type' => 'submit'],
                      ];


          echo $this->Form->create('paypal', ['class' => 'paypal_form', 'url' => $formAction]); 

                foreach ($campos as $name => $options) { 

                      echo $this->Form->input($name, $options); 
                }

          echo $this->Form->end();
          

      }
    

    }

    



}