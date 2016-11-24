<?php

namespace Front\Controller;

use Front\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Controller\Component;
use Cake\Mailer\Email;
use Cake\I18n\I18n;

//use Dompdf\Dompdf;
//use pdf\inc;



class PostsController extends AppController {   

    //variables globales para que funcione el matching en el index (solo funciona con variables publicas)
    public $getTons;
    public $getAno;
    public $getCity;
    public $getBrand;

  	public function initialize() {    
        parent::initialize();

        
    }

    public function beforeFilter(\Cake\Event\Event $event) {
    parent::beforeFilter($event);
    

        if($this->request->params['action'] != 'map' && $this->request->params['action'] != 'offer') {

              $posts = TableRegistry::get('Administrator.Posts');
              $destacados = $posts->find('all', ['conditions' => ['Posts.status' => 'active', 'Posts.type' => 'Post'], 
                                                 'order' => ['Posts.created' => 'ASC'], 
                                                 'contain' => ['Categories'] ])
                                  ->limit(10);
                                  
              $this->set('destacados', $destacados);
        }


    $this->loadModel('Posts');
      

    }


    /*** index *****/

    public function index() {

    $find = TableRegistry::get('Administrator.Posts');
	  $categories = TableRegistry::get('Administrator.Categories');
    $postsUsers = TableRegistry::get('Administrator.PostsUsers');
    $sellRent = TableRegistry::get('Administrator.SellRent');
    $cities = TableRegistry::get('Administrator.Cities');
    $fields = TableRegistry::get('Administrator.Fields');
    $offers = TableRegistry::get('Administrator.Offers');

    $slug = $this->id;

    //¨todas las entradas

    //funcion de filtro (buscar post por categoría)
    $query = $find->find('all', ['conditions' =>['Posts.status' => $this->active, 'Posts.type' => 'Post'], 'order' => ['Posts.created' => 'DESC'], 'contain' => ['Fields']]);  
    $this->set('posts', $this->paginate($query));


          	//no mostrar todos los datos de cada usuario solamente los datos que necesito 
          	$content = $find->find('all', ['conditions' => ['Posts.slug' => $slug, 'Posts.status' => $this->active, 'Posts.type' => 'Post']])
                  					->contain(['Users', 
                  							       'Categories', 
                                       'Fields' =>   ['conditions' => ['Fields.specifications' => 'yes']], 
                                       'Archives' => ['conditions' => ['Archives.mimetype LIKE ' => '%image%']] ])
                  					->first();


            $this->Cookie->write('post.id', $content->id);
            $this->Cookie->write('post.name', $content->name.' | '.$this->extras['code'].'-'.$content->id);

            //datos para verificar que las gruas sean similares
            $this->getTons = $this->Get->get_field_by_post_id($content->id, 'tons');
            $this->getAno = $this->Get->get_field_by_post_id($content->id, 'year');
            $this->getCity = $this->Get->get_field_by_post_id($content->id, 'city');
            $this->getBrand = $this->Get->get_field_by_post_id($content->id, 'brand');

            //buscar las grúas con caracteristicas similares
            $gruasRelacionadas  = $query = $find->find('all', ['conditions' => ['Posts.status' => $this->active, 'Posts.type' => 'Post'], 'group' => 'Posts.id', 'contain' => ['Fields']])
                                                ->matching('FieldsPosts', function ($q) {
                                                      return $q->where(['FieldsPosts.value' => $this->getTons])
                                                               ->OrWhere(['FieldsPosts.value' => $this->getAno])
                                                               ->OrWhere(['FieldsPosts.value' => $this->getBrand])
                                                               ->OrWhere(['FieldsPosts.value' => $this->getCity]);
                                           });

             $this->set('gruasRelacionadas', $gruasRelacionadas);

            
            $this->set('user', $content->user);

            //redireccionar a inicio si no hay post o no existe
            if(empty($content) || $content->status == $this->inactive) { 

                $this->redirect(['controller' => 'Front', 'action' => 'index']); 
                $this->Flash->alerts(__d('front', 'No hemos encontrado lo que buscas'));

            } else {

          	$this->set('content', $content);

            $id = $content->id;

          	//buscar en postsusers si el post esta como favorito del usuario logueado.
          	$userId = $this->Auth->user('id');
          	$favorite = $postsUsers->find('all', ['conditions' => ['PostsUsers.post_id' => $content->id, 'PostsUsers.user_id' => $userId] ])->count();
          	$this->set('favorite', $favorite);

            //acciones dependiendo si estoy logueado

            if(isset($userId) && !empty($userId)) {

                  $this->set('userInfo', '#user-info'); // usuario puede ver más info del publicante
                  $this->set('emailAlert', '#email_alert'); // puede ver o generar alertas
                  $this->set('quote', ['controller' => 'Posts', 'action' => 'dom',$id]); // generar cotizacion
                  $this->set('quoteTarget', '_blank'); //mandar cotizacion en link externo
                  $this->set('seeMore', '');
                  $this->set('avalibleAction', $this->Get->get_url_translate_popup($id)); // abrir oferta
                  $this->set('moreField', 'more_field');
                  $this->set('linkUser', ['controller' => 'Users', 'action' => 'site', $content->user->id]);
                  $this->set('fancy', '');
                  $this->set('fancyOffer', 'offer_iframe');
                  $this->set('rel', 'gallery');
                  $this->set('iframe', 'iframe');


            } else {

                  $loginDiv = '#login';

                  $this->set('loginDiv', '#login'); // loginbox
                  $this->set('userInfo', $loginDiv); // usuario puede ver más info del publicante
                  $this->set('emailAlert', $loginDiv); // puede ver o generar alertas
                  $this->set('quote', $loginDiv); // generar cotizacion
                  $this->set('quoteTarget', ''); //mandar cotizacion en link externo
                  $this->set('seeMore', $loginDiv);
                  $this->set('avalibleAction', $loginDiv);
                  $this->set('moreField', '');
                  $this->set('linkUser', $loginDiv);
                  $this->set('fancy', 'fancybox');
                  $this->set('fancyOffer', 'fancybox'); 
                  $this->set('iframe', '');               
                  $this->set('rel', '');
                  $this->set('btnAvalible', 'more_information');

            }


          	$this->cat = $content->categories[0]['id'];

            //todos los fields
            $techinical = $fields->find('all', ['conditions' => ['Fields.type' => 'Post', 'Fields.technical_specifications !=' => 0] ])->toArray();
            $structure = $fields->find('all', ['conditions' => ['Fields.type' => 'Post', 'Fields.crane_structure !=' => 0] ])->toArray();
            $truck_structure = $fields->find('all', ['conditions' => ['Fields.type' => 'Post', 'Fields.truck_structure !=' => 0] ])->toArray();
            $prices = $fields->find('all', ['conditions' => ['Fields.type' => 'Post', 'Fields.prices !=' => 0] ])->toArray();
            $others = $fields->find('all', ['conditions' => ['Fields.type' => 'Post', 'Fields.other !=' => 0] ])->toArray();

            $fieldsByTabs = ['technical_specifications' => $techinical, 'crane_structure' => $structure,  'truck_structure' => $truck_structure, 'other' => $others];
            $this->set('fieldsByTabs', $fieldsByTabs);

          	
              //buscar archivos pdf del post
              //$pdfs = $find->find('all', ['conditions' =>['Posts.slug' => $slug, 'Posts.status' => $this->active, 'Posts.type' => 'Post'], 'contain' => ['Archives' => ['conditions' => ['Archives.mimetype LIKE' => '%application%' ]]]])->first();

              $pdfs = $find->find('all', ['conditions' =>['Posts.slug' => $slug, 'Posts.status' => $this->active, 'Posts.type' => 'Post']])
                  ->contain([
                  'Archives' => function ($q) {
                     return $q->where(['Archives.mimetype' => 'application/pdf'])
                              ->orWhere(['Archives.mimetype' => 'application/stream'])
                              ->limit(1);
                  }
             ])->first();


              $this->set('pdfs', $pdfs->archives);

            


          } // fin validar si existe el post

    }



