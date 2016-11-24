<?php

namespace Front\Controller;

use Front\Controller\AppController;

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

use Cake\I18n\I18n;

class UsersController extends AppController {  

    // tipos de industria y equipamento toca asi para poder usar el $this-> como variable global no funciona y en componentes el this tampoco arranca

    public function industryType($name = NULL) {

    $industryType = ['contractor'  => $this->extras['contractor'], 'rental_heavy_equipment'  => $this->extras['rental_heavy_equipment'], 'special_transportation'  => $this->extras['special_transportation'], 
                     'utility_mining_oil'  => $this->extras['utility_mining_oil'], 'new_distrbuitor_parts' => $this->extras['new_distrbuitor_parts'], 'used_distrbuitor_broker' => $this->extras['used_distrbuitor_broker'], 
                     'windowpower' => $this->extras['windowpower'], 'manufacturer' => $this->extras['manufacturer'], 'server_repair' => $this->extras['server_repair'], 
                     'certification_company' => $this->extras['certification_company'], 'others' => $this->extras['others']];

                        //$clave = array_search($name, $industryType);

                        if($name == NULL) {
                                return $industryType;
                        } else {

                            return $industryType[$name];
                        }
                        
    }



    public function beforeFilter(\Cake\Event\Event $event) {
    parent::beforeFilter($event);
        
         /***** variables de seleccion tipo de empresa etc *****/

        $this->set('industryType', $this->industryType());

        $equipmentStatus = ['equipment_new'  => $this->extras['new_equipment'],'signup'  => $this->extras['new_equipment'], 'used_equipment'  => $this->extras['used_equipment'], 'dont_buy_equipment'  => $this->extras['dont_buy_equipment'], ];

        $this->set('equipmentStatus', $equipmentStatus);


    }

    public function access() {  
   
            if(isset($_COOKIE['token'])){

                $token=$_COOKIE['token'];
                $respuesta = @file_get_contents("https://graph.facebook.com/me?fields=id,name,gender,email,first_name,last_name&access_token=".$token."", true);
            
                        if ($respuesta === false) {
                            $this->redirect('/users/logout');
                        }

                        $datos = json_decode($respuesta,true);

                        unset($_COOKIE['token']);
                        setcookie("token", "", time()-3600);
                        $user = TableRegistry::get('Administrator.Users');
                        $usuario=$user->find('all', ['conditions'=>['Users.fb_uid'=>$datos['id']]]);
            
                        if($usuario->count()==0){
                            
                            $data=['fb_uid'=>$datos['id'], 'name'=>$datos['first_name'], 'last_name'=>$datos['last_name'], 'fb_email'=>$datos['email'], 'email'=>$datos['email'], 'genero'=>$datos['gender'], 'term'=>0];
                            $save=$user->newEntity($data);
                            if ($user->save($save) ){

                                $this->request->session()->write('Auth.User.id', $save->id);
                                $this->request->session()->write('Auth.User.name', $datos['name']);
                                $this->request->session()->write('Auth.User.company_name', '');
                                $this->request->session()->write('Auth.User.company_position', '');
                                $this->request->session()->write('Auth.User.industry_type', '');
                                $this->request->session()->write('Auth.User.equipment_type', '');
                                $this->request->session()->write('Auth.User.equipment_buy_status', '');

                                //$this->Flash->exito(__d('front', 'Usuario creado.'));
                            }

                        } else {

                            $perfil=$usuario->first();
                           

                            //$token=$this->request->session()->read('Player.token');
                            $respuesta = @file_get_contents("https://graph.facebook.com/me/friends?limit=40&access_token=".$token."", true);
                            if ($respuesta === false) {
                                $this->redirect('/users/logout');
                            }
                            $datos2 = json_decode($respuesta,true);
                            $conteo=count($datos2['data']);
                            $allfriends=$datos2['summary']['total_count'];
                            $amigos=$conteo.'/'.$allfriends;

                            $data=['name'=>$datos['first_name'], 'last_name'=>$datos['last_name'], 'fb_friends'=>$amigos, 'fb_email'=>$datos['email'], 'genero'=>$datos['gender']];
                            $save = $user->patchEntity($perfil, $data,  ['validate' => false]); 

                                if ($user->save($save) ){
                                    $this->request->session()->write('Auth.User.id', $perfil->id);
                                    $this->request->session()->write('Auth.User.name', $datos['name']);
                                    $this->request->session()->write('Auth.User.role_id', $perfil->role_id);

                                    if($perfil->role_id <= 2) {

                                        $this->request->session()->write('Auth.User.company_name', $perfil->company_name);
                                        $this->request->session()->write('Auth.User.company_position', $perfil->company_position);
                                        $this->request->session()->write('Auth.User.industry_type', $perfil->industry_type);
                                        $this->request->session()->write('Auth.User.equipment_type', $perfil->equipment_type);
                                        $this->request->session()->write('Auth.User.equipment_buy_status', $perfil->equipment_buy_status);


                                    }
                                }

                        }
                

                $this->request->session()->write('Auth.User.token', $token);
                //$this->redirect($this->request->session()->read('URL'));
                $this->redirect('/'); 


            } else {

                $this->redirect('/');         

            }

    }


