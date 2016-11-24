<?php 

namespace Administrator\Model\Entity;

use Cake\ORM\Behavior\Translate\TranslateTrait;
use Cake\Auth\DefaultPasswordHasher;
use Cake\ORM\Entity;
use Cake\ORM\Behavior\TimestampBehavior;

class Gadgets extends Entity
{

	use TranslateTrait;
    //protected $_accessible = ['*' => true];
    protected $_accessible = ['*' => true];


}
?>