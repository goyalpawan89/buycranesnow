<?php
namespace Administrator\Controller;

use Administrator\Controller\AppController;

use Cake\Controller\Controller;
use Cake\ORM\TableRegistry;

use Cake\Core\Configure;
use Cake\View\Helper\FlashHelper;
use Cake\View\Helper;


use Cake\I18n\I18n;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link http://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

    // variables globales para buscar usuarios, publicaciones etc activas, inactivas, todas $this->activos; etc...
    public $activos; // conteo publicaciones activas
    public $inactivos;  //conteo publicaciones inactivas
    public $id; 
    public $active; // status active
    public $inactive; // status inactive
    public $pending; // status ´pending
    public $accept; // status accept
    public $deny; // status deny
    public $companyId; // id de la compañia (usuario empresarial)
    public $companyRoleId; // role id de la compañia
    public $companytype; // role id de la compañia
    public $extras;
    public $idioma;
    public $blogName; // status inactive
    public $noreply; // status inactive
    public $blogEmail; // status inactive

    //public $helpers = ['Html', 'Form', 'Session','Paginator'];

    public function initialize()
    {
        
        parent::initialize();
        

        $this->set('plugin', 'administrator');

        $this->loadComponent('Flash');
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
        $this->Auth->allow(['logout', 'forgetpwd', 'ObjectTitle', 'getThumbUrl', 'reset', 'api_cities']);
         
        $this->loadComponent('RequestHandler');
        $this->loadComponent('Paginator');
        $this->loadComponent('Administrator.Function');
        $this->loadComponent('Administrator.Upload');
        $this->loadComponent('Administrator.Url');
        $this->loadComponent('Administrator.Texts');
        $this->loadComponent('Administrator.Get');
        $this->loadComponent('Administrator.Menu');
        $this->loadComponent('Administrator.Rol');

        $this->viewBuilder()->theme('Administrator');
        $this->viewBuilder()->layout('Administrator.elymki');
        
        // Personalización de Vistas 
       if($this->request->params['action'] == 'login' or $this->request->params['action'] == 'reset' or $this->request->params['action'] == 'code'){ $this->viewBuilder()->layout('Administrator.login'); } 
       
       if($this->name == 'Errors' and $this->request->params['action']=='license'){ $this->viewBuilder()->layout('Administrator.license'); } 
       elseif($this->request->params['controller'] == 'Errors' and $this->request->params['action']=='suspendida'){ $this->viewBuilder()->layout('Administrator.license'); } 
       elseif($this->request->params['controller'] == 'Errors' or $this->request->params['action']== 'remote'){ $this->viewBuilder()->layout('Administrator.errors'); } 
       
       if($this->request->params['action'] == 'forgetpwd' or $this->request->params['action'] == 'excel' or $this->request->params['action'] == 'excelMember' or $this->request->params['controller'] == 'Config') { 
            $this->viewBuilder()->layout('Administrator.default'); 
        } //login olvido contraseña y logout

        //File Ajax
        if($this->request->params['controller'] == 'File'){  $this->viewBuilder()->layout('Administrator.ajax');   }  

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

        // status para los controladores (la variable la crea en la parte de arriba del appcontroller y se le da el valor aqui se usa en los controladores como variables globales)
        $this->active = 'active';
        $this->inactive = 'inactive';

        //id del rol del usuario empresarial
        $this->companyRoleId = 3;

        $this->companyType = 'Business';

        //         //Idioma
        // if(isset($this->request->params['language']) and $this->request->params['language'] != ''){
        //     I18n::locale($this->request->params['language']);
        //     $lang = $this->request->params['language'];

        // } else {
        //     $lang = 'en'; // idioma por defecto
        //     I18n::locale('en');
           
        // }

        // //imprimir el idioma que se esta usando.
        // $this->set('lang', $lang);

                /**************************************
        IDIOMA
        **************************************/
        $general = TableRegistry::get('Administrator.Generals');

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





    }

     public function control($license){
        
            if($this->name == 'Errors' and $license=='Error 505' and !$this->request->session()->read('Auth.User.id')){
                $this->redirect(array('controller' => 'users', 'action' => 'profile'));
            }if($this->name != 'Errors' and $license=='Error 506' and $this->request->session()->read('Auth.User.id')){
                $this->redirect(array('controller' => 'errors', 'action' => 'suspendida'));
            }elseif($this->name == 'Errors' and $license=='active'){
                $this->redirect(array('controller' => 'users', 'action' => 'profile'));
            }elseif($license=='terminate' and $this->name != 'Errors'){
                    //echo 'Licencia Terminada';
                $this->redirect(array('controller' => 'errors', 'action' => 'suspendida'));
            }elseif($license=='Error 600' or $license=='Error 601'){
                //echo 'Licencia Suspendida';                   
                if($this->request->session()->read('Auth.User.id')){
                    if($this->name!='Errors'){
                        $this->redirect(array('controller' => 'errors', 'action' => 'suspendida'));
                    }
                    if($this->view=='license'){
                        if(isset($_SERVER['HTTP_REFERER'])){
                            $pos = strpos($_SERVER['HTTP_REFERER'], 'suspendida');
                            if($pos===false){
                                $this->redirect(array('controller' => 'errors', 'action' => 'suspendida'));
                            }
                        }else{
                            $this->redirect(array('controller' => 'errors', 'action' => 'suspendida'));
                        }
                    }
                }elseif($this->name=='Errors'){
                    $this->redirect(array('controller' => 'users', 'action' => 'profile'));
                }
            
            }elseif($license=='Error 404' and $this->name != 'Errors' and $this->request->session()->read('Auth.User.id')){
                // No Hay Datos
                $this->redirect(array('controller' => 'errors', 'action' => 'suspendida'));
            }

        }

     public function beforeFilter(\Cake\Event\Event $event) {

        $general = TableRegistry::get('Generals');

        $datos = $general->find('list',['keyField' => 'option_key', 'valueField' => 'option_value']); 
        $datos=$datos->toArray();
        //echo pr($datos);

        //Funcion licencia
       // $this->control($this->Function->apiLicense($datos['Licencia']));
        //Funcion licencia

        //textos para los controladores
        $textos = $this->Texts->text($this->request->params['controller'], $this->request->params['action']);
        $this->extras = $textos['Extras'];  

        $urlActual=$_SERVER['REQUEST_SCHEME']."://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        if($_SERVER['REQUEST_URI'] == '/?=error404') { $this->Flash->exito(__d('administrator', 'Lo sentimos, no hemos encontrado lo que buscas')); }


        //FTP       
        Configure::load('app');
        $uploads =Configure::read('FTP.default.carpeta').'Default/'; 
        $this->set('uploads', $uploads);

        //logo y favicon
        $this->set('logo', $this->Get->get_frontend_images_url('logo')); //id usuario logueado
        $this->set('favicon', $this->Get->get_frontend_images_url('favicon')); //id usuario logueado
        $this->set('fondo', $this->Get->get_frontend_images_url('frontend_background_img')); //id usuario logueado

        //Datos Usuario
        $this->set('user_ID', $this->Auth->user('id')); //id usuario logueado
        $this->set('user_Status', $this->Auth->user('status')); //estado usuario logueado
        $this->set('user_Name', $this->Auth->user('name'));
        $this->set('user_LastName', $this->Auth->user('last_name'));
        $this->set('user_Role', $this->Auth->user('role_id'));
        $this->set('user_Type', $this->Auth->user('type'));

        //Personalizacion
        $this->set('blogName', $datos['name']); //Nombre del sitio
        $this->set('blogDescription', $datos['description']); //Descripcion del sitio
        $this->set('blogEmail', $datos['email']); //Email Administrador
        
        $this->set('colores', json_decode($datos['backend_colors'], true)); //Color Background
        $this->set('frontColors', json_decode($datos['frontend_colors'], true)); //Color Background

        $this->set('FondoBackEnd', '#'.$datos['backend_background']); //Email Administrador
        $this->set('FondoImageBackEnd', $datos['backend_background_img']); //Email Administrador

        $this->set('languages', json_decode($datos['languages'], true)); //Lenguaje

        $this->set('avalible', ['rent' => __($textos['Extras']['rent']), 'sell' =>  __($textos['Extras']['sell'])]);


        /**************************************
        PAISES CIUDADES CODIGOS TELEFONICOS
        **************************************/

        $url=$_SERVER['REQUEST_URI'];
            $url=explode('/', $url);
            //echo pr($url);
            foreach ($url as $key => $value) {

                if(strlen($value)==2 and !is_numeric($value)){
                    if($value=='en'){
                        $value=$value.'_US';
                    }
                    
                    $lang=$value;
                }
            }

            if(isset($lang) and !empty($lang)){
                $idioma = $lang;
            }else{
                $idioma = 'en';
            }


        $this->set('language_default', $idioma); //Lenguaje Default
        $this->idioma = $idioma;

        //datos generales del sitio
        $general = TableRegistry::get('Administrator.Generals');
        $datos = $general->find('list',['keyField' => 'option_key', 'valueField' => 'option_value'])->toArray(); 

        //datos generales del sitio
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



        if($this->request->params['action'] == 'edit' || $this->request->params['action'] == 'add' || $this->request->params['action'] == 'profile') { 
        
                /*
                $countries = TableRegistry::get('Administrator.Countries');
                $paises = $countries->find('all', ['contain' => ['Cities'] ]);
                $this->set('paises', $paises);

                //Ciudades
                $cities = TableRegistry::get('Administrator.Cities');
                $ciudades = $cities->find('all', ['contain' => ['Countries'] ]);
                $this->set('ciudades', $ciudades);
                */

                //Codigos
                $codePhones = TableRegistry::get('Administrator.phoneCodes');
                $phoneCodes = $codePhones->find('all');
                $this->set('codigosTelefono', $phoneCodes);

        }

        /********* user types ******/

        $this->set('business', 'Business');
        $this->set('premium', 'Premium');
        $this->set('basic', 'Basic');



        //Menu
        $sidebar=$this->Menu->menuSidebar();
        
        if($this->params['prefix']){
            $item = 'Config';
        }else{
            $item=$this->name;
        } 

        $menu=$this->Menu->subMenu($item);
        $this->set('sidebar', $sidebar);
        $this->set('menu', $menu);
        //Menu

    }


    public function isAuthorized($user)
    {
        $action = $this->request->params['action'];

        // The add and index actions are always allowed.
        if (in_array($action, ['index', 'add', 'tags', 'profile', 'trash', 'edit', 'clear', 'restore', 'delete', 'trm', 'view'])) {
            return true;
        }
        // All other actions require an id.
        if (empty($this->request->params['pass'][0])) {
            return false;
        }

        // Check that the bookmark belongs to the current user.
       /* $id = $this->request->params['pass'][0];
        $bookmark = $this->Bookmarks->get($id);
        if ($bookmark->user_id == $user['id']) {
            return true;
        }
        return parent::isAuthorized($user);*/
    }









}