    public function index() { 

       // I18n::locale('es');


    $users = TableRegistry::get('Administrator.Users');
    $posts = TableRegistry::get('Administrator.Posts');
    $countries = TableRegistry::get('Administrator.Countries');
    $cities = TableRegistry::get('Administrator.Cities');
    $i18n = TableRegistry::get('Administrator.i18n');
         

        //todos los usuarios con un role id menor a 3 que es el usuario que visita
        $roleCliente = 3;
        //usuario con el tipo de usaurio diferente a basico aparecerán en el directorio
        $userType = 'Basic';     

        $this->paginate = ['conditions' => ['Users.role_id <' => $roleCliente, 'Users.status' => $this->active, 'Users.type !=' => $userType], 
                           'order' => ['Users.type' => 'desc'], 
                           'fields' => ['id', 'name', 'company_name', 'company_country', 'company_city', 'company_state', 'company_address', 'company_email', 'type', 'role_id', 'archive_id', 'industry_type'], 
                           'contain' => ['Roles'], 
                           'limit'=>60
                          ];

        //buscador
        if(isset($this->request->query['company']) && !empty($this->request->query['company'])) {

            $s = $this->request->query['company']; // palabra clave del buscador de empresas


            $empresas = $users->find('all', ['conditions' => ['Users.status' => $this->active]])
                              ->where(['Users.name LIKE' => '%'.$s.'%'])
                              ->orWhere(['Users.company_name LIKE' => '%'.$s.'%'])
                              ->orWhere(['Users.email LIKE' => '%'.$s.'%'])
                              ->orWhere(['Users.company_email LIKE' => '%'.$s.'%'])
                              ->orWhere(['Users.company_country' => $s])
                              ->orWhere(['Users.company_city' => $s])
                              ->orWhere(['Users.company_state LIKE' => '%'.$s.'%'])
                              ->orWhere(['Users.industry_type LIKE' => $s])
                              ->orWhere(['Users.company_zip_code LIKE' => '%'.$s.'%']);
        } else {

           $empresas = $users;
        }

        $losusuarios = $this->paginate($empresas); 
        $this->set('users', $losusuarios);

        //todas las gruas para que salgan en el mapa.
        //$allPosts = $posts->find('all', ['conditions' => ['Posts.type' => 'Post', 'Posts.status' => $this->active]])->contain(['Fields', 'Users']);  


        $allPosts = $allPosts = $posts->find('all', ['conditions' => ['Posts.type' => 'Post', 'Posts.status' => $this->active]])->contain(['Fields', 'Users'])
                                      ->matching('FieldsPosts', function ($q) {
                                          return $q->where(['FieldsPosts.value' => 'ALQUILER'])
                                                   ->orWhere(['FieldsPosts.value' => 'RENT']);
                                }); 

        $this->set('posts', $allPosts);





    }

    

    public function terminos() {   

       parent::customer();

        $user = TableRegistry::get('Administrator.Users');
        
        $usuario=$user->get($this->Auth->user('id'));


            if(isset($usuario) && !empty($usuario)) {
        
                    $this->set('usuario',$usuario);   

                    //LLamos el ID de terminos y condiciones
                    $posts = TableRegistry::get('Administrator.Posts');
                    $term= $posts->find('all', ['conditions' => ['Posts.location' => 'Terms']])->first();
                    $this->set('terminos',$term);


                    //Imagen FB
                    $this->set('imagen', 'https://graph.facebook.com/'.$usuario->fb_uid.'');

                    if($this->request->is('get')) {

                    }else{
                        //echo pr($this->request->data['file']);
                        if($this->request->data['term']==1 ) {  

                                //if($this->request->data['file']['error']==0) {

                                        $final=$this->request->data;
                                        $save = $user->patchEntity($usuario, $final); 
                                        if ($user->save($save)) {

                                            //Log
                                            $add='Aceptó terminos y condiciones.';
                                            $this->Function->logs($usuario->id,$add);
                                            //Log

                                            $this->redirect(['action' => 'profile']);

                                       }    

                        }else{
                            $this->Flash->alerts(__d('front', 'Ha ocurrido un error. Por favor intente de nuevo.'));
                        }

                    }

            } else {

                $this->redirect(['controller' => 'Front', 'action' => 'index']);

            }


    }



