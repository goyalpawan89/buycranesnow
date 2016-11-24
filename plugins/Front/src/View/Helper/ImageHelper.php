<?php
/* src/View/Helper/LinkHelper.php */
namespace Front\View\Helper;

use Cake\View\Helper;
use Cake\Controller\Component;
use Cake\ORM\TableRegistry;

class ImageHelper extends Helper {

    public $helpers = ['Url'];

    // url de cada imagen por id y por tamaño.
    public function url($id, $size) {
    $archives = TableRegistry::get('Administrator.Archives');

        if(isset($id) && !empty($id)) {

            $archive = $archives->find('all', ['conditions' => ['id' => $id]])->first();

            if($archive){

                if($size == 'medium' || $size == 'MEDIUM' || $size == 'Medium') { // validaciones por si se escribe diferente la varbiale
                $image =  "/".$archive->folder.'medium-'.$archive->filename;
                if (!empty($archive->filename) && file_exists(substr($image, 1)) ) {
                    $image_url = $this->Url->build('/', true).$archive->folder.'medium-'.$archive->filename;; // imagen miniatura (llamo el medium fijo por si lo escriben mal en la variable)
                } else { 
                    $image_url =  $this->Url->build('/', true).$archive->folder.$archive->filename; // imagen miniatura (llamo el medium fijo por si lo escriben mal en la variable)
                }
            } else {
                $image_url = $this->Url->build('/', true).$archive->folder.$archive->filename; //imagen completa
            }
            return $image_url;


            }else{
                return NULL;
            }

            
        }

            return NULL;

    }


    // imagenes chekeadas en la galería dependiendo del id
    public function gallery_image_checked($postid, $imageid) {
    $archives = TableRegistry::get('Administrator.Archives');
    $archive = $archives->get($imageid, ['contain' => ['Posts']])->toArray();

       foreach ($archive['posts'] as $post) {

               if($post['id'] == $postid) {
                    return 'checked';
               }

           
       }
         
    }


    // imagenes chekeadas en la galería dependiendo del id
    public function get_image_by_user_id($userID, $size = NULL) {
    $users = TableRegistry::get('Administrator.Users');
    $usuario = $users->get($userID, ['contain' => ['Archives']])->toArray();

       if(isset($usuario) && !empty($usuario['archive'])) {

           $archive = $usuario['archive'];
           $full =  "/".$archive['folder'].$archive['filename'];
           $medium =  "/".$archive['folder'].'medium-'.$archive['filename'];

           if (!empty($archive['folder']) && !empty($medium) && $size == 'medium' && file_exists(substr($medium, 1)) ) {

                $image_url = $medium; // imagen miniatura (llamo el medium fijo por si lo escriben mal en la variable)

            } elseif (!empty($archive['folder']) && !empty($full) && file_exists(substr($full, 1)) || !empty($archive['folder']) && !empty($full) && $size == 'full' && file_exists(substr($full, 1))) {
 
                $image_url = $full;
            
            } else {

                $image_url = NULL;

            }

            return $image_url;
           
       }
         
    }



     // obtener el enlace de las paginas, categorias post etc por id y por controlador
    public function get_thumbnail_by_id($postid, $size = NULL) {
        
        if(isset($postid) && !empty($postid)) {
              
        $posts = TableRegistry::get('Administrator.Posts');
        $archives = TableRegistry::get('Administrator.Archives');

        $post = $posts->get($postid);
        $id = $post->archive_id;

            if(isset($id) && !empty($id)) {

                $archive = $archives->find('all', ['conditions' => ['id' => $id]])->first();

                if($size == 'medium' || $size == 'MEDIUM' || $size == 'Medium') { // validaciones por si se escribe diferente la varbiale
                    
                    $image =  "/".$archive->folder.'medium-'.$archive->filename;

                    if (!empty($archive->filename) && file_exists(substr($image, 1)) ) {

                        $image_url = $this->Url->build('/', true).$archive->folder.'medium-'.$archive->filename;; // imagen miniatura (llamo el medium fijo por si lo escriben mal en la variable)

                    } else { 

                        $image_url =  $this->Url->build('/', true).$archive->folder.$archive->filename; // imagen miniatura (llamo el medium fijo por si lo escriben mal en la variable)

                    }

                } else {
                    $image_url = $this->Url->build('/', true).$archive->folder.$archive->filename; //imagen completa
                }

                return $image_url;
            
            } else { 

                return NULL;
            }




              
        }
                   
    }




}