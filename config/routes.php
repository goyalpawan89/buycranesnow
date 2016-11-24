<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
 
use Cake\Core\Plugin;
use Cake\Routing\Router;
use Cake\ORM\TableRegistry;
 
/**
 * The default class to use for all routes
 *
 * The following route classes are supplied with CakePHP and are appropriate
 * to set as the default:
 *
 * - Route
 * - InflectedRoute
 * - DashedRoute
 *
 * If no call is made to `Router::defaultRouteClass`, the class used is
 * `Route` (`Cake\Routing\Route\Route`)
 *
 * Note that `Route` does not do any inflections on URLs which will result in
 * inconsistently cased URLs when used with `:plugin`, `:controller` and
 * `:action` markers.
 *
 */
Router::defaultRouteClass('Route');
 
/*Router::prefix('config', function($routes) {
    // All routes here will be prefixed with ‘/admin‘
    // And have the prefix => admin route element added.
 
    $routes->connect('/:controller/:action/*');
 
    $routes->fallbacks('InflectedRoute');
});*/
 

Router::scope('/admin', ['plugin' => 'Administrator'], function ($routes) {
    $routes->connect('/', ['controller' => 'Users', 'action'=>'login']);
    $routes->fallbacks('InflectedRoute');
});
 
Router::scope('/:language/admin', ['plugin' => 'Administrator'], function ($routes) {
    $routes->connect('/', ['controller' => 'Users', 'action'=>'login']);
    $routes->fallbacks('InflectedRoute');
});

/*Router::scope('/api/:action', ['plugin' => 'Front'], function ($routes) {
    $routes->extensions(['json', 'xml']);
    $routes->connect('/', ['controller' => 'Api']);
    $routes->fallbacks('InflectedRoute');
});*/

 
Router::connect('/:language/',   ['plugin'=>'Front', 'controller' => 'Front', 'action' => 'index'], ['language' => '[a-z]{2}']); 


//rent - sell popups 
Router::connect('/:language/popup/*',   ['plugin'=>'Front', 'controller' => 'Posts', 'action' => 'offer'], ['language' => '[a-z]{2}']); 

Router::connect('/popup/*',   ['plugin'=>'Front', 'controller' => 'Posts', 'action' => 'offer']); 


//mapas 
Router::connect('/:language/map/*',   ['plugin'=>'Front', 'controller' => 'Posts', 'action' => 'map'], ['language' => '[a-z]{2}']); 


Router::connect('/map/*',   ['plugin'=>'Front', 'controller' => 'Posts', 'action' => 'map']); 


//mapas 
Router::connect('/:language/simple_search/*',   ['plugin'=>'Front', 'controller' => 'Search', 'action' => 'simple_search'], ['language' => '[a-z]{2}']); 

//mapas 
Router::connect('/simple_search/*',   ['plugin'=>'Front', 'controller' => 'Search', 'action' => 'simple_search'], ['language' => '[a-z]{2}']); 

Router::connect('/:language/post/my_favorites',   ['plugin'=>'Front', 'controller' => 'Posts', 'action' => 'my_favorites'], ['language' => '[a-z]{2}']); 

Router::connect('/:language/user/my_offers',   ['plugin'=>'Front', 'controller' => 'Users', 'action' => 'my_offers'], ['language' => '[a-z]{2}']); 


Router::connect('/post/my_favorites',   ['plugin'=>'Front', 'controller' => 'Posts', 'action' => 'my_favorites']); 

Router::connect('/:language/post/find/*',   ['plugin'=>'Front', 'controller' => 'Posts', 'action' => 'find'], ['language' => '[a-z]{2}']); 
Router::connect('/post/find/*',   ['plugin'=>'Front', 'controller' => 'Posts', 'action' => 'find']); 


Router::connect('/:language/user/site',   ['plugin'=>'Front', 'controller' => 'Users', 'action' => 'site'], ['language' => '[a-z]{2}']); 

Router::connect('/:language/user/profile',   ['plugin'=>'Front', 'controller' => 'Users', 'action' => 'profile'], ['language' => '[a-z]{2}']); 


//Router::connect('/en/',   ['plugin'=>'Front', 'controller' => 'Front', 'action' => 'index']); 

Router::scope('/api', ['plugin' => 'Front'], function ($routes) {
        $routes->extensions(['json']);
        $routes->resources('Recipes');
});