    public function add_user() {
    $users = TableRegistry::get('Administrator.Users');
    $news = TableRegistry::get('Administrator.Newsletters');
        

        if($this->request->is('post')) {

                if($this->Cookie->read('anti') == $this->request->data['anti']) {

                        $email = $this->request->data['email'];
                        $count = $users->find('all', ['conditions' => ['Users.email' => $email]])->count();


                                    $newUser = $users->newEntity();

                                    if(isset($this->request->data['company_name'])) { //si se esta creando como usuario agregar el rol con tipo 2
                                        $userData = array_merge(['role_id' => 2], $this->request->data);
                                    } else {
                                        $userData = $this->request->data;
                                    }

                                    $user = $users->patchEntity($newUser, $userData);
                                    
                                    if ($users->save($user)) {
                                        $this->Auth->setUser($user->toArray());
                                    } 


                                    $save = $news->newEntity(['email' => $this->request->data['email']]);
                                    $news->save($save);

                                    //agregamos variables para el layout datos de usuario.
                                       $subject = __d('front', 'Te has registrado exitosamente en '). $this->blogName;
                                       $description = __d('front', 'Este es un mensaje automático. El siguiente es un correo enviado el');
                                       $datosEnvio = array_merge(['logo' => $this->Get->get_frontend_images_url('logo'), 'blogName' => $this->blogName, 'subject' => $subject, 'description' => $description], $this->request->data);

                                                    //email de contactenos
                                                    $email = new Email('default');
                                                    $email->emailFormat('html') //tipo de mensaje (plantilla en html)
                                                          ->template('Front.default', 'Front.default') //template default (Contacto) del email y Layout del email (TEMPLETE / LAYOUT)
                                                          ->from([$this->noReply => $this->blogName])
                                                          ->to($this->request->data['email'])
                                                          ->addTo($this->blogEmail, 'Administrator')
                                                          ->subject($subject)
                                                          ->viewVars($datosEnvio)
                                                          ->send();

                                    $this->redirect(['controller' => 'Users', 'action' => 'profile']); 
                                    $this->Flash->exito(__d('front', 'Perfil generado correctamente. Completa los datos de tu empresa para continuar'));

                    } else {

                                    $this->redirect(['controller' => 'Front', 'action' => 'index']);
                                    $this->Flash->alerts(__d('front', 'Lo sentimos, el usuario no se ha creado, intentalo nuevamente'));

                    }

            
        } else {

            $this->redirect(['controller' => 'Front', 'action' => 'index']); 
            $this->Flash->alerts(__d('front', 'Lo sentimos, no se ha podido crear el usuario'));

        }
    
        //$this->render('/Default/index');
        
    }



    public function site() {   
        
        $users = TableRegistry::get('Administrator.Users');
        $posts = TableRegistry::get('Administrator.Posts');

        if(isset($this->id)) {
            $userId = $this->id;            
        } else {
            $userId = $this->Auth->user('id');
        }

        $user = $users->get($userId, ['contain' => ['Roles'],]);

        $this->set('user', $user);
        $this->set('id', $userId);

        //buscar gruas disponibles para alquiler
        $userAlquiler = $posts->find('all', ['conditions' => ['Posts.user_id' => $userId, 'Posts.type' => 'Post', 'Posts.status' => $this->active]])->contain(['Fields']);    
        $alquiler = $userAlquiler->matching('FieldsPosts', function ($q) {
                   return $q->where(['FieldsPosts.field_id' => 5]) // id del campo personalizado disponible.
                            ->andWhere(['FieldsPosts.value' => 'ALQUILER']);
                 });

        // buscar gruas disponibles para la venta (finds inividuales para hacer el query)
        $userVenta = $posts->find('all', ['conditions' => ['Posts.user_id' => $userId, 'Posts.type' => 'Post', 'Posts.status' => $this->active]])->contain(['Fields']);
        $venta = $userVenta->matching('FieldsPosts', function ($q) {
                   return $q->where(['FieldsPosts.field_id' => 5]) // id del campo personalizado disponible.
                            ->andWhere(['FieldsPosts.value' => 'VENTA']);
                 });


        //datos del usuario como array
        $userData = ['company_name' => $user->company_name, 'tel' => $user->company_tel, 'email' => $user->company_email, 'name' => $user->name.' '.$user->last_name,  'company_position' => $user->company_position, 
                     'country' => $user->company_country, 'state' => $user->company_state, 'city' => $user->company_city, 'postal_code' => $user->company_postal_code,
                     ];


        $this->set('userData', $userData);


        $avalible = ['ALQUILER' => $alquiler->toArray(), 'VENTA' => $venta->toArray()];
        $this->set('avalible', $avalible);

        //todas las gruas para que salgan en el mapa.
        $allPosts = $posts->find('all', ['conditions' => ['Posts.type' => 'Post', 'Posts.status' => $this->active, 'Posts.user_id' => $userId]])->contain(['Fields']);  
        $this->set('posts', $allPosts);  

        $score = TableRegistry::get('Administrator.Score');
        $star = $score->find('all', ['conditions' => ['Score.author_id' => $this->id]])->first();  
        
        if($star){
        
            $this->set('stars', $star->score);  
        
        }else{
        
            $this->set('stars', 5);  
        
        }


        



    }




