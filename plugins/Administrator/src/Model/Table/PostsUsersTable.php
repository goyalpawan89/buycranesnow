<?php 

namespace Administrator\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\Table;

class PostsUsersTable extends Table
{

 public function initialize(array $config) {

 			$this->addBehavior('Timestamp');

        	$this->table('posts_users');
            $this->primaryKey('id');
            
            $this->belongsTo('Users');
            $this->belongsTo('Posts');
        }
}

?>