<?php 
namespace Administrator\Controller;

use Administrator\Controller\AppController;

use Cake\Core\Configure;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\ORM\TableRegistry;

use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
use Cake\Utility\Text;
use Cake\Utility\Security;
use Cake\Routing\Router;
use Cake\Controller\Component;
use Cake\Mailer\Email;


class UsersController extends AppController
{      
    public $roles; //variable publica para los roles

    public function beforeFilter(\Cake\Event\Event $event)
    {
        parent::beforeFilter($event);


        if($this->request->params['action']=='index'){
            $state='active';
        }else{
            $state='inactive';
        }

        if($this->Auth->user('role_id') != 1) { 

            $conditions = ['Users.status = ' => $state, 'Users.id' => $this->Auth->user('id')];

        } else {

            $conditions = ['Users.status = ' => $state];

        }


        $this->paginate = ['conditions' => $conditions, 'contain' => ['Roles'], 'limit'=>100, ];
        $losusuarios = $this->paginate(); 
        $this->set('usuarios', $losusuarios);

        $this->todos = $this->Users->find('all', ['conditions' => ['Users.status != ' => 'removed']])->count(); 
        $this->activos = $this->Users->find('all', ['conditions' => ['Users.status = ' => 'active']])->count(); 
        $this->inactivos = $this->Users->find('all', ['conditions' => ['Users.status = ' => 'inactive']])->count(); 
        
        $activos = $this->activos;
        $todos = $this->todos;
        $inactivos = $this->inactivos;
        
        $this->set(compact('activos', 'inactivos', 'todos')); 

            //Variables
            $role = TableRegistry::get('roles');
            $roles = $role->find('list');
            $this->roles = $roles;
            $this->set(compact('roles'));

            $estado=$this->Users->schema()->column('status');
            $estado=$estado['comment'];
            preg_match_all("/'(.*?)'/", $estado, $enums1);
        
            $status = $enums1[1];
            $status=array_combine($status, $status);
            $this->set(compact('status')); // tipos de estado 

            //$role = TableRegistry::get('Posts'); 


              

    }
    

    public function index() {
        
        if($this->request->is('post')) {

            if($this->request->data['checkbox']) {
                 
                foreach($this->request->data['checkbox'] as $userID) {
                    //$this->Users->id = $userID;
                   $data=['status' => 'inactive'];
                   $dato = $this->Users->get($userID);
                   $user = $this->Users->patchEntity($dato, $data,  ['validate' => false]);            
                   $this->Users->save($user);
                }
                
                $this->Flash->exito(__d('administrator', 'Usuarios eliminado con éxito.'));
                $this->redirect(['action' => 'index']);
                
            }
        }

        
    }
    
