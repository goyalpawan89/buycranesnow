<?php 

namespace Administrator\Model\Entity;

use Cake\ORM\Behavior\Translate\TranslateTrait;
use Cake\Auth\DefaultPasswordHasher;
use Cake\ORM\Entity;
use Cake\ORM\Behavior\TimestampBehavior;

class Posts extends Entity {

	use TranslateTrait;
    //protected $_accessible = ['*' => true];
    protected $_accessible = ['*' => true];
    //protected $_accessible = ['archive_id' => true];


}
?>