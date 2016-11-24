<?php foreach ($posts as $key => $post)   {
        
        setlocale(LC_MONETARY, 'en_US');

        $id = $post['post']['id'];
        $precio = $this->Get->get_field_by_post_id($post['post']['id'], 'price');
        $price = $this->Number->currency($precio, $info['currency']);
        //$avalible = $this->Get->get_field_by_post_id($post['post']['id'], 'avalible');
        $beforePrice = $this->Get->get_field_by_post_id($post['post']['id'], 'price_before');
        $antes = $this->Number->currency($beforePrice, $info['currency']);
        $link = $this->Get->get_link($post['post']['id'], 'Posts');
        $year = $this->Get->get_field_by_post_id($post['post']['id'], 'year');
        $marca = $this->Get->get_field_by_post_id($post['post']['id'], 'brand');
        $tons = $this->Get->get_field_by_post_id($post['post']['id'], 'tons');
        $city = $this->Get->get_field_by_post_id($post['post']['id'], 'city');
        $country = $this->Get->get_field_by_post_id($post['post']['id'], 'country');
        $location = $this->Get->get_field_by_post_id($post['post']['id'], 'location');
        $video = $this->Get->get_field_by_post_id($post['post']['id'], 'video');

        //obtener el id de la categoria a la que corresponde
        $avalible = $this->Get->get_cat_avalible($id);
        $avalibleName = 'avalible_'.$avalible;


                            if($avalible == 11) { $btnAvalible = 'rent'; $btnAvalibleAction = '#rent_crane'; } else {  $btnAvalible = 'sell'; $btnAvalibleAction = '#sell_crane'; } // boton comprar  o alquilar
                            if($authUser) { $btnAction = $btnAvalibleAction; } else {  $btnAction = '#login'; } ?>


                          <article id="crane_photos">

                        <h1><?= $this->Html->link(__d('Front', 'Eliminar'), ['controller' => 'Posts', 'action' => 'compare_request_delete', $post['id']], ['confirm' => __d('Front','Desea eliminar este registro?')]);?></h1>
                            <a class="list-post_enlace color3" href="<?= $link; ?>">
                              <aside class="list-post_image" style="background-image:url(<?= $this->Image->url($post['post']['archive_id'], 'medium'); ?>);">
                                
                                <?php

                                 if($post['post']['crane_status'] == 0) {   
                                         if(!empty($beforePrice)) { ?>
                                              <aside class="tag"><span><?= __($extras['promotion']); ?></span></aside>
                                <?php    } 

                                } else { ?>

                                              <aside class="tag <?= 'avalible_'.$post['post']['crane_status']; ?>"><span><?= __($extras[$post['post']['crane_status'].'_avalible']); ?></span></aside>

                                <?php } ?>
                                
                              </aside>
                            


                            <!-- Description -->
                            
                            <aside class="content-side_description" style='width:100% !important; margin-left:0px !important; font-size:12px;'>

                                  <div class="content-side_description_bloque">
                                    
                                    <h1 class="fondo1 content-side_description_title"><?= __($post['post']['name']); ?> | <?= __($extras['code']); ?>-<?= $post['post']['id']; ?></h1>
                                   <?php  /* <div class="content-side_description_text">
                                     <strong><?= __($extras['description']); ?></strong>
                                      <?= $post['post']['description']; ?>
                                    </div>*/?>
                                    
                                    <aside class="all_fields">
                                      <h1 class="fondo2 color0 content-side_description_title details"><?= __($extras['details']); ?></h1>

                                      <?php foreach ($post['post']['fields'] as $field) {
                                            if(!empty($field->option_key)) {
                                                if($field->option_key == 'price' || $field->option_key == 'price_before') {
                                                  $val = $this->Number->currency($this->Get->get_field_by_post_id($id, $field->option_key), $info['currency']);
                                              } else { 
                                                  $val = $field->_joinData->value; 
                                              } ?>
                                      
                                            <?php if(!empty($val)) { ?>
                                              <div class="content-side_description_text fields">
                                                <b style='width:inherit !important;'><?= __($extras[$field->option_key]); ?>: </b> <font><?= $val; ?></font>
                                              </div>
                                            <?php } ?>

                                      <?php } } ?>





                                    </aside>


                                  </div>

                                </aside>

                                </a>

                          </article>
                        <?php } ?>