    /**** mapa ****/

    public function map() {
      $this->viewBuilder()->theme('Front');
      $this->viewBuilder()->layout('Front.api'); // cuenta como default

      $find = TableRegistry::get('Administrator.Posts');
      $fields = TableRegistry::get('Administrator.FieldsPosts');

      $id = $this->id;

      $post = $find->get($id, ['contain' => ['Fields', 'Archives', 'Users']]);

      $this->set('content', $post);
    }


    /**** mapa ****/

    public function offer() {

      //echo I18n::locale();
      //echo I18n::defaultlocale();

      $this->viewBuilder()->theme('Front');
      $this->viewBuilder()->layout('Front.api'); // cuenta como default

      $find = TableRegistry::get('Administrator.Posts');
      $sellRent = TableRegistry::get('Administrator.SellRent');


      $id = $this->id;
      $content = $find->get($id);
      $this->set('content', $content);


      /******** gruas relacionadas **********/

      $this->getTons = $this->Get->get_field_by_post_id($content->id, 'tons');
      $this->getAno = $this->Get->get_field_by_post_id($content->id, 'year');
      $this->getCity = $this->Get->get_field_by_post_id($content->id, 'city');
      $this->getBrand = $this->Get->get_field_by_post_id($content->id, 'brand');

      //buscar las grúas con caracteristicas similares

      $gruasRelacionadas  = $query = $find->find('all', ['conditions' => ['Posts.status' => $this->active, 'Posts.type' => 'Post', 'Posts.user_id !=' => $content->user_id], 'fields' => ['id', 'name', 'user_id'],  'group' => 'Posts.user_id'])
      //$gruasRelacionadas  = $query = $find->find('all', ['conditions' => ['Posts.status' => $this->active, 'Posts.type' => 'Post', 'Posts.user_id' => $content->user_id], 'fields' => ['id', 'name', 'user_id'],  'group' => 'Posts.user_id'])
                                        ->matching('FieldsPosts', function ($q) {
                                              return $q->where(['FieldsPosts.value' => $this->getTons])
                                                       ->OrWhere(['FieldsPosts.value' => $this->getAno])
                                                       ->OrWhere(['FieldsPosts.value' => $this->getBrand])
                                                       ->OrWhere(['FieldsPosts.value' => $this->getCity]);
                                   });

      $this->set('gruasRelacionadas', $gruasRelacionadas);

      /******** envio de oferta **********/

      if($this->request->is('post')) {
                

                              //si el correo es para la compra este le llegará a sologruas, de lo contrario le llegará a la empresa.
                              if($this->request->data['type'] == 'sell') { 

                                      $toEmail = $this->blogEmail; 
                                      $date_start = NULL;
                                      $value = $this->request->data['value'];
                                      $date_end = NULL;
                                      $city = NULL;
                                      $country = NULL;
                                      $state = NULL;

                              } else { 

                                      $toEmail = $this->Get->get_user_email($this->request->data['author_id']);
                                      $value = NULL;
                                      $date_start = $this->request->data['date_start'];
                                      $date_end = $this->request->data['date_end'];
                                      $city = $this->request->data['city'];
                                      $country = $this->request->data['country'];
                                      $state = $this->request->data['state'];

                              }
                              
                              //sebject general
                              $subject = __d('front', 'Se ha generado una oferta para '). ' ' .$content->name;

                              //agregamos variables para el layout datos de usuario. (variables fijas van em ambos tipos, variable request->data manda los datos dependiendo de lo que se va a mostrar)
                              $datosEnvio = array_merge(['logo' => $this->Get->get_frontend_images_url('logo'),
                                                         'name' => $this->Get->get_name($this->request->data['user_id'], 'Users'), 
                                                         'code' => $this->extras['code'].' - '.$id, 
                                                         'email' => $this->Get->get_user_email($this->request->data['user_id']),  
                                                         'tel' => $this->Get->get_company_tel($this->request->data['user_id']),  
                                                         'product' => $content->name,
                                                         'code' => $content->id,
                                                         'currency' => $this->info['currency'], //variable global desde el app
                                                         'postal_code' => $this->request->data['postal_code'],
                                                         'blogName' => $this->blogName, 
                                                         'subject' => $subject,
                                                         ],
                                                         $this->request->data);

                              //arriba para mandar las variables reales primero
                              if(isset($this->request->data['type']) && $this->request->data['type']== 'rent') {

                                                      //email de oferta para la empresa
                                                      $email = new Email('default');
                                                      $email->emailFormat('html') //tipo de mensaje (plantilla en html)
                                                            ->template('Front.default', 'Front.default') //template default (Contacto) del email y Layout del email (TEMPLETE / LAYOUT)
                                                            ->from([$this->noReply => $this->blogName])
                                                            //->to($this->Get->get_user_email($this->request->data['author_id']))
                                                            ->to($toEmail) // el correo lo llamamos validando si es para alquiler o compra
                                                            ->subject($subject)
                                                            ->viewVars($datosEnvio)
                                                            ->send();                                                      
                                                      
                              } 

                              //debajo para cambiar algunas variables para las gruas relacionadas
                              //validar si el usuario soicita q mande la solicitud a todas las gruas o solo a 1
                              if(isset($this->request->data['relationships']) && !empty($this->request->data['relationships'])) {
                                        /** comienza el foreach de las gruas relacioandas, esto mandará correo a todos los usuarios con gruas generadas **/

                                                      $subjectRelations = __d('front', 'Este es un email de alerta. Un cliente interesado en una grúa con estas caracteristicas desde: '). ' ' .$this->blogName;
                                                      $datosRelacionados = array_merge($datosEnvio, ['subject' => $subjectRelations, 'customers' => 1]);

                                                      foreach ($gruasRelacionadas as $post) {
                                                            
                                                            //correo de los otros publicantes NO SE LE ENVIARÁ AL QUE LA PUBLICÓ 
                                                            $otherEmail = $this->Get->get_user_email($post->user_id);

                                                            //email de oferta para la empresa
                                                            
                                                            $email = new Email('default');
                                                            $email->emailFormat('html') //tipo de mensaje (plantilla en html)
                                                                  ->template('Front.default', 'Front.default') //template default (Contacto) del email y Layout del email (TEMPLETE / LAYOUT)
                                                                  ->from([$this->noReply => $this->blogName])
                                                                  //->to($this->Get->get_user_email($this->request->data['author_id']))
                                                                  ->to($otherEmail) // el correo lo llamamos validando si es para alquiler o compra
                                                                  ->subject($subjectRelations)
                                                                  ->viewVars($datosRelacionados)
                                                                  ->send();                                                                                                                             

                                                      }

                              
                              }


                              if(isset($this->request->data['value']) && !empty($this->request->data['value'])) {

                                                      //email de oferta para la empresa
                                
                                                      $email = new Email('default');
                                                      $email->emailFormat('html') //tipo de mensaje (plantilla en html)
                                                            ->template('Front.default', 'Front.default') //template default (Contacto) del email y Layout del email (TEMPLETE / LAYOUT)
                                                            ->from([$this->noReply => $this->blogName])
                                                            //->to($this->Get->get_user_email($this->request->data['author_id']))
                                                            ->to($toEmail) // el correo lo llamamos validando si es para alquiler o compra
                                                            ->subject($subject)
                                                            ->viewVars($datosEnvio)
                                                            ->send();
                                                          

                              }

                                                      $respuesta = $this->extras['offer_sucessfull'];

                              //guardar la oferta en la tabla sell_rent
                              $new = $sellRent->newEntity();
                              $save = $sellRent->patchEntity($new, $this->request->data);
                              $sellRent->save($save);


                  $this->set('respuesta', $respuesta);


            }







    }



