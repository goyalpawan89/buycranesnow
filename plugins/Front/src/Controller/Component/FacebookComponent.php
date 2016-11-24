<?php 

/*App::uses('Component', 'Controller');
App::uses('Controller',    'Controller');
App::uses('ClassRegistry', 'Utility');

App::uses('HttpSocket', 'Network/Http');
App::uses('JsonView', 'View');*/


namespace Front\Controller\Component;

use Cake\Controller\Component;
use Cake\ORM\TableRegistry;
use Cake\Core\Configure;
use Cake\Network\Http\Client;

use Cake\Filesystem\Folder;
use Cake\Filesystem\File;


class FacebookComponent extends Component {
    
    public $components = array('Session', 'RequestHandler', 'Auth', 'Flash');

	public $helpers = array('Session');
	public $controller = null;

	public function connect() {?>

		<script>
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '498389210308893',
      xfbml      : true,
      version    : 'v2.4'
    });
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
</script>
	
	<?php
}


   
		



}