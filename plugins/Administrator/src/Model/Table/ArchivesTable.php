<?php
namespace Administrator\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;


$validator = new Validator();

class ArchivesTable extends Table
{

    public function initialize(array $config)
        {   
            /*$this->table('trms');
            $this->primaryKey('id');*/
            
            $this->addBehavior('Timestamp');

            $this->belongsTo('Users');
            $this->hasMany('Categories');
            $this->belongsToMany('Posts', ['joinTable' => 'archives_posts']);
            $this->belongsToMany('Gadgets', ['joinTable' => 'gadgets_archives']);
             

            /*$this->addAssociations([
				      'belongsTo' => ['User'],
				      'hasMany' => ['Category'],
                      'belongsToMany' => ['Post']
				    ]);
            */

        
        }


    

}
?>