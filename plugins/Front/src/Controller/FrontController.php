<?php

namespace Front\Controller;

use Front\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\I18n\I18n;

class FrontController extends AppController {   

    public function beforeFilter(\Cake\Event\Event $event) {
    parent::beforeFilter($event);
    }

 
    public function index() {	
        
        //activar prueba cache
        $this->response->cache('-1 minute', '+5 days');

    	// posts por categoria
        $posts = TableRegistry::get('Administrator.Posts');
        $generals = TableRegistry::get('Administrator.Generals');
        $gadgets = TableRegistry::get('Administrator.Gadgets');
               
               //funcion de filtro (buscar post por categoría)
               	$destacados = $posts->find('all', ['conditions' => ['Posts.status' => 'active', 'Posts.type' => 'Post'], 'contain' => ['Categories'] ]);
				$destacados->matching('Categories', function ($q) {
					    return $q->where(['Categories.id' => 9]);
				});

    	$this->set('destacados', $destacados);

        $publicityHome = $gadgets->find('all', ['conditions' => ['Gadgets.type' => 'home', 'Gadgets.status' => $this->active]])->order('rand()')->first();

        $publicity = $publicityHome;
        $this->set('publicity', $publicity);
    	    	
                

    }


    public function newsletters() { 
        $news = TableRegistry::get('Administrator.Newsletters');

        //renderizar el default no necesito vista para esta sección.
        $this->render('Default/index');

            //envio de datos por post
            if($this->request->is('post') && isset($this->request->data['email'])) { 
                
                    $conteo = $news->find('all', ['conditions' => ['Newsletters.email' => $this->request->data['email']]])->count();

                    if($conteo === 0) {
                        
                        $save = $news->newEntity(['email' => $this->request->data['email']]);
                        $news->save($save);

                        $message = __d('front', 'Se han guardado los datos exitosamente');

                                //agregamos 
                                $subject = __d('front', 'Se ha realizado una nueva suscripción desde '). $this->blogName;
                                $datosEnvio = array_merge(['news' => true], $this->request->data);

                                        //email de oferta para la empresa
                                        $email = new Email('default');
                                        $email->emailFormat('html') //tipo de mensaje (plantilla en html)
                                              ->template('Front.default', 'Front.default') //template default (Contacto) del email y Layout del email (TEMPLETE / LAYOUT)
                                              ->from([$this->noReply => $this->blogName])
                                              ->to($this->blogEmail, 'Admin')
                                              ->subject($subject)
                                              ->viewVars($datosEnvio)
                                              ->send();


                    } else {

                        $message = __d('front', 'El correo electrónico ya se encuentra registrado');

                    }

                    $this->redirect(['controller' => 'Front', 'action' => 'index']); 
                    $this->Flash->exito($message);


            //si intentan ingresar directamente al newsletter sale error
            } else {

                $this->redirect(['controller' => 'Front', 'action' => 'index']); 
                $this->Flash->alert(__d('front', 'Acceso denegado'));

            }

        }




}