    /*** Compare ***/

    public function compare() {
      
      $posts = TableRegistry::get('Administrator.Posts');
      $compare = TableRegistry::get('Administrator.Compare');  

      $userId = $this->Auth->user('id');

      $compare->Posts->belongsToMany('Fields');
      $query = $compare->find('all', ['conditions' =>['Compare.user_id' => $userId], 'contain' => ['Posts'=>['Fields']] ]);
      
      
      if($query->count()==0){
        $this->Flash->exito(__d('front', 'Lo sentimos no tienes gruas para comparar.'));
        $this->redirect(array('plugin'=>'Front', 'controller' => 'Users', 'action' => 'profile')); 
      }elseif($query->count()>0 and $query->count()<=3){
        $this->set('posts', $query);
      }else{
        $this->Flash->exito(__d('front', 'Lo sentimos no puedes tener más de 3 gruas para comparar.'));
        $this->redirect(array('plugin'=>'Front', 'controller' => 'Users', 'action' => 'profile')); 
      }
     
    }


     public function compare_request() {

      $this->viewBuilder()->layout('Front.api'); // cuenta como default

      

        if ($this->request->is('ajax')) {

            // imagenes chekeadas en la galería dependiendo del id
            if(isset($this->request->data['id']) and isset($this->request->data['user'])){
                //echo pr($this->request->query);
                $ranking = TableRegistry::get('Administrator.Compare');

                $filtro = $ranking->find('all', ['conditions' => ['Compare.post_id' => $this->request->data['id'], 'Compare.user_id' => $this->request->data['user']]])->count();


                $filtro2 = $ranking->find('all', ['conditions' => ['Compare.user_id' => $this->request->data['user']]])->count();

              if($filtro2<3){

                      if($filtro==0){
                          $save = $ranking->newEntity(['post_id' => $this->request->data['id'], 'user_id' => $this->request->data['user']]);
                          $ranking->save($save); 

                          if($filtro2==0){
                            
                            $this->set('mensaje', __d('front', 'Ya seleccionaste un agrua. Selecciona otra grua para poder comparar.'));
                          }else{
                            
                            $this->set('mensaje', __d('front', 'Dato Almacenado. Puedes ver tus gruas comparadas <br> <a href="/compare" ><b>Ver comparaciones</b></a>'));
                          }
                          
                          //echo 'Voto almacenado';
                      }else{

                        //$this->Flash->exito(__d('front', 'El dato ya se encuentra registrado en nuestra base de datos.'));
                        $this->set('mensaje', __d('front', 'El dato ya se encuentra registrado en nuestra base de datos.'));
                        
                      }

              }else{
                $this->redirect(array('controller' => 'Posts', 'action' => 'compare')); 
                $this->set('mensaje', __d('front', 'Lo sentimos no se puede agregar más de 3 gruas para comparar.<br> <a href="/compare" >Ver comparaciones</a>'));  
              }
                

            }

        }else{
              $this->set('mensaje', __d('front', 'Acceso restringido.'));
        }        


        $this->render('ranking');

       // $this->redirect(array('controller' => 'Front', 'action' => 'index')); 
    
    }



