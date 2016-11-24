          <table id="filters" class="button-group sort-by-button-group order-table">
              <tr>
                    <td><?= $this->Form->button(__($extras['ref']), ['label' => false, 'class' => 'input-sort is-checked', 'data-sort-value' => 'original-order']); ?></td>
                    <?php 
                        $titles = ['brand' => $extras['maker'],
                                   'year' => $extras['year_maker'],  
                                   'model' => $extras['model'],                     
                                   'tons' => $extras['capacity'], 
                                   'city' => $extras['location'], 
                                  ]; 

                      foreach ($titles as $key => $title) { ?>
                        <td>
                        <?= $this->Form->button(__($title), ['label' => false, 'class' => 'input-sort', 'data-sort-value' => $key]); ?>
                        </td>
                    <?php } ?>
              </tr>
          </table>
                  

              <!-- isotope -->
                <div class="grid-overflow">
                    <div class="grid">

<?php foreach ($posts as $key => $post)   {
        
        setlocale(LC_MONETARY, 'en_US');

        $id = $post['id'];
        $precio = $this->Get->get_field_by_post_id($post['id'], 'price');
        $price = $this->Number->currency($precio, $info['currency']);
        //$avalible = $this->Get->get_field_by_post_id($post['id'], 'avalible');
        $beforePrice = $this->Get->get_field_by_post_id($post['id'], 'price_before');
        $antes = $this->Number->currency($beforePrice, $info['currency']);
        $link = $this->Get->get_link($post['id'], 'Posts');
        $year = $this->Get->get_field_by_post_id($post['id'], 'year');
        $marca = $this->Get->get_field_by_post_id($post['id'], 'brand');
        $tons = $this->Get->get_field_by_post_id($post['id'], 'tons');
        $model = $this->Get->get_field_by_post_id($post['id'], 'model');
        $city = $this->Get->get_field_by_post_id($post['id'], 'city');
        $country = $this->Get->get_field_by_post_id($post['id'], 'country');
        $location = $this->Get->get_field_by_post_id($post['id'], 'state');
        $video = $this->Get->get_field_by_post_id($post['id'], 'video');

        //obtener el id de la categoria a la que corresponde
        $avalible = $this->Get->get_cat_avalible($id);
        $avalibleName = 'avalible_'.$avalible;

        if($tons >= $this->request->query['tons_since'] && $tons <= $this->request->query['tons_until']) {


                            if($avalible == 11) { $btnAvalible = 'rent'; $btnAvalibleAction = '#rent_crane'; } else {  $btnAvalible = 'sell'; $btnAvalibleAction = '#sell_crane'; } // boton comprar  o alquilar
                            if($authUser) { $btnAction = $this->Url->build(["controller" => "Posts", "action" => "offer",$post->id], true); $classAvalible = 'offer_iframe'; $iframe = 'iframe'; } else {  $btnAction = '#login'; $classAvalible = 'fancybox'; $iframe = ''; }
                            if($video && !empty($video)) { $classVideo = 'list-post_image_video'; } else { $classVideo = ''; } ?>


                          <article id="<?= $this->request->params['action']; ?>" class="element-item list-post border1 <?php //if(!empty()) { echo 'promotion'; } ?>" 
                                                  data-brand="<?= $marca; ?>" 
                                                  data-id="<?= $post['id']; ?>" 
                                                  data-year="<?= $year; ?>" 
                                                  data-tons="<?= $tons; ?>" 
                                                  data-model="<?= $model; ?>" 
                                                  data-city="<?= $city; ?>" 
                                                  data-created="<?= date_format($post['created'], 'Y-m-d')?>">

                           
                            <a class="list-post_enlace" href="<?= $link; ?>">
                              <aside class="list-post_image <?= $classVideo; ?>" style="background-image:url(<?= $this->Image->url($post['archive_id'], 'medium'); ?>);">
                                
                                <?php

                                 if($post['crane_status'] == 0) {   
                                         if(!empty($beforePrice)) { ?>
                                              <aside class="tag"><span><?= __($extras['promotion']); ?></span></aside>
                                <?php    } 

                                } else { ?>

                                              <aside class="tag <?= 'avalible_'.$post['crane_status']; ?>"><span><?= __($extras[$post['crane_status'].'_avalible']); ?></span></aside>

                                <?php } ?>
                                
                                <span class="list-post_name fondo2 color0"><?= __($post['name']); ?></span>
                              </aside>
                            </a>
                            
                            <aside class="list-post_text">
                              <div>
                                <h2 class="list-post_title"><?= $this->Html->link(__($post['name']), $link, ['class' => 'color3']); ?> | <?= __($extras['code']); ?>-<?= $post['id']; ?></h2> 
                                <?php  if(!empty($precio) && $avalible == 11) { ?><span class="list-post_prince"><?= $extras['price_month']; ?>: <?= $price; ?></span><?php } ?>
                              </div>

                              <?php $datos = ['maker' => $marca, 'year' => $year, 'model' => $model, 'tons' => $tons.' '.$extras['tons'], 'location' => $country." - ".$city]; 

                                foreach ($datos as $name => $value) { ?>

                                  <aside class="item_only-post_aside table-cell">
                                    <?= $this->Html->link($value, $link, ['class' => 'color3 colorh4']); ?>
                                  </aside>

                                <?php }

                            ?>

                              <aside class="list-post_text_description">
                                <font><?= __($extras['date_publish']); ?>: <?= date_format($post['created'], 'Y-m-d'); ?> </font>
                                <p><font><?= __($extras['year_maker']); ?>: <?= __($year); ?></font></p>
                                
                                <div>
                                  <strong><?= __($extras['speak_seller']); ?></strong>
                                  <div class='list-post_text_ofert'>
                                      <?= $this->Html->link(__($extras['more_information']), $link, ['class' => 'btn btn-link fondo1 fondoh3 color3 colorh0']);?> 
                                      <?php if($post['crane_status'] == 0) {  echo $this->Html->link(__($extras[$btnAvalible]), $btnAction, ['class' => $classAvalible.' need_premium btn btn-link fondo1 fondoh3 color3 colorh0', 'data-fancybox-type' => $iframe ]); } ?>

                                      <br>

                                      <?php if($authUser) {

                                                if($this->Get->get_favorite_by_post_id($post['id'], $userID) == 1) { // si favorito es 1, el post ya fue relacionado con el usuario 
                                                  
                                                $action = 'remove_favorite';
                                                $class = 'post-user_contact_list_item before-list_item favorite fondoremove fondoh3 color0 btn-category_border';

                                                } else { 

                                                $action = 'save_favorite';
                                                $class = 'fondoh1 post-user_contact_list_item before-list_item favorite color3 fondoh3 colorh1 btn-category_border';

                                                }

                                                echo $this->Form->postLink($extras[$action], ['controller' => 'Posts', 'action' => $action, $id], ['id' => 'favorite-item', 'title' => __($extras['save_favorite']), 'class' => $class]); 

                                            } else {

                                                echo $this->Html->link(__($extras['save_favorite']), '#login', ['id' => 'favorite-item', 'class' => 'fancybox post-user_contact_list_item before-list_item favorite color3 fondoh3 colorh1 btn-category_border']); 
                                            }
                                      ?>


                                  </div>

                                </div>
                                
                              </aside>

                              <aside class="list-post_data">
                                  <?php if(!empty($beforePrice) && $avalible == 11) { ?><font class="list-post_price_before"><?= $antes; ?></font><?php } ?>
                                  <span class="list-post_avalible"><?= __($extras[$avalibleName]); ?></span>
                                  <div class="list-post_data_map">
                                    <a href="/front/Posts/map/<?= $post->id; ?>" class="fancy_iframe" data-fancybox-type="iframe" title="<?= __($extras['location']); ?> <?= $post->name; ?>"><i class="fa fa-map-marker color1 colorh3"></i></a>
                                  </div>
                                  <div class="list-post_data_rent">
                                    <?php if(!empty($tons)) { ?><p><strong><?= __($extras['tons']); ?>: </strong> <font><?= $tons; ?></font></p><?php } ?>
                                    <?php if(!empty($city)) { ?><p><strong><?= __($extras['city']); ?>: </strong> <font><?= $city; ?></font></p><?php } ?>
                                  </div>
                              </aside>




                            </aside>

                          </article>


                        <?php } } ?>



        </div>

      </div>


