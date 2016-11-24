<?php
/* src/View/Helper/LinkHelper.php */
namespace Administrator\View\Helper;

use Cake\View\Helper;
use Cake\Controller\Component;
use Cake\ORM\TableRegistry;

class GetHelper extends Helper {

    public $helpers = ['Url', 'Html', 'Form'];

    // imagenes chekeadas en la galería dependiendo del id
    public function get_category_checked($catID, $postid) {
    $posts = TableRegistry::get('Administrator.Posts');
        
        if(isset($postid) && !empty($postid) && isset($catID) && !empty($catID)) {

                $post = $posts->get($postid, ['contain' => ['Categories']])->toArray();

                if(isset($post) && !empty($post)) {      
                        foreach ($post['categories'] as $cat) {

                               if($cat['id'] == $catID) {
                                    return 'checked';
                               } 
                        }
                }
        }
         
    }


/*******************************
GENERALES
******************************/

    // imagenes chekeadas en la galería dependiendo del id
    public function get_option_value($optionKey, $type = NULL) {
    $generals = TableRegistry::get('Administrator.Generals');
        
        if(isset($optionKey) && !empty($optionKey) && isset($type) && !empty($type)) {
                $general = $generals->findByOptionKeyAndType($optionKey, $type)->first();
                if(isset($general) && !empty($general)) {      
                        return $general->option_value;     
                }

        } elseif(isset($optionKey) && !empty($optionKey)) {
                $general = $generals->findByOptionKey($optionKey)->first();
                if(isset($general) && !empty($general)) {      
                        return $general->option_value;
                }
         
        }
    
    }



    //*************************language_default//*************************/
    
    public function get_language_link($language, $custom=null) {
          //
          if(isset($this->request->pass['0']) && !empty($this->request->pass['0']) && isset($this->request->params['language'])) {
              return '/admin/'.$this->request->controller.'/'.$this->request->action.'/'.$this->request->pass['0'];
          }
          //Url Personalizada
          elseif(isset($this->request->params['language']) && isset($custom)){
              return '/'.$language.'/admin/'.$this->request->controller.'/'.$custom;
          }
          //
          elseif(empty($this->request->pass['0']) && isset($this->request->params['language'])) {
              return '/admin/'.$this->request->controller.'/'.$this->request->action;
          /*}elseif(isset($this->request->pass['0']) && !empty($this->request->pass['0'])) {
              return '/'.$language.'/admin/'.$this->request->controller.'/'.$this->request->action.'/'.$this->request->pass['0'];
          }*/

          //Url Personalizada
           /*elseif(isset($this->request->pass['0']) && !empty($this->request->pass['0']) && $this->request->pass['0']=='index') {
              return '/'.$language.'/admin/'.$this->request->controller.'/'.$this->request->action;
          } elseif(isset($this->request->pass['0']) && !empty($this->request->pass['0']) && isset($this->request->params['language']) ) {
              return '/'.$language.'/admin/'.$this->request->controller.'/'.$this->request->action;
          }*/
          }

          elseif( isset($this->request->pass['0']) && !empty($this->request->pass['0']) && !isset($this->request->params['language'])){
              return '/'.$language.'/admin/'.$this->request->controller.'/'.$this->request->action.'/'.$this->request->pass['0'];
          }

          else {
            return '/'.$language.'/admin/'.$this->request->controller.'/'.$this->request->action;
          }

    }

/**********************
get link
***********************/


    // obtener el enlace de las paginas, categorias post etc por id y por controlador
    public function get_link($id, $type) {

        
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



    // obtener el enlace de las paginas, categorias post etc por id y por controlador
    public function get_link1($id, $type) {

        
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


/***************************
GET TITLES BY TYPE AND ID
***************************/

    public function get_title_by_type_and_id($id, $type) {
            
            if(isset($type) && isset($id) && !empty($type) && !empty($id)) {
                
                if($type == 'Pages' || $type == 'pages') { $type = 'Posts'; } // validar el tipo Pages e igualarlo al modelo Posts.

                $searchs = TableRegistry::get('Administrator.'.$type);
                $find = $searchs->find('all',['conditions' => [$type.'.id' => $id], 'fields' => ['name']])->first(); 
                return $find->name;
                
            } else {
                return NULL;
            }

    }



/***************************
GET AUTHOR BY POST ID
***************************/

    public function get_author_by_post_id($id) {
    $posts = TableRegistry::get('Administrator.Posts');

            if(isset($id) && !empty($id)) {
                
                $find = $posts->get($id, ['conditions' => ['Posts.type' => 'Post'], 'contain' => ['Users'] ]); 
                return $find->user['name'].' '.$find->user['last_name'];
                
            } else {
                return NULL;
            }

    }


/***************************
GET FIELDS BY TYPE
***************************/

    public function get_fields_by_type($type) {
    $fields = TableRegistry::get('Administrator.Fields');
            
            if(isset($type) && !empty($type)) {
                
                $all_fields = $fields->find('all',['conditions' => ['type' => $type]])->toArray(); 
                return $all_fields;
                
            } else {
                return NULL;
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

/***************************
GET OFFER TYPE
***************************/

  
    public function get_offer_type($type) { //value puede ser 0 o vacio y diferente de 0 ( 0 = alquiler, 1 u otro Venta)
    $fields = TableRegistry::get('Administrator.Fields');
            
            if($type != 0) {
                
                return __('Venta');
                
            } else {
                return __('Alquiler');
            }

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



/***************************
PAISES
***************************/


  public function get_all_countries() {
      $countries = TableRegistry::get('Administrator.Countries');
      $names = $countries->find('list', ['keyField' => 'id', 'valueField' => 'name'])->toArray();

      return $names;
  }





}