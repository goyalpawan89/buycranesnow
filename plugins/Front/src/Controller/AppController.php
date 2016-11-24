<?php

namespace Front\Controller;

use Cake\Controller\Controller;

use Cake\ORM\TableRegistry;
use Cake\Core\Configure;
use Cake\View\Helper;
use Cake\Controller\Component;
use Cake\View\View; 
use Cake\I18n\I18n;
use Cake\I18n\Number;

class AppController extends Controller {

    // variables globales para buscar usuarios, publicaciones etc activas, inactivas, todas $this->activos; etc...
    public $activos; // conteo publicaciones activas
    public $inactivos;  //conteo publicaciones inactivas
    public $id; 
    public $active; // status active
    public $inactive; // status inactive

    public $blogName; // status inactive
    public $noreply; // status inactive
    public $blogEmail; // status inactive
    public $extras;
    public $info;
    public $pastController;

	public function beforeFilter(\Cake\Event\Event $event) {

        $this->loadComponent('Auth', [
           //'authorize'=> 'Controller',
            'authenticate' => [
                'Form' => [
                    'fields' => [
                        'username' => 'email',
                        'password' => 'password'
                    ]
                ]
            ],
            'loginRedirect' => [
                'controller' => 'Users',
                'action' => 'profile'
            ],
            'loginAction' => [
                'controller' => 'Users',
                'action' => 'login'
            ],
            'unauthorizedRedirect' => $this->referer(),
            'authError' => 'Acceso no Autorizado', 
        ]);

        // Allow the display action so our pages controller
        $this->Auth->allow(['index', 'access', 'add', 'add_user', 'mensajes', 'crane_photos', 'crane_list', 'find', 'terminos', 'simple_search', 'map', 'dom', 'testpdf', 'prpdf', 'change_password', 'userByEmail']);

        $this->loadComponent('Flash');
        $this->loadComponent('RequestHandler');
        $this->loadComponent('Cookie');        
        $this->loadComponent('Paginator');
        $this->loadComponent('Administrator.Function');
        $this->loadComponent('Front.Query');
        $this->loadComponent('Administrator.Upload');
        $this->loadComponent('Administrator.Url');
        $this->loadComponent('Front.Texts');
        $this->loadComponent('Front.Get');
        $this->loadComponent('Administrator.Menu');
        $this->loadComponent('Administrator.Rol');

        $this->loadComponent('Front.Customer');

        //variables del usuario logueado
        $autenticado = $this->Auth->user();
        $autenticadoRole = $this->Auth->user('role_id');

        $this->set('authUser', $autenticado);
            
        $this->set('userRole', $autenticadoRole);

        $this->set('userID', $this->Auth->user('id'));


        //Variables THEME
        $this->viewBuilder()->theme('Front');
        if($this->request->params['action']=='pdf' || $this->request->params['action']=='testpdf' || $this->request->params['action']=='userByEmail' || $this->request->params['action']=='change_password'  || $this->request->params['action']=='access'){
            $this->viewBuilder()->layout('Front.default');
        }else{
            $this->viewBuilder()->layout('Front.theme');
        }

        
        //Sesion URL ACTUAL
        if($this->request->params['action']!='access'){

           $urlActual=$_SERVER['REQUEST_SCHEME']."://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
           // $urlActual= 'http://rrtechnosolutions.in/buycranesnow';
            $this->request->session()->write('URL', $urlActual);    
        }


        /************************************
        COOKIES
        **********************************/

        $this->Cookie->configKey('anti', ['expires' => '+1 hour']);
        $anti = sha1(date('D-m-Y'));

        $this->Cookie->write('anti', substr($anti, 0, 5));
        //$this->Cookie->delete('anti');
        $this->set('anti', $this->Cookie->read('anti'));

        /**************************************
        IDIOMA
        **************************************/
        $general = TableRegistry::get('Administrator.Generals');
        $equipments = TableRegistry::get('Administrator.Equipments');

        //Idioma
        if(isset($this->request->params['language']) and $this->request->params['language'] != ''){
            I18n::locale($this->request->params['language']);
            $lang = $this->request->params['language'];


        } else {
            I18n::locale('en');
            $lang = 'en'; // idioma por defecto
        }

        $general->locale($lang);


        //imprimir el idioma que se esta usando.
        $this->set('lang', $lang);


        /***************************
        COOKIES
        **************************/

        if($this->request->params['controller'] == 'Front' || $this->request->params['controller'] == 'Categories' || $this->request->params['controller'] == 'Users') {
            $this->Cookie->delete('post');
        } 

                                    /**************************************
                                    TEXTOS GLOBALES
                                    **************************************/

                                    //textos del text controller para los controladores
                                    $textos = $this->Texts->text($this->request->params['controller'], $this->request->params['action']);
                                    $this->extras = $textos['Extras']; 

                                    // Textos //
                                    $textos = $this->Texts->text($this->request->params['controller'], $this->request->params['action']);
                                    $this->set('controllerText', $textos[$this->request->params['controller']]);
                                    $this->set('imagesText', $textos['Images']);
                                    $this->set('extras', $textos['Extras']);

                                    //llamar el parametro principal (ID) variable global llamada (al comienzo del controlador esta la variable formada).
                                    if(isset($this->request->params['pass'][0]) && !empty($this->request->params['pass'][0])) {
                                        $this->id = $this->request->params['pass'][0];
                                        $this->set('id', $this->id);
                                    }



                        if($this->request->params['action'] !='login1111' || $this->request->params['action']=='logout111'){



                                    /**************************************
                                    GENERALS
                                    **************************************/

                                    //logo y favicon
                                    $this->set('logo', $this->Get->get_frontend_images_url('logo')); //id usuario logueado
                                    $this->set('favicon', $this->Get->get_frontend_images_url('favicon')); //id usuario logueado

                                    //datos generales del sitio
                                    $datos = $general->find('list',['keyField' => 'option_key', 'valueField' => 'option_value'])->toArray(); 

                                    //datos generales del sitio
                                    $this->info = $datos;
                                    $this->set('info', $datos); //Nombre del sitio
                                    $this->set('blogName', $datos['name']); //Nombre del sitio
                                    $this->set('blogDescription', $datos['description']); //Descripcion del sitio
                                    $this->set('blogEmail', $datos['email']); //Email Administrador
                                    $this->set('noReply', $datos['noreply']); //Email Administrador
                                    
                                    //variable global de email administrador
                                    $this->blogEmail = $datos['email'];

                                    //variable global de nombre del sitio
                                    $this->blogName = $datos['name'];      

                                    //variable global de nombre del sitio
                                    $this->noReply = $datos['noreply']; 

                                    $this->set('languages', json_decode($datos['languages'], true)); //Lenguaje
                                    
                                    //colores
                                    $this->set('colors', json_decode($datos['frontend_colors'], true)); //Color Background
                                    $this->set('background', '#'.$datos['frontend_background']); //Email Administrador
                                    $this->set('bakcgroundImg', $datos['frontend_background_img']); //Email Administrador

                                    // status para los controladores (la variable la crea en la parte de arriba del appcontroller y se le da el valor aqui se usa en los controladores como variables globales)
                                     $this->active = 'active';
                                     $this->inactive = 'inactive';

                                    $urlActual=$_SERVER['REQUEST_SCHEME']."://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
                                    // $urlActual= 'http://rrtechnosolutions.in/buycranesnow';
                                    //if($_SERVER['REQUEST_URI'] == '/?=error404') { $this->Flash->exito(__d('front', 'Lo sentimos, no hemos encontrado lo que buscas')); }

                                    /**************************************
                                    Posts
                                    **************************************/
                                    $posts = TableRegistry::get('Administrator.Posts');

                                    if($this->request->params['controller'] == 'Front') {

                                        //listado simple últimas publicaciones
                                        $latests = $posts->find('list', ['conditions' => ['Posts.type' => 'Post', 'Posts.status' => $this->active], 'limit' => 10, 'order' => ['Posts.created' => 'DESC']]);
                                        $this->set('latests', $latests);

                                    }

                                    if($this->request->params['action'] != 'map' && $this->request->params['action'] != 'offer') {

                                            $latestsPosts = $posts->find('all', ['conditions' => ['Posts.type' => 'Post', 'Posts.status' => $this->active,  'Posts.crane_status' => 0], 'limit' => 10, 'order' => ['Posts.created' => 'DESC']]);
                                            $this->set('latestsPosts', $latestsPosts);
                                    }


                                    if($this->request->params['action'] != 'map') {

                                            $requireOperator = ['yes' => __d('front', $this->extras['yes']), 'no' =>  __d('front', $this->extras['no']), 'bouth' => __d('front', $this->extras['quote_bouth_options'])];
                                            $this->set('requireOperator', $requireOperator);

                                    }

                                    /**************************************
                                    PAGINAS
                                    **************************************/
                                    /*
                                    //buscamos todas las paginas que contengan el theme servicios para adjuntarlas al footer
                                    $servicios = $posts->find('list', ['conditions' => ['Posts.type' => 'Page', 'Posts.status' => $this->active, 'Posts.page_theme' => 'servicios']]);
                                    $this->set('servicios', $servicios);

                                    //buscamos todas las paginas que contengan el theme nosotros para adjuntarlas al footer
                                    $nosotros = $posts->find('list', ['conditions' => ['Posts.type' => 'Page', 'Posts.status' => $this->active, 'Posts.page_theme' => 'nosotros']]);
                                    $this->set('nosotros', $nosotros);

                                    //aliados
                                    $aliados = $posts->find('list', ['conditions' => ['Posts.type' => 'Page', 'Posts.status' => $this->active, 'Posts.page_theme' => 'aliados']]);
                                    $this->set('aliados', $aliados);
                                    */

                                        //Codigos
                                        $codePhones = TableRegistry::get('Administrator.phoneCodes');
                                        $phoneCodes = $codePhones->find('all');

                                        $codigos = [];
                                        $codeKeys = [];

                                        foreach ($phoneCodes as $code) {
                                            
                                            //array_push($codigos, [$code['iso'].' + '.$code['phonecode'] =>  $code['iso'].' + '.$code['phonecode']]);

                                            array_push($codigos, $code['iso']. ' + '.$code['phonecode']);
                                            array_push($codeKeys, $code['iso']. ' + '.$code['phonecode']);

                                        }

                                        $theCodes = array_combine($codeKeys, $codigos);

                                        $this->set('codigosTelefono', $theCodes);


                                    /**************************************
                                    CATEGORIAS
                                    **************************************/

                                    //buscar todas las gruas.
                                    $categories = TableRegistry::get('Administrator.Categories');
                                    $craneType = $categories->find('treeList', ['conditions' => ['status' => 'active', 'parent_id' => 1], 'spacer' => '— '])->toArray();
                                    $this->set('craneType', $craneType);


                                    /**************************************
                                    USUARIOS
                                    **************************************/

                                        //nuevo usuario
                                        $users = TableRegistry::get('Administrator.Users'); 
                                        $newUser = $users->newEntity();
                                        $this->set('create_user', $newUser);


                                    //tipos de usuario
                                    $industryType = ['contractor'  => $this->extras['contractor'], 'rental_heavy_equipment'  => $this->extras['rental_heavy_equipment'], 'special_transportation'  => $this->extras['special_transportation'], 
                                                 'utility_mining_oil'  => $this->extras['utility_mining_oil'], 'new_distrbuitor_parts' => $this->extras['new_distrbuitor_parts'], 'used_distrbuitor_broker' => $this->extras['used_distrbuitor_broker'], 
                                                 'windowpower' => $this->extras['windowpower'], 'manufacturer' => $this->extras['manufacturer'], 'server_repair' => $this->extras['server_repair'], 
                                                 'certification_company' => $this->extras['certification_company'], 'others' => $this->extras['others']];

                                    $this->set('tiposUsuario', $industryType);


                                    //redireccionar hasta que los ususarios completen sus datos empresariales

                                    if(isset($autenticado) && !empty($autenticado) && $autenticadoRole < 3) {

                                        if(empty($autenticado['company_tel']) || empty($autenticado['company_country']) || empty($autenticado['company_state']) ) {

                                                if($this->request->params['plugin'] == 'Front' && $this->request->params['action'] != 'profile') {

                                                    $this->Flash->alerts(__d('front', 'Completa los datos de tu perfil empresarial'));
                                                    $this->redirect(['controller' => 'Users', 'action' => 'profile']);
                                                }

                                            }


                                    }

                                    /**************************************
                                    GADGETS
                                    **************************************/


                                    $gadgets = TableRegistry::get('Administrator.Gadgets'); 

                                    if($this->request->params['action'] != 'map' && $this->request->params['action'] != 'offer') {

                                                $customers = $gadgets->get($datos['customers'], ['contain' => ['Archives']]);
                                                $customersImages = $customers->archives;
                                                shuffle($customersImages); // imagenes aleatorias 
                                                $this->set('customersImages', $customersImages);


                                                if($this->request->params['controller'] == 'Front') {

                                                        if(isset($this->request->params['language'])) { 
                                                                $imgBan = $datos['banner_home'];
                                                        } else {

                                                                $imgBan = $datos['banner_home_en'];
                                                        }

                                                        $banner = $gadgets->get($imgBan, ['contain' => ['Archives']]);
                                                        $imagesBanner = $banner->archives;
                                                        shuffle($imagesBanner); // imagenes aleatorias 
                                                        $this->set('imagesBanner', $imagesBanner);

                                                } else {                                   


                                                        if($this->request->params['controller'] == 'Posts') {

                                                                //publicidad seccion superior
                                                                //$upPulicity = $gadgets->get($datos['publicity_up'], ['contain' => ['Archives']]);
                                                                $upPulicity = $gadgets->find('all', ['conditions' => ['Gadgets.id' => $datos['publicity_up']], 'contain' => ['Archives'] ])->first();
                                                                $publicityUp = $upPulicity->archives;
                                                                shuffle($publicityUp); // imagenes aleatorias
                                                                $this->set('publicityUp', $publicityUp);

                                                        }
                                                        
                                                        if($this->request->params['controller'] == 'Users') {

                                                                $pulicityDir = $gadgets->find('all', ['conditions' => ['Gadgets.type' => 'directory'], 'orderby' => 'rand', 'contain' => ['Archives'] ])->first();
                                                                $publicityDirectory = $pulicityDir->archives;
                                                                shuffle($publicityDirectory); // imagenes aleatorias
                                                                $this->set('publicityDirectory', $publicityDirectory);

                                                                //publicidad seccion usuarios
                                                                /*
                                                                $userPulicity = $gadgets->get($datos['publicity_user'], ['contain' => ['Archives']]);
                                                                $publicityUser = $userPulicity->archives[0];
                                                                $this->set('publicityUser', $publicityUser);
                                                                */
                                                        }

                                                }

                                    }

                                    /**************************************
                                    BUSCADOR
                                    **************************************/

                                    // todos los campos personalizados de los Posts
                                    $fields = TableRegistry::get('Administrator.Fields');  
                                    $customFieldsPosts = TableRegistry::get('Administrator.FieldsPosts');


                                    //disponible ALQUILER, VENTA.
                                    $this->set('avalible', ['rent' => __d('front', $textos['Extras']['to_rent']), 'sell' =>  __d('front', $textos['Extras']['to_sell'])]);


                                    if($this->request->params['controller'] != 'Front' && $this->request->params['action'] != 'map' && $this->request->params['action'] != 'offer') {

                                                $fieldsPosts = $fields->find('all', ['conditions' => ['type' => 'Post', 'sidebar' => 'yes'], 'fields' => ['id', 'option_value', 'option_key', 'option_label'] ] )->order(['sidebar_order' => 'ASC']); // filtro los campos por sidebar (con YES son los que deben apareceer)
                                                $this->set('fieldsPosts', $fieldsPosts);

                                                
                                                if($this->request->params['controller'] != 'Users') {
                                                        
                                                        $modelCranes = $customFieldsPosts->find('list', ['keyField' => 'value', 'valueField' => 'value', 'conditions' => ['field_id' => 4], 'group' => 'value'])->toArray();
                                                        $this->set('modelCranes', $modelCranes);
                                                }
                                                
                                   
                                                //crear un  array de llaves (campos personalizados y values vacios para los campos por defecto en el sidebar).
                                                $llavesSidebar = [];
                                                $valuesSidebar = [];

                                                foreach ($fieldsPosts as $key => $dato) {
                                                    array_push($llavesSidebar, $dato['option_key']);
                                                    array_push($valuesSidebar, '');
                                                }

                                                $sides = array_combine($llavesSidebar, $valuesSidebar);
                                                $sidebar = array_merge($sides, ['Category' => '', 'tons_since' => '0', 'tons_until' => '3000', 'model' => '']); // datos se mandan estaticos al ser categories fuera del fields y toneladas por manejar el DESDE y HASTA.
                                                
                                                $this->set('sidebarData', $sidebar);

                                    }



                                    /**************************************
                                    PAISES CIUDADES CODIGOS TELEFONICOS
                                    **************************************/
                                    
                                    $countries = TableRegistry::get('Administrator.Countries');
                                    //$continents = $countries->find('list', ['valueField' => 'continent']); $continents->select(['continent'])->distinct(['continent']);

                                    $continents = ['América' => $this->extras['america'], 'Europa' => $this->extras['europe'], 'Asia' => $this->extras['asia'], 'África' => $this->extras['africa'], 'Oceanía' => $this->extras['oceania'] ];

                                    $this->set('continentes', $continents);

                                    /*
                                    $countryNames = $countries->find('list', ['keyField' => 'id', 'valueField' => 'name',])->toArray();
                                    //sort($countryNames);

                                    $paisesFields = $fields->findByOptionKey('country')->first();                                    
                                    $pfields = json_decode($paisesFields->option_value, TRUE);
                                    $pnames = explode(',', $pfields['options']);
                                    //sort($pnames);

                                    $paisNombres = $countryNames; 
                                    

                                    $this->set('countryNames', $paisNombres);

                                    //echo pr($paisNombres);
                                    */

                                    /**************************************
                                    MENUS DE LA WEB
                                    **************************************/

                                    if($this->request->params['action'] != 'map' && $this->request->params['action'] != 'offer') {

                                        //menu principal 
                                        $this->set('menu', json_decode($datos['frontend_main'], true)); //menu frontEnd

                                        $this->set('main_about_us', json_decode($datos['main_about_us'], true)); //menu frontEnd
                                        $this->set('main_services', json_decode($datos['main_services'], true)); //menu frontEnd
                                        $this->set('main_members', json_decode($datos['main_members'], true)); //menu frontEnd

                                    }

                                    /**************************************
                                    PAGINA DESTACADA HOME
                                    **************************************/

                                    if($this->request->params['controller'] == 'Front') {

                                            //pagina destacada en el footer de la web
                                            $principalCategories = $this->Get->get_categories_by_parent(1); // llamamos todas las categorias por pariente y en estado activas
                                            $this->set('principal_categories', $principalCategories); // segunda variable es para exclur la categoria (para excluir categoria destacados)

                                            $page_home = $this->Get->get_page_by_location('Homepage', 'rand()');
                                            //$page_home = $posts->find('all', ['conditions' => ['Posts.location' => 'Homepage', 'Posts.type' => 'Page']])->first();
                                            $this->set('page_home', $page_home);

                                    }


                            }




      
        //url de acceso desde facebook

        $urlAccessLogin = '/front/Users/access';
        $this->set('urlAccessLogin', $urlAccessLogin);

        //Validacion de Usuario registrado desde facebook

        if($this->Customer->user() && !empty($this->Customer->user())){

            $usuario = TableRegistry::get('Administrator.Users');
            $usuario=$usuario->get($this->Customer->user('id'));
            

            if($this->viewBuilder()!='logout'){

                if($usuario->term==0 and $this->request->params['action']!='terminos'){
                    //$this->Flash->exito(__d('front', 'Antes de continuar debes aceptar Términos y Condiciones.'));
                    $this->redirect(['controller' => 'Users', 'action' => 'terminos']); 
                }

                if($usuario->term==1 and $this->request->params['action']=='terminos'){
                    $this->redirect(['controller' => 'Users', 'action' => 'profile']); 
                }

                if($usuario->status=='inactive'){
                    $this->Flash->exito(__d('front', 'Lo sentimos. Tu usuario se encuentra Inactivo.'));
                    $this->redirect(['controller' => 'Users', 'action' => 'logout']); 

                }

            }

            $this->set('name',$usuario->name);

        }



    /*
       if(isset($this->request->params['language']) and $this->request->params['language']!=''){
            I18n::locale($this->request->params['language']);
        }
    */

        

    }


    public function customer(){

        $this->Customer->auth();

        if(!$this->Customer->user()){
            $this->Flash->error(__d('front', 'Recuerda que debes iniciar sesión.')); 
            return $this->redirect('/');
            /*echo '<script type="text/javascript">
            window.location="/";
            </script>';*/

        }

    }




}

