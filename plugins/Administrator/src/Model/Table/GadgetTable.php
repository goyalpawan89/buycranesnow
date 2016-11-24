<?php 
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;


$validator = new Validator();

class GadgetTable extends Table
{	

		public function initialize(array $config)
        {   
			  $this->belongsTo(['Categories', 'Post']);
			  $this->belongsToMany('File');
			  //public $hasMany = array('Category');
			  //public $hasAndBelongsToMany = array('File');
		}
		  
	function getGadgets($status) {  //obtiene todos los gadgets dependiendo del estado buscar todos los gadgets (all)
            $gadgets = $this->find('all', array('conditions' => array('Gadget.status =' => $status)));
            return $gadgets;          
	}


	function getGadgetsCount($status) { //obtiene todos los gadgets dependiendo del estado conteo (count)
            $gadgets = $this->find('count', array('conditions' => array('Gadget.status =' => $status)));
            return $gadgets;          
	}

	function getGadget($id) { //obtiene todos los gadgets dependiendo del estado conteo (count)
            $gadget = $this->find('first', array('conditions' => array('Gadget.id =' => $id)));
            return $gadget;          
	}


	public function beforeSave($options = array()){ 
		  
		      if(isset($this->data['Gadget']['description'])) {
				       $this->data['Gadget']['description'] = strip_tags($this->data['Gadget']['description'], '<center><audio><table><tr><td><p><a><span><strong><ul><li><h1><h2><h3><h4><h5><h6><font><br>');
					   return true;  
	          }

	          if($this->view == 'add') {
					  $this->data['Gadget']['user_id'] = $_SESSION['Auth']['User']['id'];  return true; 
			  }
			  
	}


}