    public function profile() {   
        
        $users = TableRegistry::get('Administrator.Users');
        $posts = TableRegistry::get('Administrator.Posts');
        $oferts = TableRegistry::get('Administrator.SellRent');
        $equipments = TableRegistry::get('Administrator.Equipments');
        $usersEquipments = TableRegistry::get('Administrator.UsersEquipments');
        $countries = TableRegistry::get('Administrator.countries');
        $payments = TableRegistry::get('Administrator.Payments');

        $id = $this->Auth->user('id');
        $profile = $users->get($id, ['contain' => ['Roles', 'Equipments', 'Payments']]);
        $this->set('user', $profile);

       

        if(isset($profile->payments) && !empty($profile->payments[0])) {

            $datoPago = $profile->payments[0];
            $pagos = $datoPago;

        } else {
            $pagos = array();
        }

        $this->set('datoPago', $pagos);
  
        /********** validar si estoy como premium pagando ******/

        $userActualPay = $payments->find('all', ['conditions' => ['Payments.user_id' => $id], 'fields' => ['date_end_plan'] ])->last();
        $actualDate = date('Y-m-d');

        //validar si existe un registro en la DB de algun pago y validar si la fecha es igual a la actual para bajar el plan a premium, validar si el usuario no es un administrador
        if(!empty($userActualPay) && $userActualPay->date_end_plan == $actualDate && $profile->role_id > 1) {

                $dato = $users->get($id);
                $user = $users->patchEntity($dato, ['type' => 'Basic']);

                //actualizar los datos del usuario cuando se acabe su plan premium a basico
                $this->Auth->setUser(['type' => 'Basic']);
                $users->save($user);
        }

        /**** codigos telfonoicos ****/

        $codeTel = $profile->code_tel;
        $areaTel = $profile->area_tel;
        
        $codeCel = $profile->code_tel;
        $areaCel = $profile->area_cel;
                
        $companyCodeTel = $profile->company_code_tel;
        $companyAreaTel = $profile->company_area_tel;

        $this->set('codes', ['code_tel' => $codeTel, 'area_tel' => $areaTel, 'code_cel' => $codeCel, 'area_cel' => $areaCel, 'company_code_tel' => $companyCodeTel, 'company_area_tel' => $companyAreaTel]);

        //tipos de equipamento
        $equipamento = $equipments->find('list');
        $this->set('equipamento', $equipamento);

        //equipamento para cada usuario (UsersEquipments)
        $userEquipment = $usersEquipments->find('list', ['conditions' => ['UsersEquipments.user_id' => $profile->id]])->toArray();
        $this->set('userEquipment', $userEquipment);

        /****** variables del usuario ****/

        // rol de la impresa ID
        $empresa_id = 2;
        $this->set('empresa_id', $empresa_id);

        //variable id
        $id = $profile->id;
        $this->set('id', $id);

        //variables condicionales por el tipo de usuario
        if($profile->role_id <= $empresa_id) {
              $address = $profile->company_address; 
              $city = $profile->company_city; 
              $name = $profile->company_name; 
              $email = $profile->company_email;
        } else {
              $address = NULL; 
              $city = $profile->city; 
              $name = $profile->name; 
              $email = $profile->email;
        }

        $this->set('address', $address);
        $this->set('city', $city);
        $this->set('name', $name);
        $this->set('email', $email);

        if(!empty($profile->company_country)) { $companyCountry = [$profile->company_country => $profile->company_country]; } else { $companyCountry = $this->extras['select_default']; }
        if(!empty($profile->company_city)) { $companyCity = [$profile->company_city => $profile->company_city]; } else { $companyCity = $this->extras['select_default']; }
        if(!empty($profile->company_state)) { $companyState = [$profile->company_state => $profile->company_state]; } else { $companyState = $this->extras['select_default']; }

        $this->set('company_country', $companyCountry);
        $this->set('company_city', $companyCity);
        $this->set('company_state', $companyState);



        /***** datos de las gruas del usuario ****/

        $id = $this->Auth->user('id');
        $this->paginate = ['conditions' => ['SellRent.author_id' => $id, 'SellRent.status !=' => $this->inactive, 'SellRent.status !=' => 'deny', 'SellRent.type !=' => 0], 'limit'=> 100000, 'order' => ['SellRent.id' => 'DESC']];
        $postsSell = $this->paginate($oferts); 
        $this->set('postsSell', $postsSell);

        $this->paginate = ['conditions' => ['SellRent.author_id' => $id, 'SellRent.status !=' => $this->inactive, 'SellRent.status !=' => 'deny', 'SellRent.type' => 0], 'limit'=> 100000, 'order' => ['SellRent.id' => 'DESC']];
        $postsRent = $this->paginate($oferts); 
        $this->set('postsRent', $postsRent);
        

                if(!$this->request->is('get')) {
                                        
                        //cambios de información de ususarios
                        if(isset($this->request->data['update']) || isset($this->request->data['company_update']) || isset($this->request->data['change']) || isset($this->request->data['role_id'])) {
                            
                            $dato = $users->get($id);
                            $user = $users->patchEntity($dato, $this->request->data, ['associated' => ['Equipments'] ]);

                            //actualizar los datos de autenticación
                            $this->Auth->setUser($user->toArray());

                            if($users->save($user)) {

                                    if(isset($this->request->data['password']) && !empty($this->request->data['password'])) {

                                           //agregamos variables para el layout datos de usuario.
                                           $subject = __d('front', 'Has actualizado los datos de tu perfil '). ' ' . __d('front', ' En ') . $this->blogName;
                                           $description = __d('front', 'Este es un mensaje automático. El siguiente es un correo enviado el');
                                           $datosEnvio = array_merge(['logo' => $this->Get->get_frontend_images_url('logo'), 'name' => $dato->name, 'email' => $dato->email,  'blogName' => $this->blogName, 'subject' => $subject, 'description' => $description], $this->request->data);

                                                        //email de contactenos
                                                        $email = new Email('default');
                                                        $email->emailFormat('html') //tipo de mensaje (plantilla en html)
                                                              ->template('Front.default', 'Front.default') //template default (Contacto) del email y Layout del email (TEMPLETE / LAYOUT)
                                                              ->from([$this->noReply => $this->blogName])
                                                              ->to($dato->email)
                                                              ->subject($subject)
                                                              ->viewVars($datosEnvio)
                                                              ->send();
                                    }


                                    $this->redirect(array('action' => 'profile')); 
                                    $this->Flash->exito(__d('front', 'Perfil actualizado'));
            
                            } 
                        }

                        if(isset($this->request->data['sell_rent_id']) && !empty($this->request->data['sell_rent_id'])) {
                        
                           $offerData = $oferts->get($this->request->data['sell_rent_id']);
                           $saveOffer = $oferts->patchEntity($offerData, ['counteroffer' => $this->request->data['counteroffer']]);
                           $oferts->save($saveOffer);

                                       //agregamos variables para el layout datos de usuario.
                                       $subject = __d('front', 'Estado de oferta para el producto '). $this->Get->get_name($offerData->post_id, 'Posts') .' '. __d('front', ' En ') .' '. $this->blogName;
                                       $description = __d('front', 'Este es un mensaje automático. El siguiente es un correo enviado el').' ';
                                       $datosEnvio = ['logo' => $this->Get->get_frontend_images_url('logo'),
                                                      'offer_type' => $offerData->type, 
                                                      'status' => $estado, 
                                                      'product' => $this->Get->get_name($offerData->post_id, 'Posts'), 
                                                      'code' => $this->extras['code']. '-'.$offerData->post_id,
                                                      'name' => $this->Get->get_company_name($offerData->user_id, 'Users'),
                                                      'email' => $this->Get->get_user_email($offerData->user_id),
                                                      'value' => $offerData->value,  
                                                      'counteroffer' => $offerData->counteroffer,  
                                                      'blogName' => $this->blogName, 
                                                      'subject' => $subject, 
                                                      'description' => $description
                                                      ];

                                                    //email de contactenos
                                                    $email = new Email('default');
                                                    $email->emailFormat('html') //tipo de mensaje (plantilla en html)
                                                          ->template('Front.default', 'Front.default') //template default (Contacto) del email y Layout del email (TEMPLETE / LAYOUT)
                                                          ->from([$this->noReply => $this->blogName])
                                                          ->to($this->Get->get_user_email($offerData->user_id))
                                                          ->addTo($this->blogEmail, 'Admin')
                                                          ->subject($subject)
                                                          ->viewVars($datosEnvio)
                                                          ->send();


                           $this->Flash->alerts(__d('front', 'Contraoferta generada exitosamente, se ha enviado el correo')); 


                        }
      
                }

    }


