<?php /* dentro de una tabla 
        <table class="table-index" cellpadding="0" cellspacing="0"> */ ?>
        
              <tr>
                    <td class="td-image">
                              <aside class="td-image_aside">
                              <!-- imagen personalizada (se agrega como fondo en el div.d-image_aside_div ) -->
                              <div class="td-image_aside_div">
                                <div id="fileuploader" <?php if(isset($thumbUrl)) { ?>style="background-image:url(<?= $thumbUrl; ?>)"<?php } ?> ></div>
                              </div> 
                              </aside>

                              <div class="image-buttons"> 
                                <?=   $this->Html->link(__($imagesText['featured_picture']), ['action' => '#featured_picture'], ['class' => 'btn fondo2 color5 fondoh3 index-image']);

                                      //si no estamos en categorias puede mostrar el boton (categorias no tiene archivos de galeria solo imagne destacada)
                                      if($this->request->params['controller'] != 'Categories') {
                                         echo $this->Html->link(__($imagesText['see_all_files']),    ['action' => '#see_all_files'],    ['class' => 'color1 colorh2 index-gallery']); 
                                      } ?>
                              </div>
                    </td>
              </tr>

                <tr>
                  <td><div id="eventsmessage"></div></td>
                </tr>

<?php /* </table> */ ?>
