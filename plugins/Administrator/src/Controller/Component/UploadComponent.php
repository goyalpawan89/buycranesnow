<?php
/*
variables de texto para las vistas
*/
namespace Administrator\Controller\Component;

use Cake\Controller\Component;
use Cake\ORM\TableRegistry;
use Cake\Core\Configure;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;

class UploadComponent extends Component {

	public $components = array('Session', 'RequestHandler', 'Auth', 'Flash', 'Administrator.Function', 'Administrator.Resize');
	public $helpers = array('Session');
	public $controller = null;



	  /*************crear imagenes en la base de datos y subirlos por FTP *********************/
			
	public function uploadFields($archive, $type) { 
		
			$file = TableRegistry::get('Administrator.Archives');
			$General = TableRegistry::get('Administrator.Generals');
			
			if($type=='direct'){
				$name=date('Y-m-d G.i.s').'.jpg';
				$val2=0;
				$typo='image/jpg';
				$tamano=$archive['size'];
				$idUser=$this->request->session()->read('Auth.access');
				$archive=$archive['foto'];
			}else{
				$name=$archive['name'];
				$val2=$archive['error'];
				$typo=$archive['type'];
				$tamano=$archive['size'];
				$idUser= $this->request->session()->read('Auth.User.id');

			}
			if($name!="" && $val2==0) { // si filename campo existe
			  	
			  	// subir imagen
				Configure::load('app');
				$carpeta=Configure::read('FTP.default.carpeta').date('Y'); //Destino de ubicacion del archivo
		        $destino = Configure::read('FTP.default.upload').$carpeta."/".date('m');
		        $dir = new Folder(WWW_ROOT . $carpeta, true, 0755); // si no existe eldirectorio lo crea
		        $final = new Folder(WWW_ROOT . $carpeta."/".date('m'), true, 0755); // crea el subdirectorio (toca por separado crearlos)
		        
		        $idconexion = ftp_connect(Configure::read('FTP.default.host'));
		        $resultado = ftp_login($idconexion, Configure::read('FTP.default.user'),Configure::read('FTP.default.pass'));


					if ((!$idconexion) || (!$resultado)) { $this->Flash->alerts(__('No se pudo establecer la conexion.')); die; }


						ftp_pasv ($idconexion, false);
						
							
							$fieldName = $this->Function->url2seo1($name); // quita espacios y caracteres extraños.
							
							$remoto = $fieldName;
							if($type=='direct'){
								$local = $archive;
							}else{
								$local = $archive['tmp_name'];	
							}
							
							   if(ftp_chdir($idconexion, $destino)){
								   if (ftp_put($idconexion,$remoto,$local,FTP_BINARY)){
									  
									  $tipoField = $typo; //tipo de imagen
									  $sizeField = $tamano; // tamaño imagen
									  $field = $name; //archivo que se esta leyendo
									  		
										$nameField = explode(".", $fieldName); // nombre del archivo para guardar en DB File.name
										$dir = $carpeta."/".date('m')."/"; // ruta del archivo donde quedara guardado.
										
										$thumbSize = $General->find('all', array('conditions' => array('Generals.option_key = ' => 'thumbnail_size')))->first(); //tamaño que se subio.
										$tamImage = $thumbSize->option_value;

									  //$nameField[0]; // nombre de la iamgen sin caracteres raros
									  
									  

									  if($type!='direct' and $type!=null){
									  	$save = $file->get($type);

									  	$data=array('user_id' =>$idUser,
												  'mimetype' => $tipoField,
												  'folder' => $dir,
												  'filename' => $fieldName,
												  'thumbnail' => $tamImage,
												  'filesize' => $sizeField);


									  	$file->patchEntity($save, $data);
									  }else{

									  	$data=array('user_id' =>$idUser,
												  'name' => $nameField[0], 
												  'mimetype' => $tipoField,
												  'folder' => $dir,
												  'filename' => $fieldName,
												  'thumbnail' => $tamImage,
												  'filesize' => $sizeField);


									  	$save=$file->newEntity($data);	
									  }

									  $final=$file->save($save);	
									  
									  	/*********miniaturas *************///include resize.php folder vendor.
										
										if($tipoField == "image/jpeg" || $tipoField == "image/png" || $tipoField == "image/gif") {	
											//App::import('Vendor', 'img/resize'); // archivo que genera objetos con miniatura de la imagen
											
											$this->Resize->thumbnail($dir.$fieldName); //llama el archivo del directorio donde esta guardado.
											$this->Resize->size_width($tamImage); // 
											$this->Resize->size_height($tamImage);	
											$this->Resize->jpeg_quality(100);
											$this->Resize->save($carpeta."/".date('m')."/medium-".$fieldName);
										}
										/*********miniaturas *************/

									  	 $this->Flash->exito(__('Se subio la imagen correctamente.'));
									  
								     } else {  
								        $this->Flash->alerts(__('No se pudo subir el archivo.')); 
								  	 }
						  		} else {  
								     $this->Flash->alerts(__('Error, no se pudo cambiar al directorio de subidas.')); 
								} 
						
						ftp_close($idconexion);  
						// subir iamgen
						return $save->id;
			}

		 }

}

?>