    public function return_pay() {
    $users = TableRegistry::get('Administrator.Users');
    $payments = TableRegistry::get('Administrator.Payments');

            if($this->request->is('post') && isset($this->request->data)) {
                    

                //nueva entrada de pagos
                $newPayment = $payments->newEntity();


                $saveData = array_merge($this->request->data, ['user_id' => $this->request->data['custom'], 'plan' => $this->request->data['option_name1'], 'date_start_plan' => $this->request->data['option_name2'], 'date_end_plan' => $this->request->data['option_name3']]);


                            //validar si ya existe este registro para no guardarlo más de 1 vez
                            $getPayment = $payments->find('all', ['conditions' => ['Payments.txn_id' => $this->request->data['txn_id']] ])->count();

                            if($getPayment == 0) {
                                    
                                    $pay = $payments->patchEntity($newPayment, $saveData);
                                    $payments->save($pay);

                            }

                            //actualizar el usuario si existe custom porque custom es id de usuario y si es premium el pago que se generará
                            if($this->request->data['custom'] && !empty($this->request->data['custom']) && $this->request->data['option_name1'] == 'Premium') {

                                $userId = $this->request->data['custom'];
                                $user = $users->get($userId);
                                $userSave = $users->patchEntity($user, ['type' => $this->request->data['option_name1']]);
                                $users->save($userSave);        

                                $this->Auth->setUser($user->toArray()); //actualizar la session activa

                                $this->set('data', $saveData);

                            }

                            

                        $this->Flash->exito(__d('front', 'La transaccion se ha generado'));


            } else {


                $this->Flash->exito(__d('front', 'Lo sentimos no puedes ingresar en este momento'));
                $this->redirect($this->referer()); 


            }


    }


