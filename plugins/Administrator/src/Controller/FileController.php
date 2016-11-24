<?php
namespace Administrator\Controller;

use Administrator\Controller\AppController;

use Cake\Core\Configure;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\ORM\TableRegistry;



class FileController extends AppController {

	
	//obtener archivos por id Imagen destacada
	public function getThumbUrl() {

		$file = TableRegistry::get('Administrator.Archives');

		if ($this->request->is('ajax')) {

		    // llamar todas las IMAGENES de la web
			$imagesConditions = ['Archives.user_id' => $this->Auth->user('id'),
									 'AND' => [
									            [
											        'OR' => [
												                ['mimetype' => 'image/png'],
												                ['mimetype' => 'image/jpeg'],
												                ['mimetype' => 'image/jpg'],
												                ['mimetype' => 'image/gif'],
												                ['mimetype' => 'application/stream'],
												                ['mimetype' => 'application/pdf'],
									            			]
									        	],
									        
									    	]
								];


			//$this->set('images', $archives->find('all', ['conditions' => $imagesConditions]) );
			$all_files = $file->find('all', ['conditions' => $imagesConditions, 'order' => ['id' => 'DESC'] ]);


	        $this->set('archives', $all_files);
	        
	        // imagenes chekeadas en la galería dependiendo del id
	        if(isset($this->request->query['tipo']) and isset($this->request->query['id'])){

	        	if($this->request->query['tipo']=='Pages'){
	        		$tipo='Posts';
	        	} else {
	        		$tipo= $this->request->query['tipo'];
	        	}


	        	$posts = TableRegistry::get('Administrator.'.$tipo.'');
		        $post = $posts->get($this->request->query['id'])->toArray();
	 
		        $thumbnailId = $post['archive_id'];
		        $this->set('thumbnailId', $thumbnailId); // id de la imagen destacada

		        $id=$this->request->query['id'];
		        $this->set('id',$id);

		        $tipo=$tipo;
		        $this->set('tipo',$tipo);

	        }

	        $this->set('accion', $this->request->query['accion']);
    	    
	        

		}
	
	}

	//actualizar imagenes para el logo, fondo y favicon de la página
	public function getFrontImg() {

		$file = TableRegistry::get('Administrator.Archives');

		if ($this->request->is('ajax')) {

		    // llamar todas las IMAGENES de la web
	        $all_files = $this->Get->get_all_archives();
	        $this->set('archives', $all_files);
	        
	        // imagenes chekeadas en la galería dependiendo del id
	        if(isset($this->request->query['tipo']) and isset($this->request->query['option_key'])){
	        	$find = TableRegistry::get('Administrator.Generals');
		        $post = $find->find('all', ['conditions' => ['option_key' => $this->request->query['option_key']]])->first()->toArray();
	 
		        $thumbnailId = $post['option_value'];
		        $this->set('thumbnailId', $thumbnailId); // id de la imagen destacada

		        $id = $post['id'];
		        $this->set('id', $id);

		        $tipo = $this->request->query['tipo'];
		        $this->set('tipo',$tipo);

		        $key = $this->request->query['option_key'];
		        $this->set('key',$key);

		        //mandamos el div que se cerrará
		        $divID = $this->request->query['divID'];
		        $this->set('divID',$divID);

		        //mandamos el div que se cerrará
		        $fileuploader_class = $this->request->query['fileuploader_class'];
		        $this->set('fileuploader_class', $fileuploader_class);

	        }

	        $this->set('accion', $this->request->query['accion']);

		}
	
	}




	public function getThumbFull() {

		$file = TableRegistry::get('Administrator.Archives');

		if ($this->request->is('ajax')) {

			 // llamar todas las IMAGENES de la web
			$imagesConditions = ['Archives.user_id' => $this->Auth->user('id'),
									 'AND' => [
									            [
											        'OR' => [
												                ['mimetype' => 'image/png'],
												                ['mimetype' => 'image/jpeg'],
												                ['mimetype' => 'image/jpg'],
												                ['mimetype' => 'image/gif'],
												                ['mimetype' => 'application/stream'],
												                ['mimetype' => 'application/pdf'],
									            			]
									        	],
									        
									    	]
								];


			//$this->set('images', $archives->find('all', ['conditions' => $imagesConditions]) );
			$all_files = $file->find('all', ['conditions' => $imagesConditions, 'order' => ['id' => 'DESC'] ]);


	        $this->set('archives', $all_files);
	        if(isset($this->request->query['id'])){
		        $id = $this->request->query['id'];
		        
	    	}else{
	    		$id=null;
	    	}

	    	$this->set('id', $id); // id de la imagen destacada
	    	$this->set('controller', $this->request->query['tipo']); // id de la imagen destacada

		}
	
	}


	public function gallery(){ 

        if($this->request->is('ajax')) {
            //echo pr($this->request->data());
            //echo $this->request->data('user');
        	$posts = TableRegistry::get('Administrator.Posts');

        	$datosRelacion= array('post_id' => $this->request->data['id'], 'archive_id' => $this->request->data['file']);
			$saveField = $posts->ArchivesPosts->newEntity();

			$save = $posts->ArchivesPosts->patchEntity($saveField, $datosRelacion); 
			$posts->ArchivesPosts->save($save);	
         
        }

    }

    public function deselect(){ 

        if($this->request->is('ajax')) {
            //echo pr($this->request->data());
            //echo $this->request->data('user');
        	$posts = TableRegistry::get('Administrator.Posts');

			$filtro= $posts->ArchivesPosts->find('All', ['conditions'=>['post_id' => $this->request->data['id'], 'archive_id' => $this->request->data['file'] ]])->first();
			
			$entity = $posts->ArchivesPosts->get($filtro->id);
			$posts->ArchivesPosts->delete($entity);
        }

        $this->render('gallery');

    }



    public function thumbnail(){ 

        if($this->request->is('ajax')) {
            //echo pr($this->request->data());
            //echo $this->request->data('user');
        	$posts = TableRegistry::get('Administrator.'.$this->request->data['tipo'].'');
        	if(isset($this->request->data['id'])){
        		$entity = $posts->get($this->request->data['id']);
	        	$final=['archive_id'=>$this->request->data['file']];

				$save = $posts->patchEntity($entity, $final);
				$posts->save($save);	
        	}

        }

    }


	
	
}
