<?php
namespace App\Controller;

use Cake\Core\Configure;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\ORM\TableRegistry;

class DocumentsController extends AppController {

	//pagina principal 
	public function index() {
		$this->set('carpeta', 'documentos');
		
	}

	public function usuarios() {
		$this->set('carpeta', 'uploads');

		$this->render('index');
		
	}


			
	
	
	
}