    public function notify_pay() {
    $users = TableRegistry::get('Administrator.Users');

        $this->render('/Default/index');


    }

    public function my_offers() {
    $sellRents = TableRegistry::get('Administrator.SellRent');
    $users = TableRegistry::get('Administrator.Users');

    $id = $this->Auth->user('id');
   
    $offers = $sellRents->find('all', ['conditions' => ['SellRent.user_id' => $id, 'SellRent.status !=' => $this->inactive], 'limit'=> 100000, 'order' => ['SellRent.id' => 'DESC']]);  
    $posts = $this->paginate($offers); 
    $this->set('posts', $posts);

    }


    public function deny() {
    $offers = TableRegistry::get('Administrator.SellRent');
    $users = TableRegistry::get('Administrator.Users');

    $estado = __d('front', 'Rechazada');
    $id = $this->id;
    $oferta = $offers->get($id);
    $save = $offers->patchEntity($oferta, ['status' => 'deny']);
    $offers->save($save);

     //agregamos variables para el correo de información
                                       $subject = __d('front', 'Estado de su oferta en'). ': ' .$this->blogName;
                                       $description = __d('front', 'Este es un mensaje automático. El siguiente es un correo enviado el').' ';
                                       $datosEnvio = ['logo' => $this->Get->get_frontend_images_url('logo'),
                                                      'offer_type' => $oferta->type, 
                                                      'status' => $estado, 
                                                      'product' => $this->Get->get_name($oferta->post_id, 'Posts'), 
                                                      'code' => $this->extras['code']. '-'.$oferta->post_id,
                                                      'name' => $this->Get->get_company_name($oferta->user_id),
                                                      'email' => $this->Get->get_user_email($oferta->user_id),
                                                      'offer_date' => date_format($oferta->date_start, 'Y-m-d'),
                                                      'value' => $oferta->value,  
                                                      'blogName' => $this->blogName, 
                                                      'subject' => $subject, 
                                                      'description' => $description];

                                                    //email de contactenos
                                                    $email = new Email('default');
                                                    $email->emailFormat('html') //tipo de mensaje (plantilla en html)
                                                          ->template('Front.default', 'Front.default') //template default (Contacto) del email y Layout del email (TEMPLETE / LAYOUT)
                                                          ->from([$this->noReply => $this->blogName])
                                                          ->to($this->Get->get_user_email($oferta->user_id))
                                                          ->addTo($this->blogEmail, 'Admin')
                                                          ->subject($subject)
                                                          ->viewVars($datosEnvio)
                                                          ->send();


    //vista vacia
    $this->render('/Default/index');

    $this->redirect(array('action' => 'profile')); 
    $this->Flash->exito(__d('front', 'Oferta denegada'));

    }


