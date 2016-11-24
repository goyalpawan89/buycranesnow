<?php
namespace App\Controller\Config;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\ORM\TableRegistry;
use Cake\Utility\Text;

class CountryController extends AppController{
	
	 //pagina principal 
	public function index() {
	    
		$country = $this->Country->find('All', ['conditions'=> ['Country.Code ='=>'COL'], 'contain' => ['City']])->toArray();
		$this->set('datos', $country);
		$this->render('view');
		
	}

	public function all() {
	    
		$country = $this->Country->find('All', ['group' => ['Country.Code'], 'contain' => ['City']])->toArray();
		
		$total = $this->Country->find('All', ['group' => ['Country.Code']]);
		$total = $total->count();
		$this->set('total', $total);
		$this->set('datos', $country);


	
		$this->render('all');
	
	}


	public function one($var=null) {
	    
	    if(isset($var)){
	    	$country = $this->Country->find('All', ['conditions'=> ['Country.Code ='=>$var], 'contain' => ['City']])->toArray();
			$this->set('datos', $country);
			$this->render('view');
	    }else{
	    	$this->redirect(['action'=>'index']);
	    }
		
		
	}


	
	
}
