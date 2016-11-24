<?php

namespace Front\Controller;

use Front\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Controller\Component;
use Cake\Mailer\Email;


class NewslettersController extends AppController {

        public function index() { 
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
                                $datosEnvio = array_merge(['logo' => $this->Get->get_frontend_images_url('logo'),
                                                           'news' => true,
                                          						     'subject' => $subject,
                                          						     'blogName' => $this->blogName, 
                                          						    ], 


                                						  $this->request->data);

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

		            $this->redirect($this->referer()); 
		            $this->Flash->exito($message);


        	//si intentan ingresar directamente al newsletter sale error
	        } else {

	        	$this->redirect($this->referer()); 
		        $this->Flash->alert(__d('front', 'Acceso denegado'));

	        }

    	}

    

}