    public function add() {

        $estado=$this->Users->schema()->column('type');
        $estado=$estado['comment'];
        preg_match_all("/'(.*?)'/", $estado, $type);
        $status=array_combine($type[1], $type[1]);

        
        $this->set('template', Configure::read('Template_Form.pass'));

        $user = $this->Users->newEntity();
        $this->set('user',$user);


            if(!empty($dato->company_country)) { $companyCountry = [$dato->company_country => $dato->company_country]; } else { $companyCountry = $this->extras['select_default']; }
            if(!empty($dato->company_city)) { $companyCity = [$dato->company_city => $dato->company_city]; } else { $companyCity = $this->extras['select_default']; }


            //tipos de usuario
            $industryType = ['contractor'  => $this->extras['contractor'], 'rental_heavy_equipment'  => $this->extras['rental_heavy_equipment'], 'special_transportation'  => $this->extras['special_transportation'], 
                            'utility_mining_oil'  => $this->extras['utility_mining_oil'], 'new_distrbuitor_parts' => $this->extras['new_distrbuitor_parts'], 'used_distrbuitor_broker' => $this->extras['used_distrbuitor_broker'], 
                            'windowpower' => $this->extras['windowpower'], 'manufacturer' => $this->extras['manufacturer'], 'server_repair' => $this->extras['server_repair'], 
                            'certification_company' => $this->extras['certification_company'], 'others' => $this->extras['others']];


            $tablesData = ['general_data' => ['name'=>['label'=> $this->extras['name'], 'option'=>''], 
                                            'last_name'=>['label'=> $this->extras['last_name'], 'option'=>''],
                                            //'identification'=>['label'=> $this->extras['identification'], 'option'=>''], 
                                            'tel'=>['label'=>  $this->extras['phone'], 'option'=>''],
                                            'email'=>['label'=> $this->extras['email'], 'option'=>''], 
                                            'code_cel'=>['label'=> $this->extras['indicative']],
                                            'area_cel'=>['label'=> $this->extras['code_area']],
                                            'cel'=>['label'=> $this->extras['celphone'], 'option'=>''],
                                            'password'=>['label'=> $this->extras['password']],
                                            'password_confirm'=>['label'=> $this->extras['confirm_password'], 'type' => 'password'],
                                            //'country'=>['label'=> $this->extras['country']],
                                           ], 
                         
                         'company_data' => [
                                            'role_id'=> ['type'=>'select', 'options' => $this->roles, 'required', 'empty' => '- Selecciona una opción -', 'label' => $this->extras['rol']], 
                                            'type'=> ['type'=>'select', 'options' => $status, 'required', 'empty' => '- Selecciona una opción -', 'label' => $this->extras['plan']], 
                                            'company_name'=>['label'=> $this->extras['company_name']], 
                                            'company_email'=>['label'=> $this->extras['company_email']], 
                                            'company_address'=>['label'=> $this->extras['company_address']], 
                                            'company_country'=>['label'=> $this->extras['company_country'], 'class' => 'country', 'type' => 'select', 'empty' => $companyCountry ], 
                                            'company_state'=>['label'=> $this->extras['state'], 'class' => 'state', 'type' => 'select', 'empty' => $companyCity], 
                                            'company_city'=>['label'=> $this->extras['company_city'], 'class' => 'city', 'type' => 'select', 'empty' => $companyCity], 
                                            'company_code_tel'=>['label'=> $this->extras['indicative']], 
                                            'company_area_tel'=>['label'=> $this->extras['code_area']], 
                                            'company_tel'=>['label'=> $this->extras['company_tel']], 
                                            'company_identification'=>['label'=> $this->extras['company_identification']],  
                                            'company_position'=>['label'=> $this->extras['company_position']],  
                                            'industry_type'=>['label'=> $this->extras['industry_type'], 'type' => 'select', 'options' => $industryType],  
                                            //'equipment_buy_status'=>['label'=> $this->extras['equipment_buy_status'], 'type' => 'select', ],  
                                                  ],                                          
                        ]; 


            $this->set('tablesData', $tablesData);



        if($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->data);
            
            if ($this->Users->save($user)) {
            
                                            //agregamos variables para el layout datos de usuario.
                           $subject = __d('administrator', 'Usuario generado exitósamente en: '). $this->blogName;
                           $logo = 'http://'.$this->request->env('HTTP_HOST')."/".$this->Get->get_frontend_images_url('logo');
                           $description = __d('administrator', 'Este es un mensaje automático. El siguiente es un correo enviado el');
                           $datosEnvio = array_merge(['new' => 'new', 'logo' => $logo, 'blogName' => $this->blogName, 'subject' => $subject, 'description' => $description], $this->request->data);

                                        //email de contactenos
                                        $email = new Email('default');
                                        $email->emailFormat('html') //tipo de mensaje (plantilla en html)
                                              ->template('Administrator.default', 'Administrator.default') //template default (Contacto) del email y Layout del email (TEMPLETE / LAYOUT)
                                              ->from([$this->noReply => $this->blogName])
                                              ->to($this->request->data['email'])
                                              ->subject($subject)
                                              ->viewVars($datosEnvio)
                                              ->send();

                           
                        $this->Flash->exito(__d('administrator', 'Usuario generado exitósamente, un correo de confirmación se ha enviado'));
                        $this->redirect(['action' => 'index']);

            }

        }
    
