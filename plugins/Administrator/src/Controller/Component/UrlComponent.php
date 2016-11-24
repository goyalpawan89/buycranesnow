<?php
/*
función para los enlaces personalizados
*/

namespace Administrator\Controller\Component;

use Cake\Controller\Component;
use Cake\ORM\TableRegistry;
use Cake\Core\Configure;
use Cake\Network\Http\Client;

class UrlComponent extends Component {

	/*************crear imagenes en la base de datos y subirlos por FTP *********************/
			
		public function urlSlug($str, $type = NULL){

					$name = $str;
		
					if($str !== mb_convert_encoding( mb_convert_encoding($str, 'UTF-32', 'UTF-8'), 'UTF-8', 'UTF-32') )
						$str = mb_convert_encoding($str, 'UTF-8', mb_detect_encoding($str));
						$str = htmlentities($str, ENT_NOQUOTES, 'UTF-8');
						$str = preg_replace('`&([a-z]{1,2})(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig);`i', '\1', $str);
						$str = html_entity_decode($str, ENT_NOQUOTES, 'UTF-8');
						$str = preg_replace(array('`[^a-z0-9]`i','`[-]+`'), '-', $str);
						$str = strtolower( trim($str, '-') );

							if(!empty($type)) { 
								$find = TableRegistry::get('Administrator.'.$type);
								//$dato = $find->findAllBySlug($str);
								$count = $find->findAllByName($name)->count();

									if(isset($count) && !empty($count) && $count > 1) {
										    
										    return $str.'-'.$count;

									} else {
										return $str;
									}

							} else {
							
									return $str;
							
							}

		}


			
			public function urlSlug1($str, $type = NULL){

						$name = $str;
			
						if($str !== mb_convert_encoding( mb_convert_encoding($str, 'UTF-32', 'UTF-8'), 'UTF-8', 'UTF-32') )
							$str = mb_convert_encoding($str, 'UTF-8', mb_detect_encoding($str));
							$str = htmlentities($str, ENT_NOQUOTES, 'UTF-8');
							$str = preg_replace('`&([a-z]{1,2})(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig);`i', '\1', $str);
							$str = html_entity_decode($str, ENT_NOQUOTES, 'UTF-8');
							$str = preg_replace(array('`[^a-z0-9]`i','`[-]+`'), '-', $str);
							$str = strtolower( trim($str, '-') );

								if(!empty($type)) { 
									$find = TableRegistry::get('Administrator.'.$type);
									//$dato = $find->findAllBySlug($str);
									//$count = $find->find('all', ['conditions' => [$type.'.slug' => $str], 'fields' => ['name', 'slug', 'id'] ])->count();
									$count = $find->find('all', ['fields' => ['id', 'name', 'slug'] ])
												  ->Where([$type.'.slug LIKE' => '%'.$str.'%'])
												  ->count();

									//$count = $find->findAllByName($name)->count();

										if(isset($count) && !empty($count) && $count > 1) {

											return $count;

									}

									
								
								}

			}


	}


?>