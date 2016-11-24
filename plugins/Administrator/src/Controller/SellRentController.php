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

class SellRentController extends AppController {

	//before
	public function beforeFilter(\Cake\Event\Event $event) {
    parent::beforeFilter($event);

	    // llamar a todos los post por type y por status.
	    $this->activos = $this->SellRent->find('all', ['conditions' => ['SellRent.status' => $this->active]])->count(); $this->set('activos', $this->activos); //conteo por usuarios y estado activo
	    $this->activos = $this->SellRent->find('all', ['conditions' => ['SellRent.status' => $this->inactive]])->count(); $this->set('inactivos', $this->activos); //conteo por usuarios y estado activo
		$this->todos = $this->SellRent->find('all')->count(); $this->set('todos', $this->todos); //conteo todos los usuarios

    }


	//pagina principal 
	public function index() {

		$this->paginate = ['limit'=>100, ];

		//listar como paginador las ofertas
		$all = $this->SellRent->find('all', ['conditions' => ['SellRent.status' => $this->active], 'order' => ['SellRent.id DESC'],]);
        $this->set('offers', $this->paginate($all));

	        if($this->request->is('post')) {

				echo pr($this->request->data);

	            if($this->request->data['checkbox']) {

	            	foreach($this->request->data['checkbox'] as $offerID) {
	                    //$this->SellRent->id = $userID;
	                   $data=['status' => $this->inactive];
	                   $dato = $this->SellRent->get($offerID);
	                   $oferta = $this->SellRent->patchEntity($dato, $data,  ['validate' => false]);            
	                   $this->SellRent->save($oferta);
	                }
	                
	                $this->Flash->exito(__d('administrator', 'La(s) oferta(s) se han cambiado a estado inactivo.'));
	                $this->redirect(['action' => 'index']);


	            }

	        }


    }    


    //ofertas disonibles para la venta 
	public function offer_rent() {

		//listar como paginador las ofertas
		$all = $this->SellRent->find('all', ['conditions' => ['SellRent.status' => $this->active, 'SellRent.type' => 0]]);
		$this->set('offers', $this->paginate($all));

		$this->render('index');


    }    


    //ofertas disonibles para la venta 
	public function offer_sell() {

		//listar como paginador las ofertas
		$all = $this->SellRent->find('all', ['conditions' => ['SellRent.status' => $this->active, 'SellRent.type != ' => 0]]);
		$this->set('offers', $this->paginate($all));

		$this->render('index');

    }  


    //ofertas disonibles para la venta 
	public function view() {

		$id=$this->id;

		//listar como paginador las ofertas
		$offer = $this->SellRent->get($id, ['contain' => ['Offers']]);
		$this->set('offer', $offer);

		//si no hay datos en la tabla sell rent
		if(empty($offer)) { $this->redirect(['action' => 'index']); }

		$this->set('offer', $offer);
		$this->set('offerAlerts', $offer->offers);



    } 
	


	//pagina principal 
	public function trash() {

		$this->paginate = ['limit'=>100, ];

	        if($this->request->is('post')) {

				echo pr($this->request->data);

	            if($this->request->data['checkbox']) {

	            	foreach($this->request->data['checkbox'] as $offerID) {
	                    //$this->SellRent->id = $userID;
	                   $data=['status' => $this->active];
	                   $dato = $this->SellRent->get($offerID);
	                   $oferta = $this->SellRent->patchEntity($dato, $data,  ['validate' => false]);            
	                   $this->SellRent->save($oferta);
	                }
	                
	                $all = $this->SellRent->find('all', ['conditions' => ['SellRent.status' => $this->inactive], 'order' => ['SellRent.id DESC'],]);
	                $this->Flash->exito(__d('administrator', 'La(s) oferta(s) se han activado exitosamente.'));
	                $count = $all->count();

	                //redireccionar si no hay ofertas inactivas
	                if($count == 0) {
	                	$this->redirect(['action' => 'index']);
	            	}


	            }

	        }

		//listar como paginador las ofertas
		$all = $this->SellRent->find('all', ['conditions' => ['SellRent.status' => $this->inactive], 'order' => ['SellRent.id DESC'],]);
        $this->set('offers', $this->paginate($all));


	        $this->render('index');

    } 

	
	
	
}