    $this->render('edit');
        
    }
    
    
    public function edit($id = null) {
    
    // componente de textos.        
            $estado=$this->Users->schema()->column('type');
            $estado=$estado['comment'];
            preg_match_all("/'(.*?)'/", $estado, $type);
            $status=array_combine($type[1], $type[1]);


            $this->Function->siExiste($id, 'index', null);   
            
            $dato = $this->Users->get($id, ['contain' => 'Roles']);
            $this->set('user', $dato);
           
            $publications = $this->Users->Posts->find('All', ['conditions' => ['Posts.user_id' => $id]])->count();
            $this->set('publicationsTotal', $publications);

            $totalPublicaciones = $this->Users->Posts->find('All', ['conditions' => ['Posts.user_id' => $id, 'Posts.type' => 'post']])->count();
            $totalPages = $this->Users->Posts->find('All', ['conditions' => ['Posts.user_id' => $id, 'Posts.type' => 'page']])->count();

            $totalPosts = ['publication' => ['total' => $totalPublicaciones, 'name' => $this->extras['posts']], 'page' =>  ['total' => $totalPages, 'name' => $this->extras['pages']] ];
            $this->set('totalPosts', $totalPosts);

                            
            if(!empty($dato->company_country)) { $companyCountry = [$dato->company_country => $dato->company_country]; } else { $companyCountry = $this->extras['select_default']; }
            if(!empty($dato->company_city)) { $companyCity = [$dato->company_city => $dato->company_city]; } else { $companyCity = $this->extras['select_default']; }


            //tipos de usuario
            $industryType = ['contractor'  => $this->extras['contractor'], 'rental_heavy_equipment'  => $this->extras['rental_heavy_equipment'], 'special_transportation'  => $this->extras['special_transportation'], 
                            'utility_mining_oil'  => $this->extras['utility_mining_oil'], 'new_distrbuitor_parts' => $this->extras['new_distrbuitor_parts'], 'used_distrbuitor_broker' => $this->extras['used_distrbuitor_broker'], 
                            'windowpower' => $this->extras['windowpower'], 'manufacturer' => $this->extras['manufacturer'], 'server_repair' => $this->extras['server_repair'], 
                            'certification_company' => $this->extras['certification_company'], 'others' => $this->extras['others']];


            $tablesData = ['general_data' => ['name'=>['label'=> $this->extras['name'], 'option'=>''], 
                                            'last_name'=>['label'=> $this->extras['last_name'], 'option'=>''],
                                            //'identification'=>['label'=> $this->extras['identification'], 'option'=>''], 
                                            'tel'=>['label'=>  $this->extras['phone'], 'option'=>''],
                                            'email'=>['label'=> $this->extras['email'], 'option'=>''],
                                            'code_cel'=>['label'=> $this->extras['indicative']],
                                            'area_cel'=>['label'=> $this->extras['code_area']],
                                            'cel'=>['label'=> $this->extras['celphone'], 'option'=>''],
                                            'password'=>['label'=> $this->extras['password'], 'autocomplete' => 'off', 'value' => ''],
                                            'password_confirm'=>['label'=> $this->extras['confirm_password'], 'type' => 'password'],
                                            //'country'=>['label'=> $this->extras['country']],
                                           ], 
                         
                         'company_data' => [
                                            'role_id'=> ['type'=>'select', 'options' => $this->roles, 'required', 'empty' => '- Selecciona una opción -', 'label' => $this->extras['rol']], 
                                            'type'=> ['type'=>'select', 'options' => $status, 'required', 'empty' => '- Selecciona una opción -', 'label' => $this->extras['plan']], 
                                            'company_name'=>['label'=> $this->extras['company_name']], 
                                            'company_email'=>['label'=> $this->extras['company_email']], 
                                            'company_address'=>['label'=> $this->extras['company_address']], 
                                            'company_country'=>['label'=> $this->extras['company_country'], 'class' => 'country', 'type' => 'select', 'empty' => $companyCountry ], 
                                            'company_state'=>['label'=> $this->extras['state'], 'class' => 'state', 'type' => 'select', 'empty' => $companyCity], 
                                            'company_city'=>['label'=> $this->extras['company_city'], 'class' => 'city', 'type' => 'select', 'empty' => $companyCity], 
                                            'company_code_tel'=>['label'=> $this->extras['indicative']], 
                                            'company_area_tel'=>['label'=> $this->extras['code_area']], 
                                            'company_tel'=>['label'=> $this->extras['company_tel']], 
                                            'company_identification'=>['label'=> $this->extras['company_identification']],  
                                            'company_position'=>['label'=> $this->extras['company_position']],  
                                            'industry_type'=>['label'=> $this->extras['industry_type'], 'type' => 'select', 'options' => $industryType],  
                                            //'equipment_buy_status'=>['label'=> $this->extras['equipment_buy_status'], 'type' => 'select', ],  
                                                  ],                                          
                        ]; 


            $this->set('tablesData', $tablesData);

                                     
            if(!$this->request->is('get')) {

                  //peticion post guardar   
                       
                    $data=$this->request->data;
                    
                    //validamos campo vacio de password
                    if(empty($data['password'])){     
                            unset($data['password']);
                    }

                    $dato = $this->Users->get($id);
                    $user = $this->Users->patchEntity($dato, $data, ['validate' => true]);

                        if($this->Users->save($user)) {            
                         
                            if($this->Auth->user('id') === $id) {
                                $this->Auth->setUser($user->toArray());
                                $this->redirect(array('action' => 'profile')); 
                            }
                        
                            $this->Flash->exito(__d('administrator', 'Usuario actualizado'));

                        } else { 

                            $this->Flash->alerts(__d('administrator', 'No se pudo guardar')); 

                        }

            }

    }
    
     public function profile() {

            $estado=$this->Users->schema()->column('type');
            $estado=$estado['comment'];
            preg_match_all("/'(.*?)'/", $estado, $type);
            $status=array_combine($type[1], $type[1]);

          
          //Define el Theme del Formulario.
          $this->set('template', Configure::read('Template_Form.pass'));

          $userId = $this->Auth->user('id');
          $profile=$this->Users->get($userId, ['contain' => ['Roles'],]);

            $publications = $this->Users->Posts->find('All', ['conditions' => ['Posts.user_id' => $userId]])->count();
            $this->set('publicationsTotal', $publications);

            $totalPublicaciones = $this->Users->Posts->find('All', ['conditions' => ['Posts.user_id' => $userId, 'Posts.type' => 'post']])->count();
            $totalPages = $this->Users->Posts->find('All', ['conditions' => ['Posts.user_id' => $userId, 'Posts.type' => 'page']])->count();

            $totalPosts = ['publication' => ['total' => $totalPublicaciones, 'name' => $this->extras['posts']]];
            $this->set('totalPosts', $totalPosts);

            if(!empty($profile->company_country)) { $companyCountry = [$profile->company_country => $profile->company_country]; } else { $companyCountry = $this->extras['select_default']; }
            if(!empty($profile->company_city)) { $companyCity = [$profile->company_city => $profile->company_city]; } else { $companyCity = $this->extras['select_default']; }

          
          $this->set('user', $profile);

            //tipos de usuario
            $industryType = ['contractor'  => $this->extras['contractor'], 'rental_heavy_equipment'  => $this->extras['rental_heavy_equipment'], 'special_transportation'  => $this->extras['special_transportation'], 
                             'utility_mining_oil'  => $this->extras['utility_mining_oil'], 'new_distrbuitor_parts' => $this->extras['new_distrbuitor_parts'], 'used_distrbuitor_broker' => $this->extras['used_distrbuitor_broker'], 
                             'windowpower' => $this->extras['windowpower'], 'manufacturer' => $this->extras['manufacturer'], 'server_repair' => $this->extras['server_repair'], 
                             'certification_company' => $this->extras['certification_company'], 'others' => $this->extras['others']];

                      $tablesData = ['general_data' => ['name'=>['label'=> $this->extras['name'], 'option'=>''], 
                                            'last_name'=>['label'=> $this->extras['last_name'], 'option'=>''],
                                            //'identification'=>['label'=> $this->extras['identification'], 'option'=>''], 
                                            'tel'=>['label'=>  $this->extras['phone'], 'option'=>''],
                                            'email'=>['label'=> $this->extras['email'], 'option'=>''], 
                                            'code_cel'=>['label'=> $this->extras['indicative']],
                                            'area_cel'=>['label'=> $this->extras['code_area']],
                                            'cel'=>['label'=> $this->extras['celphone'], 'option'=>''],
                                            'password'=>['label'=> $this->extras['password'], 'autocomplete' => 'off', 'value' => ''],
                                            'password_confirm'=>['label'=> $this->extras['confirm_password'], 'type' => 'password'],
                                            //'country'=>['label'=> $this->extras['country']],
                                           ], 
                         
                         'company_data' => [
                                            //'role_id'=> ['type'=>'select', 'options' => $this->roles, 'required', 'empty' => '- Selecciona una opción -', 'label' => $this->extras['rol']], 
                                            //'type'=> ['type'=>'select', 'options' => $status, 'required', 'empty' => '- Selecciona una opción -', 'label' => $this->extras['plan']], 
                                            'company_name'=>['label'=> $this->extras['company_name']], 
                                            'company_email'=>['label'=> $this->extras['company_email']], 
                                            'company_address'=>['label'=> $this->extras['company_address']], 
                                            'company_country'=>['label'=> $this->extras['company_country'], 'class' => 'country', 'type' => 'select', 'empty' => $companyCountry ], 
                                            'company_state'=>['label'=> $this->extras['state'], 'class' => 'state', 'type' => 'select', 'empty' => $companyCity], 
                                            'company_city'=>['label'=> $this->extras['company_city'], 'class' => 'city', 'type' => 'select', 'empty' => $companyCity], 
                                            'company_code_tel'=>['label'=> $this->extras['indicative']], 
                                            'company_area_tel'=>['label'=> $this->extras['code_area']], 
                                            'company_tel'=>['label'=> $this->extras['company_tel']], 
                                            'company_identification'=>['label'=> $this->extras['company_identification']],  
                                            'company_position'=>['label'=> $this->extras['company_position']],  
                                            'industry_type'=>['label'=> $this->extras['industry_type'], 'type' => 'select', 'options' => $industryType],  
                                            //'equipment_buy_status'=>['label'=> $this->extras['equipment_buy_status'], 'type' => 'select', ],  
                                            ],                                        
                        ]; 

        $this->set('tablesData', $tablesData);

          

        if(!$this->request->is('get')) {

          //peticion post guardar   
               
            $data=$this->request->data;
            
            //validamos campo vacio de password
            if(empty($data['password'])){
                unset($data['password']);
            }
            
            $dato = $this->Users->get($userId);
            $user = $this->Users->patchEntity($dato, $data, ['validate' => true]);
            $val=$this->Users->newEntity($data);
            
            if ($val->errors() and !$this->Users->save($user)) {
                // Entity failed validation.
                //echo pr($val->errors());
                $this->Flash->validation('Ha ocurrido un error.',[
                    'params' => [
                        'error' => [$val->errors()],
                        
                    ]]);
            }else{

                if($this->Users->save($user)) {            
                $this->Flash->exito(__d('administrator', 'Usuario actualizado'));
                  
                  $this->Auth->setUser($user->toArray());
                 $this->redirect(array('action' => 'profile')); 
                
                } else { 
                $this->Flash->alerts(__d('administrator', 'No se pudo guardar')); 
                }
            }

        }



              
        }

  
        

    
    public function login() {
        
        //echo pr($this->Auth->user());
        //$datosLocalozacion =$this->request->cookies['ssupp_geoloc'];

       if ($this->Auth->user()){
                return $this->redirect($this->Auth->redirectUrl());
        }

            if ($this->request->is('post')) {
                $user = $this->Auth->identify();
                
                if ($user and $user['status']=='active') {
                    $this->request->session()->delete('attempt');
                    $this->Auth->setUser($user);
                    return $this->redirect($this->Auth->redirectUrl());
                }
                
                $conteo=$this->request->session()->read('attempt');
                if($conteo==0 or $conteo== null){
                    $conteo=1;
                }else{
                    $conteo++;
                }

                $this->request->session()->write('attempt', $conteo);
                if($conteo>=3){
                    $this->Flash->alerts(__d('administrator', 'El problema persiste. Por favor contacte con el Administrador.'));
                }else{
                    
                    $this->Flash->alerts(__d('administrator', 'El codigo de usuario no existe.'));
                    return $this->redirect(['action' => '']);

                }

            }  
      
        

    }


 

        
    public function logout() {
        $this->Flash->exito(__d('administrator', 'La sesion se ha cerrado correctamente.'));
        $this->redirect($this->Auth->logout());

    }
    
    
    // recuerpar contraseña
    public function forgetpwd(){
            
        if($this->request->is('get')) { // valida que entre unicamente por el popup sin entrar por la URL
            //throw new MethodNotAllowedException();
        } elseif($this->request->is('post')) {

                $user = $this->Users->findByEmailAndStatus($this->request->data['email'], 'active')->first();
                
                if(isset($user) && !empty($user)) {

                    $key = Security::hash(Text::uuid(),'sha512',true);
                    $hash=sha1($user->identification.rand(0,100));
                    $url = Router::url(['controller'=>'Users','action'=>'reset'], true ).'/'.$key.'#'.$hash;
                    $ms=$url;
                    $ms=wordwrap($ms,1000);

                    $datoUsuario = $this->Users->patchEntity($user, ['tokenhash' => $key]);
                    $this->Users->save($datoUsuario);

                    //agregamos variables para el correo de información
                                       $subject = __d('administrator', 'Has solicitado el cambio de contraseña en:').' '.$this->blogName;
                                       $logo = 'http://'.$this->request->env('HTTP_HOST')."/".$this->Get->get_frontend_images_url('logo');
                                       $description = __d('administrator', 'Este es un mensaje automático. El siguiente es un correo enviado el');
                                       $datosEnvio = ['logo' => $logo,
                                                      'name' => $user->name,
                                                      'email' => $this->request->data['email'], 
                                                      'tokenUrl' => $url,   
                                                      'blogName' => $this->blogName, 
                                                      'subject' => $subject,
                                                      'description' => $description];

                                                    //email de contactenos
                                                    $email = new Email('default');
                                                    $email->emailFormat('html') //tipo de mensaje (plantilla en html)
                                                          ->template('Front.default', 'Front.default') //template default (Contacto) del email y Layout del email (TEMPLETE / LAYOUT)
                                                          ->from([$this->noReply => $this->blogName])
                                                          ->to($this->request->data['email'])
                                                          ->subject($subject)
                                                          ->viewVars($datosEnvio)
                                                          ->send();


                    $this->Flash->exito(__d('administrator', 'Revisa tu correo electrónico, hemos enviado una URL para reestablecer tu contraseña'));
                    $this->redirect(['action' => 'login']);

                }  else { 

                    $this->Flash->alerts(__d('administrator', 'El correo electrónico no se encuentra registrado.'));
                    $this->redirect(['action' => 'login']);

                }            
        
        }

    
    }


    public function reset($token=null) {

            if(isset($token) && !empty($token)){

                    $usuario = $this->Users->findByTokenhash($token)->first();
                    $user = $this->Users->get($usuario->id);


                    if($this->request->is('post') && isset($user) && !empty($user)) {
                        
                        if($this->request->data['password'] == $this->request->data['password_confirmation']) {

                            $datoUsuario = $this->Users->patchEntity($user, ['password' => $this->request->data['password'], 'tokenhash' => NULL]);
                            $this->Users->save($datoUsuario);

                            $this->Flash->exito(__d('administrator', 'Usuario actualizado'));

                        }

                    }
            
            } else {

                $this->Flash->exito(__d('administrator', 'Lo sontimos, el token ya fue utilizadouse Cake\Mailer\Email;
                    '));
                $this->redirect(['action' => 'login']);

            }

    }
    

    public function trash() {
     
      $inactivos = $this->Users->find('all', ['conditions' => ['Users.status = ' => 'inactive']]); 
      $inactivos = $inactivos->count();
      if($inactivos==0){

            $this->Flash->alerts(__d('administrator', 'No hay usuarios en la papelera.'));
            $this->redirect(['action' => 'index']);

      }else{

            if($this->request->is('post')) {
            if($this->request->data['checkbox']) {
                 
                foreach($this->request->data['checkbox'] as $userID) {
                    //$this->Users->id = $userID;
                   $data=['status' => 'active'];
                   $dato = $this->Users->get($userID);
                   $user = $this->Users->patchEntity($dato, $data,  ['validate' => false]);            
                   $this->Users->save($user);
                }
                
                $this->Flash->exito(__d('administrator', 'Usuarios restaurados'));
                $this->redirect(['action' => 'index']);
                
                }
            }
        
            $this->render('index');
      }  
    }
    

    //mandar usuarios a papelera individualmente
    public function clear($id) {
           
           
            if($this->request->is('get')) { 
            throw new MethodNotAllowedException();
            } else {

                   $data=['status' => 'inactive'];
                   $dato = $this->Users->get($id);
                   $user = $this->Users->patchEntity($dato, $data,  ['validate' => false]);            
                   $this->Users->save($user);
                   $this->Flash->alerts(__d('administrator', 'El usuario se ha enviado a papelera'));
                   $this->redirect(array('action' => 'index'));     
            }
    }
    

    //restaurar usuarios de papelera individualmente
    public function restore($id) {
           
           
            if($this->request->is('get')) { 
            throw new MethodNotAllowedException();
            } else {
                   $data=['status' => 'active'];
                   $dato = $this->Users->get($id);
                   $user = $this->Users->patchEntity($dato, $data,  ['validate' => false]);            
                   $this->Users->save($user);
                   $this->Flash->exito(__d('administrator', 'El usuario se ha actualizado'));
                   $this->redirect(array('action' => 'index'));     
            }
    }
    

    public function delete($id) {
    
            if($this->request->is('get')) { 
            throw new MethodNotAllowedException();
            } else {
                $data=['status' => 'removed'];
                $dato = $this->Users->get($id);
                $user = $this->Users->patchEntity($dato, $data,  ['validate' => false]);            
                $this->Users->save($user);
                $this->Flash->exito(__d('administrator', 'El usuario se ha eliminado con éxito.'));
                $this->redirect(array('action' => 'index')); 
            }
    }

    public function view($id)
    {
        if (!$id) {
            throw new NotFoundException(__d('administrator', 'Invalid user'));
        }

        $user = $this->Users->get($id);
        $this->set(compact('user'));
    }
    


	



}


?>