    public function accept() {
    $offers = TableRegistry::get('Administrator.SellRent');
    $users = TableRegistry::get('Administrator.Users');
    $posts = TableRegistry::get('Administrator.Posts');
    
    $estado = __d('front', 'Aceptada');
    $id = $this->id;
    $oferta = $offers->get($id);
    $save = $offers->patchEntity($oferta, ['status' => 'accept']);
    $offers->save($save);


    $post = $posts->get($oferta->post_id);
    $vendida = $posts->patchEntity($post, ['crane_status' => 1]);
    $posts->save($vendida);

    //agregamos variables para el correo de información
                                       $subject = __d('front', 'Estado de su oferta en'). ': ' .$this->blogName;
                                       $description = __d('front', 'Este es un mensaje automático. El siguiente es un correo enviado el').' ';
                                       $datosEnvio = ['logo' => $this->Get->get_frontend_images_url('logo'),
                                                      'offer_type' => $oferta->type, 
                                                      'status' => $estado, 
                                                      'product' => $this->Get->get_name($oferta->post_id, 'Posts'), 
                                                      'code' => $this->extras['code']. '-'.$oferta->post_id,
                                                      'name' => $this->Get->get_company_name($oferta->user_id, 'Users'),
                                                      'email' => $this->Get->get_user_email($oferta->user_id),
                                                      'offer_date' => date_format($oferta->date_start, 'Y-m-d'),
                                                      'value' => $oferta->value,  
                                                      'blogName' => $this->blogName, 
                                                      'subject' => $subject, 
                                                      'description' => $description];

                                                    //email de contactenos
                                                    $email = new Email('default');
                                                    $email->emailFormat('html') //tipo de mensaje (plantilla en html)
                                                          ->template('Front.default', 'Front.default') //template default (Contacto) del email y Layout del email (TEMPLETE / LAYOUT)
                                                          ->from([$this->noReply => $this->blogName])
                                                          ->to($this->Get->get_user_email($oferta->user_id))
                                                          ->addTo($this->blogEmail, 'Admin')
                                                          ->subject($subject)
                                                          ->viewVars($datosEnvio)
                                                          ->send();

    //vista vacia
    $this->render('/Default/index');

    $this->redirect(array('action' => 'profile')); 
    $this->Flash->exito(__d('front', 'Oferta aceptada'));

    }


    public function pending() {
    $offers = TableRegistry::get('Administrator.SellRent');
    $users = TableRegistry::get('Administrator.Users');

    $estado = __d('front', 'Pendiente');
    $id = $this->id;
    $oferta = $offers->get($id);
    $save = $offers->patchEntity($oferta, ['status' => 'pending']);
    $offers->save($save);

    //agregamos variables para el correo de información
                                       $subject = __d('front', 'Estado de su oferta en'). ': ' .$this->blogName;
                                       $description = __d('front', 'Este es un mensaje automático. El siguiente es un correo enviado el');
                                       $datosEnvio = ['logo' => $this->Get->get_frontend_images_url('logo'),
                                                      'offer_type' => $oferta->type, 
                                                      'status' => $estado, 
                                                      'product' => $this->Get->get_company_name($oferta->post_id, 'Posts'), 
                                                      'code' => $this->extras['code']. '-'.$oferta->post_id,
                                                      'email' => $this->Get->get_user_email($oferta->user_id),
                                                      'name' => $this->Get->get_name($oferta->user_id, 'Users'),
                                                      'offer_date' => date_format($oferta->date_start, 'Y-m-d'),
                                                      'value' => $oferta->value,  
                                                      'blogName' => $this->blogName, 'subject' => $subject, 'description' => $description];

                                                    //email de contactenos
                                                    $email = new Email('default');
                                                    $email->emailFormat('html') //tipo de mensaje (plantilla en html)
                                                          ->template('Front.default', 'Front.default') //template default (Contacto) del email y Layout del email (TEMPLETE / LAYOUT)
                                                          ->from([$this->noReply => $this->blogName])
                                                          ->to($this->Get->get_user_email($oferta->user_id))
                                                          ->addTo($this->blogEmail, 'Admin')
                                                          ->subject($subject)
                                                          ->viewVars($datosEnvio)
                                                          ->send();

    //vista vacia
    $this->render('/Default/index');

    $this->redirect(array('action' => 'profile')); 
    $this->Flash->exito(__d('front', 'Oferta pendiente'));

    }