Router::scope('/', function ($routes) {
    

    $routes->extensions(['html', 'pdf']);

    $routes->connect('/:language/api/mensajes', array('plugin'=>'Front', 'controller' => 'Api', 'action'=>'mensajes'));


    /**
     * Here, we are connecting '/' (base path) to a controller called 'Pages',
     * its action called 'display', and we pass a param to select the view file
     * to use (in this case, src/Template/Pages/home.ctp)...
     */
     
    $routes->connect('/', ['plugin'=>'Front', 'controller' => 'Front', 'action' => 'index']);
    $routes->connect('/ranking', ['plugin'=>'Front','controller' => 'Posts', 'action'=>'ranking']);

    
    
    $routes->connect('user/:action/**', ['plugin'=>'Front','controller' => 'Users'], ['language' => '[a-z]{2}'] );


    //PDF
    $routes->connect('/testpdf/*', ['plugin'=>'Front','controller' => 'Posts', 'action'=>'testpdf'] );
    $routes->connect('/dom/*', ['plugin'=>'Front','controller' => 'Posts', 'action'=>'dom'] );
    $routes->connect('/:language/pdf/*', ['plugin'=>'Front','controller' => 'Posts', 'action'=>'pdf'] );
    $routes->connect('/prpdf/*', ['plugin'=>'Front','controller' => 'Posts', 'action'=>'prpdf'] );

    $routes->connect('/:language/compare/*', ['plugin'=>'Front','controller' => 'Posts', 'action'=>'compare'] );
    $routes->connect('/compare/*', ['plugin'=>'Front','controller' => 'Posts', 'action'=>'compare'] );

    $routes->connect('/compare_request', ['plugin'=>'Front','controller' => 'Posts', 'action'=>'compare_request']);



    /*** get options routes ****/

    
    $generals = TableRegistry::get('Administrator.Generals');
    $search = $generals->find('all', ['conditions' => ['type' => 'Routes']]);
 
    foreach($search as $option) {
        if(!empty($option->option_value)) { $prefijo = $option->option_value; } else { $prefijo = $option->option_key; }

        //validar que solamente las urls con diferentes acciones sean del usuario y se ajusten sin el front en la URL
        if($option->option_key == 'Users') { $routes->connect('/'.$prefijo.'/:action/*', ['plugin'=>'Front','controller' => $option->option_key]); }

        $routes->connect('/:language/'.$prefijo.'/*', ['plugin'=>'Front','controller' => $option->option_key], ['language' => '[a-z]{2}']);
        $routes->connect($prefijo.'/*', ['plugin'=>'Front','controller' => $option->option_key], ['language' => '[a-z]{2}'] );
    }


    /*
    $generals = TableRegistry::get('Administrator.Generals');
    $search = $generals->find('all', ['conditions' => ['type' => 'Routes']]);
 
    foreach($search as $option) {
        if(!empty($option->option_value)) { $prefijo = $option->option_value; } else { $prefijo = $option->option_key; }

            //validar que solamente las urls con diferentes acciones sean del usuario y se ajusten sin el front en la URL
            if($option->option_key == 'Users') { 

                $routes->connect('/'.$prefijo.'/:action/*', ['plugin'=>'Front','controller' => $option->option_key]); 

            } else {

                $routes->connect('/:language/'.$prefijo.'/*', ['plugin'=>'Front','controller' => $option->option_key], ['language' => '[a-z]{2}']);
                $routes->connect($prefijo.'/*', ['plugin'=>'Front','controller' => $option->option_key], ['language' => '[a-z]{2}'] );

            }
    }

    */

    

    /*** get options routes ****/
  
    
    
    
    
    

   // $routes->connect('/', ['/:prefix/:plugin/:controller']);
 
    //$routes->connect('/Config/:action/Add', array('controller' => 'config', 'action' => 'add'));
 
    /**
     * ...and connect the rest of 'Pages' controller's URLs.
     */
   // $routes->connect('/pages/*', ['controller' => 'Pages', 'action' => 'display']);
 
    /**
     * Connect catchall routes for all controllers.
     *
     * Using the argument `InflectedRoute`, the `fallbacks` method is a shortcut for
     *    `$routes->connect('/:controller', ['action' => 'index'], ['routeClass' => 'InflectedRoute']);`
     *    `$routes->connect('/:controller/:action/*', [], ['routeClass' => 'InflectedRoute']);`
     *
     * Any route class can be used with this method, such as:
     * - DashedRoute
     * - InflectedRoute
     * - Route
     * - Or your own route class
     *
     * You can remove these routes once you've connected the
     * routes you want in your application.
     */
    $routes->fallbacks('InflectedRoute');
});
 
/**
 * Load all plugin routes.  See the Plugin documentation on
 * how to customize the loading of plugin routes.
 */
Plugin::routes();