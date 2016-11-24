<?php

namespace Front\Controller;

use Front\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Network\Exception;
use Cake\Mailer\Email;

class PagesController extends AppController
{   

    
 	public function initialize() {    
        parent::initialize();
    }


    public function index() {	  	
    $posts = TableRegistry::get('Administrator.Posts');

    $slug = $this->id;

	$content = $posts->find('all', ['conditions' => ['Posts.slug' => $slug, 'Posts.status' => $this->active, 'Posts.type' => 'Page']])->contain(['Archives', 'Users'])->first();
	$this->set('content', $content);


            
            if($content['location'] == 'Testimonials') {

                $pageHome = $posts->find('all', ['conditions' =>  ['Posts.type' => 'Page', 'Posts.location' => 'Homepage'] ]);
                $this->set('testimonios', $pageHome);

            } 

            if($this->request->is('post')) {

            	//agregamos variables para el layout datos de usuario.
               $subject = __d('front', 'un nuevo mensaje desde '). $this->blogName;
               $description = __d('front', 'Este es un mensaje automático desde tu sitio web. el siguiente es un correo enviado el');
               $datosEnvio = array_merge(['logo' => $this->Get->get_frontend_images_url('logo'), 'blogName' => $this->blogName, 'subject' => $subject, 'description' => $description], $this->request->data);

                            //email de contactenos
                            $email = new Email('default');
                            $email->emailFormat('html') //tipo de mensaje (plantilla en html)
                                  ->template('Front.default', 'Front.default') //template default (Contacto) del email y Layout del email (TEMPLETE / LAYOUT)
                                  ->from([$this->noReply => $this->blogName])
                                  ->to($this->blogEmail)
                                  ->subject($subject)
                                  ->viewVars($datosEnvio)
                                  ->send();
            				
            				$this->Flash->exito(__d('front', 'Gracias por cominicarte con nosotros'));
                    $this->redirect(array('action' => 'index',$content->slug)); 

            }

            
                $hiddenId = $this->Cookie->read('post.id'); 
                $hiddeName = $this->Cookie->read('post.name'); 

                if(isset($hiddeName) && !empty($hiddeName)) {


                $campos = ['name' => ['label' => __($this->extras['name']), 'class' => 'input-contact', 'required' => 'required'], 
                           'last_name' => ['label' => __($this->extras['last_name']), 'class' => 'input-contact', 'required' => 'required'], 
                           'tel' => ['label' => __($this->extras['phone']), 'placeholder' => __($this->extras['phone']), 'class' => 'input-contact indicative_tel', 'type' => 'tel', 'required' => 'required', 'pattern'=>'^(?:0|\(?\+33\)?\s?|0033\s?|)[1-79](?:[\.\-\s]?\d\d|){4}$' ], 
                           'cel' => ['label' => __($this->extras['celphone']), 'placeholder' => __($this->extras['celphone']), 'class' => 'input-contact indicative_cel', 'type' => 'tel', 'required' => 'required'], 
                           'country' => ['label' => __($this->extras['country']), 'class' => 'input-contact country', 'required' => 'required', 'type' => 'select', 'empty' => __($this->extras['select_default']) ], 
                           'state' => ['label' => __($this->extras['state']), 'class' => 'input-contact state', 'required' => 'required','type' => 'select',  'empty' => __($this->extras['select_default']) ], 
                           'city' => ['label' => __($this->extras['city']), 'class' => 'input-contact city', 'required' => 'required','type' => 'select',  'empty' => __($this->extras['select_default']) ], 
                           'email' => ['label' => __($this->extras['email']), 'class' => 'input-contact', 'required' => 'required'], 
                           'address' => ['label' => __($this->extras['address']), 'class' => 'input-contact', 'required' => 'required'], 
                           'zip_code' => ['label' => __($this->extras['zip_code']), 'class' => 'input-contact', 'required' => 'required'], 
                           'company_name' => ['label' => __($this->extras['company_name']), 'class' => 'input-contact', 'required' => 'required'], 
                           'company_position' => ['label' => __($this->extras['company_position']), 'class' => 'input-contact', 'type' => 'text', 'required' => 'required'], 
                           'crane' => ['label' => __($this->extras['crane']), 'type' => 'text', 'value' => $hiddeName, 'disabled' => true],
                           'comments' => ['label' => __($this->extras['comments']), 'class' => 'input-contact textarea', 'type' => 'textarea', 'required' => 'required'], 
                           __($this->extras['send']) => ['label' => false, 'class' => 'btn btn-sell fondo1 fondoh3 color3 colorh0', 'type' => 'submit'], 
                          ];
                

            } else {

                $campos = ['name' => ['label' => __($this->extras['name']), 'class' => 'input-contact', 'required' => 'required'], 
                           'last_name' => ['label' => __($this->extras['last_name']), 'class' => 'input-contact', 'required' => 'required'], 
                           'tel' => ['label' => __($this->extras['phone']), 'placeholder' => __($this->extras['phone']), 'class' => 'input-contact indicative_tel', 'type' => 'tel', 'required' => 'required', 'pattern'=>'^(?:0|\(?\+33\)?\s?|0033\s?|)[1-79](?:[\.\-\s]?\d\d|){4}$'], 
                           'cel' => ['label' => __($this->extras['celphone']), 'placeholder' => __($this->extras['celphone']), 'class' => 'input-contact indicative_cel', 'type' => 'tel', 'required' => 'required'], 
                           'country' => ['label' => __($this->extras['country']), 'class' => 'input-contact country', 'required' => 'required', 'type' => 'select', 'empty' => __($this->extras['select_default']) ], 
                           'state' => ['label' => __($this->extras['state']), 'class' => 'input-contact state', 'required' => 'required','type' => 'select',  'empty' => __($this->extras['select_default']) ], 
                           'city' => ['label' => __($this->extras['city']), 'class' => 'input-contact city', 'required' => 'required','type' => 'select',  'empty' => __($this->extras['select_default']) ], 
                           'email' => ['label' => __($this->extras['email']), 'class' => 'input-contact', 'required' => 'required'], 
                           'address' => ['label' => __($this->extras['address']), 'class' => 'input-contact', 'required' => 'required'], 
                           'zip_code' => ['label' => __($this->extras['zip_code']), 'class' => 'input-contact', 'required' => 'required'], 
                           'company_name' => ['label' => __($this->extras['company_name']), 'class' => 'input-contact', 'required' => 'required'], 
                           'company_position' => ['label' => __($this->extras['company_position']), 'class' => 'input-contact', 'type' => 'text', 'required' => 'required'], 
                           'comments' => ['label' => __($this->extras['comments']), 'class' => 'input-contact textarea', 'type' => 'textarea', 'required' => 'required'], 
                           __($this->extras['send']) => ['label' => false, 'class' => 'btn btn-sell fondo1 fondoh3 color3 colorh0', 'type' => 'submit'], 
                          ];

            }

            $this->set('campos', $campos);
          

                  if($content['location'] == 'Planes' || $content['location'] == 'Testimonials') { //vistas especiales para testimonials y para planes
                      
                      $this->render($content->location); 

                    } else { 
                      
                          if($content['page_theme'] != 'Default') {
                            $this->render($content->page_theme); 

                          }
                    }       




            

    }



   


}
