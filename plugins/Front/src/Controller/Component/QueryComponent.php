<?php 

namespace Front\Controller\Component;

use Cake\Controller\Component;
use Cake\ORM\TableRegistry;
use Cake\Core\Configure;
use Cake\Network\Http\Client;

use Cake\Filesystem\Folder;
use Cake\Filesystem\File;


class QueryComponent extends Component {
    
    public $components = array('Session', 'RequestHandler', 'Auth', 'Flash', 'Redirect');
    public $helpers = ['Html', 'Form', 'Session','Paginator'];

	public $controller = null;
    


	public function search($search, $array) {

	/*echo pr($array);
	echo pr($search);*/
	

	$array=[
	'Category' => '2',
    'price_since' => '5000000',
    'price_until' => '150000000',
    'tons_since' => '1',
    'tons_until' => '3000',
    'brand' => 'GROVE',
    'maker' => 'empty',
    'model' => 'empty',
    'avalible' => 'ALQUILER',
    'year' => '2007',
    'continent' => 'América',
    'country' => 'empty',
    'city' => 'empty',
    'postal_code'=> 'empty'
    ];

   echo pr($array);



	$data=[];
	
	foreach ($search as $key => $value) {
		//echo pr($value->fields);
		$dis=0;
		$cero=0;
		foreach ($value->fields as $key1 => $value1) {
			# code...

			$value1=json_decode($value1, true);
				
				//foreach ($array as $clave => $ss) {
					
					foreach ($array as $resultado) {

						//echo $resultado;
						if($resultado!='empty'){

							if(in_array($resultado, $value1['_joinData'])) {
								$dis++;
							}


						}
					}


					
				//}


		}

		echo $dis;
		
		
				if($dis){
					$datos=['id'=>$value['id'],  'name' => $value['name']];		
					array_push($data, $datos);	
				}
					
				


	}

	echo pr($data);


        
	}




	


   
		



}