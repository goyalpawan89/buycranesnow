<?php 

namespace Front\Controller\Component;

use Cake\Controller\Component;
use Cake\ORM\TableRegistry;
use Cake\Core\Configure;
use Cake\Network\Http\Client;

use Cake\Filesystem\Folder;
use Cake\Filesystem\File;


class FunctionComponent extends Component {
    
    public $components = array('Session', 'RequestHandler', 'Auth', 'Flash', 'Redirect');
    public $helpers = ['Html', 'Form', 'Session','Paginator'];

	public $controller = null;
    


	public function randomCategory($cat, $num) {

		$table = TableRegistry::get('Administrator.Categories');
    	
    	$table->Posts->belongsToMany('Fields');
    	$categoria = $table->find('All',['conditions'=>['Categories.id'=>$cat], 'contain'=>['Posts'=>['conditions'=>['Posts.status'=>'active'], 'Fields']]])->first();
    	$categoria=$categoria->posts;
		
		$rand = range(0, count($categoria)-1); 
		shuffle($rand); 

		$random=[];
		
		for($a=0;$a<=$num;$a++){
			
		foreach ($categoria[$rand[$a]]->fields as $key=>$value) {
			if($value['option_key']=='Millas'){
				$millas=$value['_joinData']['value'];
			}
		}			
		      $data=['id'=>$categoria[$rand[$a]]->id, 'name'=>$categoria[$rand[$a]]->name, 'descripcion'=>$categoria[$rand[$a]]->excerpt, 'millas'=>$millas, 'more'=>$categoria[$rand[$a]]->description];

		      array_push($random, $data);
		}
		return $random;
		
	}



	public function randomCategoryUser($cat, $num, $id) {

		$table = TableRegistry::get('Administrator.Categories');
		$ranking = TableRegistry::get('Administrator.Ranking');
    	
    	$table->Posts->belongsToMany('Fields');
    	
    	$categoria = $table->find('All',['conditions'=>['Categories.id'=>$cat], 'contain'=>['Posts'=>['conditions'=>['Posts.status'=>'active'], 'Fields']]])->first();
    	
    	$categoria=$categoria->posts;
		
		$rand = range(0, count($categoria)-1); 
		shuffle($rand); 

		

		$random=[];
		
		for($a=0;$a<=$num;$a++){
			
		foreach ($categoria[$rand[$a]]->fields as $key=>$value) {
			if($value['option_key']=='Millas'){
				$millas=$value['_joinData']['value'];
			}
		}	

		      $data=['id'=>$categoria[$rand[$a]]->id, 'name'=>$categoria[$rand[$a]]->name, 'descripcion'=>$categoria[$rand[$a]]->excerpt, 'millas'=>$millas, 'more'=>$categoria[$rand[$a]]->description];

		      array_push($random, $data);
		}
		return $random;
		
	}


	public function logs($id, $msj) {

		$log = TableRegistry::get('Administrator.Logs');
    	$msj='El usuario ha: '.$msj.'';
		$data=['player_id'=>$id, 'action'=>$msj];
        $save=$log->newEntity($data);

        return $log->save($save);
        
	}


	public function millas($id) {

		$usuario = TableRegistry::get('Administrator.Players');
		$user=$usuario->find('All',['conditions'=>['Players.id'=>$id], 'contain'=>['Ranking'=>['conditions'=>['Ranking.status'=>'active']]]])->first();

		$conteo=0;
		foreach ($user->ranking as $key => $value) {
			$conteo=$value['millas']+$conteo;
		}

		$data=['rank'=>$conteo];
        $save = $usuario->patchEntity($user, $data); 
        if ($usuario->save($save) ){

        	$resultado=$conteo;
        }

		return $resultado;
	}


	public function retos($id, $idreto, $code) {

		$retos = TableRegistry::get('Administrator.Posts');
		$ranking = TableRegistry::get('Administrator.Ranking');

    	$reto=$retos->find('all',['conditions'=>['Posts.status'=>'active', 'Posts.id'=>$idreto], 'contain'=>['Fields']])->first();
    	if(!empty($reto)){
    		foreach ($reto->fields as $key=>$value) {
				if($value['option_key']=='Millas'){
					$millas=$value['_joinData']['value'];
				}
			}

			$rank=$ranking->find('All',['conditions'=>['Ranking.player_id'=>$id, 'Ranking.post_id'=>$reto->id]])->count();
			if($rank==0){
				$data=['post_id'=>$reto->id, 'player_id'=>$id, 'code_id'=>$code, 'millas'=>$millas];
		        $save=$ranking->newEntity($data);

		        if($ranking->save($save)){
		        	$this->millas($id);	
		        	$mensaje=['name'=>$reto->name,'millas'=>$millas,'mensaje'=>'Guardado'];
		        }

			}else{
				$mensaje=['name'=>$reto->name,'millas'=>$millas,'mensaje'=>'Existe'];
			}


    	}else{
    		$mensaje=['mensaje'=>'Inactive'];
    	}

        
        return $mensaje;
        
	}



	public function url($id, $idreto, $code) {

		$ranking = TableRegistry::get('Administrator.Ranking');

    	if(!empty($code)){

			$rank=$ranking->find('All',['conditions'=>['Ranking.player_id'=>$id, 'Ranking.code_id'=>$code]])->count();
			if($rank==0){
				$data=['post_id'=>$idreto, 'player_id'=>$id, 'code_id'=>$code];
		        $save=$ranking->newEntity($data);

		        if($ranking->save($save)){
		        	
		        	$mensaje=['mensaje'=>'Guardado'];
		        }

			}else{
				$mensaje=['mensaje'=>'Existe'];
			}


    	}else{
    		$mensaje=['mensaje'=>'Inactive'];
    	}

        
        return $mensaje;
        
	}




	


   
		



}