<?= $this->Html->script('Front.front/isotope.pkgd.min'); ?>


<script type="text/javascript">

// external js: isotope.pkgd.js

$(document).ready( function() {
    // init Isotope

    var isoOptions = {
        itemSelector: '.element-item',
        layoutMode: 'fitRows',
        getSortData: {
          id: '[data-id] parseFloat',
          brand: '[data-brand]',
          year: '[data-year] parseFloat',
          tons: '[data-tons] parseFloat',
          model: '[data-model]',
          created: '[data-created]',
          city: '[data-city]',

          weight: function( itemElem ) {
            var weight = $( itemElem ).find('.weight').text();
            return parseFloat( weight.replace( /[\(\)]/g, '') );
          }
        }
    };

    var $grid = $('.grid').isotope(isoOptions);

    //elemento individual
    var div = $('.element-item');
    var sortElement = $('.input-sort');

    // bind sort button click
    $('.sort-by-button-group').on( 'click', 'button', function() {
      var sortValue = $(this).attr('data-sort-value');
      $grid.isotope({ sortBy: sortValue });
    });

    $('.list-description').on( 'click', 'a', function() {
      
      var sortValue = $(this).attr('data-sort-value');

      console.log(sortValue);


      //remover las clases nuevas esto para dejar la de miniaturas cuando se elimina la de crane_list
      div.removeClass('crane_list crane_thumbs crane_photos');
      div.attr('id', sortValue);
        div.addClass(sortValue); //agregamos la clase que clickeamos, crane_thumbs no hace nada, pero al dar click se elimina crane_list

        //funciones para cambiar el click como activo o no
        $('.list-description_item.table-cell').removeClass('fondo2'); //quitar todos los activos
        $('.list-description_item.table-cell a').removeClass('color1').addClass('color3');
        $(this).parent().toggleClass('active fondo2');
        $(this).addClass('color1').removeClass('color3');

        //$grid.isotope('destroy');
        //$grid.isotope({ sortBy: 'original-order' });
        div.css('position', 'static');

        sortElement.removeClass('is-checked');

        return false;



    });


    // change is-checked class on buttons
    $('.button-group').each( function( i, buttonGroup ) {

      var $buttonGroup = $( buttonGroup );
      $buttonGroup.on( 'click', 'button', function() {

          div.css('position', 'absolute');

        $buttonGroup.find('.is-checked').removeClass('is-checked');
        $( this ).addClass('is-checked');

      });
    });
  
});


  $( ".map_list" ).click(function() {
    $('#mapa').toggleClass( "completo" );
    return false;
  });

</script>