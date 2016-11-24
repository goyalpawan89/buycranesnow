<?php
namespace Administrator\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;


$validator = new Validator();

class PostsTable extends Table
{

    public function initialize(array $config) {
            
        	$this->addBehavior('Timestamp');
            $this->addBehavior('Translate', ['fields' => ['name', 'description', 'excerpt']]);
            
            $this->belongsTo('Users');
            $this->belongsTo('Gadget');
            $this->HasMany('ArchivesPosts');
            $this->HasMany('FieldsPosts');

            //favoritos
            $this->HasMany('PostsUsers', ['joinTable' => 'posts_users']);

            //alquilar comprar grua
            $this->HasMany('SellRent', ['joinTable' => 'sell_rent']);

            
            $this->belongsToMany('Fields', ['joinTable' => 'fields_posts']);


            $this->belongsToMany('Archives',['joinTable' => 'archives_posts']);
            $this->belongsToMany('Categories',['joinTable' => 'categories_posts']);


            $this->HasMany('Compare',[
                'foreignKey' => 'post_id',
                ]);

           
        }



         public function validationDefault(Validator $validator) {
                $validator->notEmpty('name', __('Debes ingresar un Titulo.'));

        return $validator;

    }


}