    public function compare_request_delete($id=null) {

      $compare = TableRegistry::get('Administrator.Compare'); 

          
          $post = $compare->get($id);
          $compare->delete($post);
          $this->Flash->alerts(__d('front', 'Se ha eliminado por completo el registro de comparación'));
          $this->redirect([ 'action' => 'compare']); 

    
    }



    /**** Cotización PDF ****/

   public function dom($id=null) {


    if($this->request->session()->read('Auth.User.id')){

        $this->viewBuilder()->layout('Front.pdf'); // cuenta como default

        $titulo='quote-nextcrane';
       
        require_once(ROOT . DS . 'vendor' . DS  . 'pdf' . DS . 'dompdf_config.inc.php');

        $var=$this->request->session()->read('Auth.User.id').'_'.$id.'_2ca16b3b3a9dea22e3bed2192d111c577dc2987a';


        $url= 'http://nextcrane.com/testpdf/'.$var;
        $url = stripslashes($url);
        @$old_limit = ini_set("memory_limit", "32M");
        //$file = file_get_contents($url); 

        //$file='Señores día Bogotá';
        $dompdf = new  \DOMPDF;
        $dompdf->load_html($url);
        $dompdf->load_html_file($url);
        $dompdf->set_paper("A4", 'portrait'); //portrait - landscape
        $dompdf->render(); 

        $dompdf->stream("$titulo.pdf");
        $this->render('testpdf');

        //header('Content-type: application/pdf'); //Ésta es simplemente la cabecera para que el navegador interprete todo como un PDF
        echo $dompdf->output(); //Y con ésto se manda a imprimir el contenido del pdf

    }else{

        $this->Flash->alerts(__d('front', 'Area de acceso restringida.'));
          $this->redirect([ 'action' => 'index']); 
    }
      

    }


