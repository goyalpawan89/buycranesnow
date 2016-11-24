<?php

namespace Front\Controller;

use Cake\Core\Configure;
use Front\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Controller\Component;
use Cake\I18n\I18n;

class CategoriesController extends AppController { 

    
 	public function initialize() {
        parent::initialize();

        $find = TableRegistry::get('Administrator.Categories');
        $this->loadComponent('Paginator');
		
 	}

 	public function beforeFilter(\Cake\Event\Event $event) {
    parent::beforeFilter($event);

		$posts = TableRegistry::get('Administrator.Posts');
	 	
 	}

 	

 	public $paginate = ['limit' => 100];

	public function index() {


			$find = TableRegistry::get('Administrator.Categories');
			$posts = TableRegistry::get('Administrator.Posts');
			$fields = TableRegistry::get('Administrator.FieldsPosts');


			// this->id obtiene el parametro [pass][0] desde el appcontroller.
			$slug = $this->id;
			$content = $find->find('all', ['conditions' => ['slug' => $slug, 'status' => $this->active], 'fields' => ['name', 'description', 'id', 'slug', 'archive_id'] ] )->first();
			$this->set('content', $content);

			//funcion de filtro (buscar post por categoría)

			if(isset($this->request->query['avalible'])) {

							$query = $posts->find('all', ['conditions' =>['Posts.status' => $this->active, 'Posts.type' => 'Post'], 	 
														  'order' => ['Posts.created' => 'ASC'], 
														  //'contain' => ['Fields'],
														  'fields' => ['name', 'id', 'archive_id', 'created', 'slug', 'crane_status', 'user_id'],
														  'translations' => ['locales' => ['en'] ] ]
												 )
												->matching('Categories', function ($q) {
															   return $q->where(['Categories.slug' => $this->id]);
												})
												->matching('FieldsPosts', function($f) {
															   return $f->where(['FieldsPosts.value' => $this->request->query['avalible']]);
												});

			} else {

				$query = $posts->find('all', ['conditions' =>['Posts.status' => $this->active, 'Posts.type' => 'Post'], 	 
														  'order' => ['Posts.created' => 'ASC'], 
														  //'contain' => ['Fields'],
														  'fields' => ['name', 'id', 'archive_id', 'created', 'slug', 'crane_status', 'user_id'],
														  'translations' => ['locales' => ['en'] ] ]
												 )
												->matching('Categories', function ($q) {
															   return $q->where(['Categories.slug' => $this->id]);
												});

			}

			
			
			$this->set('posts', $this->paginate($query));


	}





	public function crane_photos() {

			$find = TableRegistry::get('Administrator.Categories');
			$posts = TableRegistry::get('Administrator.Posts');
			$fields = TableRegistry::get('Administrator.FieldsPosts');


			// this->id obtiene el parametro [pass][0] desde el appcontroller.
			$slug = $this->id;
			$content = $find->find('all', ['conditions' => ['slug' => $slug, 'status' => $this->active], 'contain' => ['Posts']] )->first();
			$this->set('content', $content);

			//funcion de filtro (buscar post por categoría)
			$query = $posts->find('all', ['conditions' =>['Posts.status' => $this->active, 'Posts.type' => 'Post'], 'order' => ['Posts.created' => 'DESC'], 'contain' => ['Fields'], 'translations' => ['locales' => ['en'] ] ])->matching('Categories', function ($q) {
					   return $q->where(['Categories.slug' => $this->id]);
					 });
			
			$this->set('posts', $this->paginate($query));	

			$this->render('index');

	}

	//vistado en forma de listado con la funcion de indezx
	public function crane_list() {
			$this->setAction('index');	
			$this->render('crane_list');
	}


	

}
