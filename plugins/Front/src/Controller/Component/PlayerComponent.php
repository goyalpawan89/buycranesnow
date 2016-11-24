<?php 

namespace Front\Controller\Component;

use Cake\Controller\Component;
use Cake\ORM\TableRegistry;
use Cake\Core\Configure;
use Cake\Network\Http\Client;

use Cake\Filesystem\Folder;
use Cake\Filesystem\File;


class PlayerComponent extends Component {
    
    public $components = array('Session', 'RequestHandler', 'Auth', 'Flash', 'Redirect');
    public $helpers = ['Html', 'Form', 'Session','Paginator'];

	public $controller = null;
    


	public function user() {
		if($this->request->session()->read('Player.id')){
			return $this->request->session()->read('Player.id');
		}else{
			return false;
		}
		
        $token=$_COOKIE['token'];
        $this->request->session()->write('Player.token', $token);

        setcookie("token", "", time() - 3600);
        unset($_COOKIE['token']);
	}


	public function auth() {

		if($this->request->session()->read('Player.id') and !$this->request->session()->read('Player.token')){
			$this->request->session()->destroy();
		}

		if(!$this->request->session()->read('Player.id')){
			$this->request->session()->destroy();
		}

	}


	


   
		



}