    public function prpdf($id=null){
      $find = TableRegistry::get('Administrator.Posts');
      $post = $find->get($id, ['contain' => ['Fields', 'Archives']]);
      $this->set('crane', $post);
    }



     public function testpdf($var=null) {
      

      if($var){
    
        $var=explode('_',$var);
        
        if($var[2]=='2ca16b3b3a9dea22e3bed2192d111c577dc2987a'){
        $find = TableRegistry::get('Administrator.Users');

        $user =$find->find('All', array('conditions' => array('Users.id' => $var[0])))->first();
        
        $nombre=$user->name;
        $this->set('nombre',$nombre);  
        $this->set('company',$user->company_name);  
        
        }
      }

      $this->viewBuilder()->layout('Front.pdf'); // cuenta como default


      $find = TableRegistry::get('Administrator.Posts');
      $fields = TableRegistry::get('Administrator.FieldsPosts');
      $fields2 = TableRegistry::get('Administrator.Fields');

      $id = $var[1];
      
      $fecha_cot=date('d-m-Y');
      $id_cotizacion=111;
      $this->set(compact('fecha_cot', 'id_cotizacion'));


      $post = $find->get($id, ['contain' => ['Fields', 'Archives']]);
      $this->set('crane', $post);

       //todos los fields
      $techinical = $fields2->find('all', ['conditions' => ['Fields.type' => 'Post', 'Fields.technical_specifications !=' => 0] ])->toArray();
      $structure = $fields2->find('all', ['conditions' => ['Fields.type' => 'Post', 'Fields.crane_structure !=' => 0] ])->toArray();
      $truck_structure = $fields2->find('all', ['conditions' => ['Fields.type' => 'Post', 'Fields.truck_structure !=' => 0] ])->toArray();
      $prices = $fields2->find('all', ['conditions' => ['Fields.type' => 'Post', 'Fields.prices !=' => 0] ])->toArray();
      $others = $fields2->find('all', ['conditions' => ['Fields.type' => 'Post', 'Fields.other !=' => 0] ])->toArray();

      $fieldsByTabs = ['technical_specifications', 'crane_structure', 'truck_structure', 'prices', 'others'];
      $this->set('fieldsByTabs', $fieldsByTabs);

      $this->set(compact('techinical', 'structure', 'truck_structure', 'prices', 'other'));

      //$this->request->session()->write('usuario.name', $this->request->session()->read('Auth.User.name'));
  
  }



