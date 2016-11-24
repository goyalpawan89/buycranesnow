<?php 

namespace Front\Controller\Component;

use Cake\Controller\Component;
use Cake\ORM\TableRegistry;
use Cake\Core\Configure;
use Cake\Network\Http\Client;

use Cake\Filesystem\Folder;
use Cake\Filesystem\File;


class CustomerComponent extends Component {
    
    public $components = array('Session', 'RequestHandler', 'Auth', 'Flash', 'Redirect');
    public $helpers = ['Html', 'Form', 'Session','Paginator'];

	public $controller = null;
    


	public function user() {
		if($this->request->session()->read('Auth.User.id')){
			return $this->request->session()->read('Auth.User.id');
		}else{
			$this->request->session()->destroy();
			return false;
			//return $this->request->session()->destroy();
		}
		
        $token=$_COOKIE['token'];
        $this->request->session()->write('Auth.User.token', $token);

        setcookie("token", "", time() - 3600);
        unset($_COOKIE['token']);
	}


	public function auth() {

		/*if($this->request->session()->read('Auth.User.id') and !$this->request->session()->read('Auth.User.token')){
			$this->request->session()->destroy();
		}*/

		if(!$this->request->session()->read('Auth.User.id')){
			$this->request->session()->destroy();
		}

	}


	


   
		



}