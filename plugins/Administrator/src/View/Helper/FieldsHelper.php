<?php
/* src/View/Helper/LinkHelper.php */
namespace Administrator\View\Helper;

use Cake\View\Helper;
use Cake\Controller\Component;
use Cake\ORM\TableRegistry;

class FieldsHelper extends Helper {

    // url de cada imagen por id y por tamaño.
    public function fields_by_type($type) {
        $fields = TableRegistry::get('Administrator.Fields');
        $allFields = $fields->find('all', ['conditions' => ['Fields.type' => $type]])->toArray();
        
        if($allFields && $type && !empty($allFields) && !empty($type)) {

            return $allFields;

         } else {

            return NULL;
        }

    }


    // imagenes chekeadas en la galería dependiendo del id
    public function get_field_by_id($postid, $imageid) {
    $archives = TableRegistry::get('Administrator.Archives');
    $archive = $archives->get($imageid, ['contain' => ['Posts']])->toArray();

       foreach ($archive['posts'] as $post) {

               if($post['id'] == $postid) {
                    return 'checked';
               }

           
       }
         
    }




}