    public $paginate = ['limit' => 100];

    public function find() {

      $posts = TableRegistry::get('Administrator.Posts');
      $fields = TableRegistry::get('Administrator.FieldsPosts');

      //funcion de filtro (buscar post por categoría)
      $query = $posts->find('all', ['conditions' =>['Posts.status' => $this->active, 'Posts.type' => 'Post'], 'order' => ['Posts.created' => 'DESC'], 'contain' => ['Fields'], 'translations' => ['locales' => ['en'] ] ]);

      if(!empty($this->id)) { 
          $query->matching('FieldsPosts', function ($query) {
                return $query->Where(['FieldsPosts.value' => $this->id]);
          });
      }
      
      $this->set('posts', $this->paginate($query)); 

      $object = (object) ['name' => __d('front', 'Resultados del filtro de busqueda por continente'), 'description' => ''];


      $this->set('content', $object);

      $this->render('Categories/index');


    }


    //guardar relaiones de favoritos
    public function save_favorite() {

        $userId = $this->Auth->user('id');
        $postsId = $this->request->pass['0'];

        $posts = TableRegistry::get('Administrator.Posts');
        $postsUsers = TableRegistry::get('Administrator.PostsUsers');

        

        if(isset($userId) && !empty($userId) && isset($postsId) && !empty($postsId)) {

        	$post = $posts->get($postsId);

            $getPostUser = $postsUsers->find('all', ['conditions' => ['PostsUsers.post_id' => $postsId, 'PostsUsers.user_id' => $userId]])->count();

            // esta validacion es para que no duplique entradas guardadas. si ya existe un elemento con estos datos no lo vuelva a mandar.
            if($getPostUser == 0) {
        	   $save = $postsUsers->newEntity(['post_id' => $postsId, 'user_id' => $userId]);
               $postsUsers->save($save);
            }

        	$this->redirect(array('action' => 'index',$post->slug)); 
			$this->Flash->exito(__d('front', 'Guardado en Favoritos'));

        } else {

        	$post = $posts->get($postsId);
        	$this->redirect(array('action' => 'index', $post->slug)); 
			$this->Flash->exito(__d('front', 'Lo sentimos, el usuario no existe'));

        }


    }


