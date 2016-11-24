<?php
/* src/View/Helper/LinkHelper.php */
namespace Administrator\View\Helper;

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

            if($size == 'medium' || $size == 'MEDIUM' || $size == 'Medium') { // validaciones por si se escribe diferente la varbiale
                
                $image =  "/".$archive->folder.'medium-'.$archive->filename;

                if (!empty($archive->filename) && file_exists(substr($image, 1)) ) {

                    $image_url = $archive->folder.'medium-'.$archive->filename;; // imagen miniatura (llamo el medium fijo por si lo escriben mal en la variable)

                } else { 

                    $image_url =  $archive->folder.$archive->filename; // imagen miniatura (llamo el medium fijo por si lo escriben mal en la variable)

                }

            } else {
                $image_url = $archive->folder.$archive->filename; //imagen completa
            }

            return $image_url;
        }

            return NULL;

    }


    // obtiene la url completa de las imagenes NECESITO OTRA FUNCION DE ENLACE COMPLETO EL OTRO (FUNCTION URL) FUNCIONA PARA LAS IMAGENES EN AJAX DEL SELECCION DE IMAGENES
    public function get_image_url($id, $size) {
    $archives = TableRegistry::get('Administrator.Archives');

        if(isset($id) && !empty($id)) {

            $archive = $archives->find('all', ['conditions' => ['id' => $id]])->first();

            if($size == 'medium' || $size == 'MEDIUM' || $size == 'Medium') { // validaciones por si se escribe diferente la varbiale
                
                $image =  "/".$archive->folder.'medium-'.$archive->filename;

                if (!empty($archive->filename) && file_exists(substr($image, 1)) ) {

                    $image_url = $archive->folder.'medium-'.$archive->filename;; // imagen miniatura (llamo el medium fijo por si lo escriben mal en la variable)

                } else { 

                    $image_url =  $archive->folder.$archive->filename; // imagen miniatura (llamo el medium fijo por si lo escriben mal en la variable)

                }

            } else {
                $image_url = $archive->folder.$archive->filename; //imagen completa
            }

            return $this->Url->build('/', true).$image_url;
        }

            return NULL;

    }


    // imagenes chekeadas en la galería dependiendo del id del POST
    public function gallery_image_checked($postid, $imageid, $tipo) {

        //echo $tipo;

        if($tipo=='Pages'){
            $tipo='Posts';
        }
    $archives = TableRegistry::get('Administrator.Archives');
    $archive = $archives->get($imageid, ['contain' => [$tipo]])->toArray();

   // echo pr($archive);

       foreach ($archive[strtolower($tipo)] as $post) {

               if($post['id'] == $postid) {
                    return 'checked';
               }

           
       }
         
    }






}