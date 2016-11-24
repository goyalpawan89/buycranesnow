<?php 

namespace Administrator\Controller\Component;

use Cake\Controller\Component;
use Cake\ORM\TableRegistry;

class MenuComponent extends Component {
    
   public $components = array('Auth', 'Function');

	//public $helpers = array('Session');*/

   		/*** Parametrización Controladores ***/
		public function controladores(){
			$controlador=array('Users','Posts', 'Generals');
			return $controlador;
		}
		/*** FIN ***/

    /*********************menu administrador************************/


		
		public function menuSidebar() { // MENU PRINCIPAL SIDEBAR (NO INCLUYE LOGOUT, EL LOGOUT ESTA EN EL ELEMENTO DEL MENU admin_sidebar.ctp)				
				  

				  //Roles= 1= Admin 2= Empresa 3=Usuario
				  
				   $sidebar=array(1=>array(__d('administrator', 'Usuarios'), 'Users', 'Permisos' =>array(1), 
								   						'submenu'=>[
								   							1=>array(__d('administrator', 'Todos los Usuarios'),'index','Permisos' =>array(1)), 
															2 => array(__d('administrator', 'Añadir usuario'),'add','Permisos' =>array(1)), 
															3 => array(__d('administrator', 'Tu perfil'), 'profile','Permisos' =>array(1)),
														]

											), 

				   				//menu exclusivo seccion de clientes
				   				15=>array(__d('administrator', 'Usuarios'), 'Users', 'Permisos' =>array(2, 3), 
								   						'submenu'=>[
															3 => array(__d('administrator', 'Tu perfil'),'profile','Permisos' =>array(2, 3)),
														]

											), 

								
						 		2=>array(__d('administrator', 'Categorías'), 'Categories', 'Permisos' =>array(1),
														'submenu'=>[
								   							1=>array(__d('administrator', 'Todas las categorías'), 'index', 'trash','Permisos' =>array(1)), 
								   							2 => array(__d('administrator','Añadir nueva'),'add', 'Permisos' =>array(1)),
														]
						 			),	

							    3=>array(__d('administrator', 'Grúas'), 'Posts', 'Permisos' =>array(1, 2),
														'submenu'=>[
								   							1=>array(__d('administrator','Todas las entradas'), 'index','Permisos' =>array(1,2)), 
							                         		2 => array(__d('administrator','Añadir nueva'),'add', 'Permisos' =>array(1,2)),
														]
							    	), 

							    4=>array(__d('administrator', 'Páginas'), 'Pages', 'Permisos' =>array(1),
														'submenu'=>[
								   							1=>array(__d('administrator','Todas las páginas'), 'index','Permisos' =>array(1)), 
							                         		2 => array(__d('administrator','Añadir nueva'),'add', 'Permisos' =>array(1)),
														]							    	
							    	), 
							    5=>array(__d('administrator', 'Multimedia'), 'Archives', 'Permisos' =>array(1),
							    						'submenu'=>[
								   							1=>array(__d('administrator','Todos los archivos'), 'index','Permisos' =>array(1)), 
							                         		2 => array(__d('administrator','Añadir nuevo'),'add', 'Permisos' =>array(1)),
														]
							    	),  
							   
							    6=>array(__d('administrator', 'Gadgets'), 'Gadgets', 'Permisos' =>array(1),
							    						'submenu'=>[
								   							1=>array(__d('administrator','Todos los gadgets'), 'index','Permisos' =>array(1)), 
							                         		2 => array(__d('administrator','Añadir nuevo'),'add', 'Permisos' =>array(1)),
														]
										),

							    7=>array(__d('administrator', 'Ofertas'), 'SellRent', 'Permisos' =>array(1),
							    						'submenu'=>[
								   							1=>array(__d('administrator','Todas las ofertas'), 'index','Permisos' =>array(1)), 
														]
										),

							    8=>array(__d('administrator', 'Transacciones'), 'Payments', 'Permisos' =>array(1),
							    						'submenu'=>[
								   							1=>array(__d('administrator','Todos los pagos'), 'index','Permisos' =>array(1)), 
														]
										),

							    9=>array('Opciones generales', 'Generals', 'Permisos' =>array(1),
														'submenu'=>[
								   							1=>array(__d('administrator','Ajustes generales'),'index','Permisos' =>array(1)),
							   								   array(__d('administrator','Apariencia web'),'appearance','Permisos' =>array(1)),
															   array(__d('administrator','Campos personalizables'),'custom_fields','Permisos' =>array(1)),
															   array(__d('administrator','Newsletter'),'newsletter','Permisos' =>array(1)),
														]
								), 

							    //10=>array('Codigos', 'Codes', 'Permisos' =>array(1, 2),),
							    //11=>array('Logs', 'Logs', 'Permisos' =>array(1, 2),),
							    //12=>['Reportes', 'Reports','Permisos' =>[1,2]], 
								 
								 /*4=>['Ventas', 'Ventas', 'Permisos' =>[1,2]],
								 3=>['Tarifas', 'Documents', 'Permisos' =>[1,2]], 
								 5=>['Registro', 'Capture', 'Permisos' =>[1,2]], 
								 5=>['Seguimiento', 'Tracking', 'Permisos' =>[1]], */

								 //Reunión
								/* 4=>array('Acomodación', 'Categories', 'Permisos' =>array(1, 2)), 
								 5=>array('Proveedor', 'Categories', 'Permisos' =>array(1, 2)), 
								// 9=>array('Licencia', 'Licenses', 'Permisos' =>array(1, 2)), 
								 
								 6=>array('Colegios', 'Categories', 'Permisos' =>array(1, 2)),
								 7=>array('Sedes', 'Categories', 'Permisos' =>array(1, 2)), */
								 //4=>array('Publicaciones', 'Posts', 'Permisos' =>array(1)), 
								 //5=>array('Paginas', 'Pages', 'Permisos' =>array(1, 2)), 
								 //9=>array('Categorias', 'Categories', 'Permisos' =>array(1, 2)),  
								);
				  $final=array(); 
				  ksort($sidebar);
				  
				  	  foreach($sidebar as $menu => $item){
							  if($this->Auth->user('role_id')==1 and in_array("1", $item['Permisos'])){
								 array_push($final, $item);
							  }
							  
							  if($this->Auth->user('role_id')==2 and in_array("2", $item['Permisos'])){
								 array_push($final, $item);
							  }
							  if($this->Auth->user('role_id')==3 and in_array("3", $item['Permisos'])){
								 array_push($final, $item);
							  }
				      }
				  
				  return $final;
				  
				
		}
		