     //guardar relaiones de favoritos
    public function remove_favorite() {

        $userId = $this->Auth->user('id');
        $postsId = $this->request->pass['0'];

        $posts = TableRegistry::get('Administrator.Posts');
        $postsUsers = TableRegistry::get('Administrator.PostsUsers');


        if(isset($userId) && !empty($userId) && isset($postsId) && !empty($postsId)) {

        	$getPostUser = $postsUsers->find('all', ['conditions' => ['PostsUsers.post_id' => $postsId, 'PostsUsers.user_id' => $userId]])->first()->toArray();
        	$delete = $postsUsers->get($getPostUser['id']);
        	$postsUsers->delete($delete);

        	$post = $posts->get($postsId);
        	$this->redirect(array('action' => 'index',$post->slug)); 
			$this->Flash->exito(__d('front', 'Se ha removido de tus Favoritos'));

        } else {

        	$post = $posts->get($postsId);
        	$this->redirect(array('action' => 'index', $post->slug)); 
			$this->Flash->exito(__d('front', 'Lo sentimos, el usuario no existe'));

        }


    }


    public function my_favorites() {
       
    $posts = TableRegistry::get('Administrator.Posts');
    
    $userId = $this->Auth->user('id');

    //funcion de filtro (buscar post por categoría)
    $query = $posts->find('all', ['conditions' =>['Posts.status' => $this->active, 'Posts.type' => 'Post'], 
                                  'order' => ['Posts.created' => 'DESC'], 'contain' => ['Fields'], 
                                //'translations' => ['locales' => ['en']]
                          ])

                    ->matching('PostsUsers', function ($q) {
                            return $q->where(['PostsUsers.user_id' =>  $this->Auth->user('id')]);
    });
    
    $this->set('posts', $this->paginate($query));   



    }


     public function ranking() {

        if ($this->request->is('ajax')) {

            // imagenes chekeadas en la galería dependiendo del id
            if(isset($this->request->data['id']) and isset($this->request->data['value']) and isset($this->request->data['user'])){
                //echo pr($this->request->query);
                $ranking = TableRegistry::get('Administrator.Rank');

                $filtro = $ranking->find('all', ['conditions' => ['Rank.author_id' => $this->request->data['id'], 'Rank.user_id' => $this->request->data['user']]])->count();

                if($filtro==0){
                    $save = $ranking->newEntity(['author_id' => $this->request->data['id'], 'user_id' => $this->request->data['user'], 'value' => $this->request->data['value']]);
                    $ranking->save($save); 


                    $field = TableRegistry::get('Administrator.Score');
                    $ranking = TableRegistry::get('Administrator.Rank');
                    
                    
                    //Field 12 por default de ranking - Actualización campo Field

                    //Se realiza su respectiva operación matemática.
                    $entity = $field->find('all', ['conditions' => ['author_id' => $this->request->data['id']]])->first();

                    if($entity){
                      $find = $ranking->find('all', ['conditions' => ['Rank.author_id' => $this->request->data['id']]])->toArray();
                      $total=0;                    
                      foreach ($find as $value) {
                         $total=$total+$value['value'];
                      }
                     
                      $total=$total/count($find);
                      $data=['score'=>round($total)];

                      //echo round($total);
                      $save = $field->patchEntity($entity, $data);
                      $field->save($save); 

                    }else{
                      $data=['user_id'=> $this->request->data['user'], 'author_id'=> $this->request->data['id'], 'score'=> $this->request->data['value']];
                      $save = $field->newEntity($data);
                      $field->save($save);

                    }


                   

                    //echo 'Voto almacenado';
                }
                

            }

        }

        $this->redirect(array('controller' => 'Front', 'action' => 'index')); 
        
        

    }


    public function alert() {

      if ($this->request->is('ajax')) {

           // imagenes chekeadas en la galería dependiendo del id
           if(isset($this->request->data['id']) and isset($this->request->data['user'])){
               //echo pr($this->request->query);
               $ranking = TableRegistry::get('Administrator.Alerts');

               $filtro = $ranking->find('all', ['conditions' => ['Alerts.post_id' => $this->request->data['id'], 'Alerts.user_id' => $this->request->data['user']]])->count();

               if($filtro==0){
                   $save = $ranking->newEntity(['post_id' => $this->request->data['id'], 'user_id' => $this->request->data['user']]);
                   $ranking->save($save); 

               }

           }

      }

      $this->redirect(['controller' => 'Front', 'action' => 'index']); 

   }







}