    public function login() {   

    $user = $this->Auth->identify();

            if(!$this->request->is('get')) {

                if ($user and $user['status']=='active') {
                    $this->request->session()->delete('attempt');
                    $this->Auth->setUser($user);
                    //return $this->redirect($this->Auth->redirectUrl());
                    
                    $this->Flash->exito(__d('front', 'Has ingresado exitosamente'));
                    return $this->redirect($this->referer());                    

                } else {
                    
                    $this->Flash->alerts(__d('front', 'La contraseña o el correo son incorrectos'));
                    return $this->redirect($this->referer());

                }

            }  else {
				
                //$this->redirect(['controller' => 'Front', 'action' => 'index']); 
                //$this->Flash->alerts(__d('front', 'Tu sesión ha terminado'));

            }

    }
	
	public function signup() {   

    $user = $this->Auth->identify();

            if(!$this->request->is('get')) {

                if ($user and $user['status']=='active') {
                    $this->request->session()->delete('attempt');
                    $this->Auth->setUser($user);
                    //return $this->redirect($this->Auth->redirectUrl());
                    
                    //$this->Flash->exito(__d('front', 'Has ingresado exitosamente'));
                    return $this->redirect($this->referer());                    

                } else {
                    
                    $this->Flash->alerts(__d('front', 'La contraseña o el correo son incorrectos'));
                    return $this->redirect($this->referer());

                }

            }  else {
				
                //$this->redirect(['controller' => 'Front', 'action' => 'index']); 
                //$this->Flash->alerts(__d('front', 'Tu sesión ha terminado'));

            }

    }

   

    public function logout() {   

       unset($_COOKIE['token']);
       setcookie("token", "", time()-10600);

       $this->request->session()->destroy();
       //$this->redirect('/');
       //$this->redirect($this->request->session()->read('URL'));
       $this->redirect($this->referer());

       //$this->Flash->alerts(__d('front', 'Tu sesión ha terminado. Esperamos que vuelvas'));

    }



    public function change_password() {   
    $users = TableRegistry::get('Administrator.Users');
             
                  if($this->request->is('get')) { // valida que entre unicamente por el popup sin entrar por la URL
                  
                      throw new MethodNotAllowedException();
                  
                  } elseif($this->request->is('post')) {

                          //obtenemos el usuario por correo
                          $usuario = $users->findAllByEmail($this->request->data['email'])->first();
                          $user = $users->get($usuario->id);

                          if(isset($user) && !empty($user)) {

                              $key = Security::hash(Text::uuid(),'sha512',true);
                              $hash=sha1($user->identification.rand(0,100));
                              $url = Router::url(['plugin' => 'Administrator', 'controller'=>'Users','action'=>'reset'], true ).'/'.$key.'#'.$hash;
                              $ms=$url;
                              $ms=wordwrap($ms,1000);

                              $datoUsuario = $users->patchEntity($user, ['tokenhash' => $key]);
                              $users->save($datoUsuario);

                               //agregamos variables para el correo de información
                                       $subject = __d('front', 'Has solicitado el cambio de contraseña en: '). $this->blogName;
                                       $description = __d('front', 'Este es un mensaje automático. El siguiente es un correo enviado el');
                                       $datosEnvio = ['logo' => $this->Get->get_frontend_images_url('logo'),
                                                      'name' => $user->name,
                                                      'email' => $this->request->data['email'], 
                                                      'password' => $user->identification,   
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



                              $this->Flash->alerts(__d('front', 'Revisa tu correo electrónico'));
                              $this->redirect(['controller' => 'Front', 'action' => 'index']);

                          }  else { 

                              $this->Flash->alerts(__d('front', 'El correo no se encuentra registrado'));
                              $this->redirect(['controller' => 'Front', 'action' => 'index']);

                          }            
                  
                  }




    }



    public function userByEmail() {
    $users = TableRegistry::get('Administrator.Users');

        if($this->request->is('ajax')) { 
            
            $user = $users->findByEmail($this->request->query['email'])->count();


            if($user && !empty($user) && $user != 0) {
                
                echo 1;

            } else {

                echo 0;

            }


            die();

        } else {

            die();

        }

    }





}