		public function subMenu($controlador) { // SUBMENU CABEZOTE (NO INCLUYE LOGOUT, EL LOGOUT ESTA EN EL ELEMENTO DEL MENU admin_sidebar.ctp)
		

				$permiso=array('Permisos' =>array(1));
				$a=0;
				
				$inicio=array();
				$variable=array();

				$submenu=array(1=>array('Agregar', 'add', 'Config_add'), 
									array('Listado Activo', 'View', 'Config_index', 'Config_view', 'Config_edit'),
									array('Listado Inactivo', 'Trash', 'Config_trash'));

				$listado=array(1=>	array('Listado Activo', 'View', 'Config_index', 'Config_view', 'Config_edit'),
									array('Listado Inactivo', 'Trash', 'Config_trash'));

				$subMenu=array('Users'      => array(1=>array(__d('administrator','Usuarios'),'index','Permisos' =>array(1), 'edit'), 
													 2 => array(__d('administrator','Añadir usuario'),'add','Permisos' =>array(1)), 
													 3 => array(__d('administrator','Tu perfil'),'profile','Permisos' =>array(1, 2, 3))),
							   	'Generals'   => array(1=>array(__d('administrator','Opciones generales'),'index','Permisos' =>array(1)),
							   							array(__d('administrator','Apariencia web'),'appearance','Permisos' =>array(1)),
														array(__d('administrator','Campos personalizables'),'custom_fields','Permisos' =>array(1)),
														array(__d('administrator','Newsletter'),'newsletter','Permisos' =>array(1))),

							   'Categories' => array(1=>array(__d('administrator','Todas las categorías'), 'index', 'trash','Permisos' =>array(1)), 
							                         2 => array(__d('administrator','Añadir nueva'),'add', 'Permisos' =>array(1))),
							   'Posts'      => array(1=>array(__d('administrator','Todas las entradas'), 'index','Permisos' =>array(1, 2)), 
							                         2 => array(__d('administrator','Añadir nueva'),'add', 'Permisos' =>array(1, 2))),
							   'Pages'      => array(1=>array(__d('administrator','Todas las páginas'), 'index','Permisos' =>array(1)), 
							                         2 => array(__d('administrator','Añadir nueva'),'add', 'Permisos' =>array(1))),
							   'Gadgets'    => array(1=>array(__d('administrator','Todos los gadgets'), 'index','Permisos' =>array(1)), 
							                         2 => array(__d('administrator','Añadir nuevo'),'add', 'Permisos' =>array(1))),
							   'Archives' =>   array(1=>array(__d('administrator','Todos los archivos'), 'index', 'edit', 'Permisos' =>array(1)),
							   							array(__d('administrator','Agregar'),'add','Permisos' =>array(1)),
							   						),
							   	'Logs'   =>    array(1=>array(__d('administrator','Listado'),'index','logs', 'codes', 'Permisos' =>array(1,2)),
							   							array(__d('administrator','Buscar'),'search', 'Permisos' =>array(1,2)),
							   							),

							    'SellRent' =>  array(1=>array(__d('administrator','Ver Todas'),'index', 'Permisos' =>array(1)),
							   							array(__d('administrator','Ofertas para la renta'),'offer_rent', 'Permisos' =>array(1)),
							   							array(__d('administrator','Ofertas para la venta'),'offer_sell', 'Permisos' =>array(1)),
							   							),

							    'Payments' =>   array(1=>array(__d('administrator','Todos los pagos'), 'index', 'Permisos' =>array(1)),
							   						),

							   	'Reports'   => array(1=>array(__d('administrator','Totalizador'),'index', 'Ciclo', 'Edit','Permisos' =>array(1,2)),
							   							// array('Busqueda','search','Permisos' =>array(1,2), 'Search'),
							   						 	 //array('Descargar','export','Permisos' =>array(1,2)),
							   						 ),


   								
				);

				if(isset($this->request->params['prefix'])){
					$final=array();
				   	  foreach($subMenu['Config'] as $menu){ 
				          	  if($this->Auth->user('role_id')==1 and in_array("1", $menu['Permisos'])){
								 array_push($final, $menu);
							  }
							  if($this->Auth->user('role_id')==2 and in_array("2", $menu['Permisos'])){
								 array_push($final, $menu);
							  }	

							  if($this->Auth->user('role_id')==3 and in_array("3", $menu['Permisos'])){
								 array_push($final, $menu);
							  }				  
					  }
					  return $final;
				}

				if(array_key_exists($controlador, $subMenu)){
				   
				   $final=array();
				   foreach($subMenu[$controlador] as $menu){ 
				          	  if($this->Auth->user('role_id')==1 and in_array("1", $menu['Permisos'])){
								 array_push($final, $menu);
							  }
							  if($this->Auth->user('role_id')==2 and in_array("2", $menu['Permisos'])){
								 array_push($final, $menu);
							  }	
							  if($this->Auth->user('role_id')==3 and in_array("3", $menu['Permisos'])){
								 array_push($final, $menu);
							  }				  
				  }
				  return $final;
				  
				}
				
				
		}

		/*********************menu administrador************************/
							 

}