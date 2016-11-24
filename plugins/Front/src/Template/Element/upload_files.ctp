<?php /* dentro de una tabla 
        <table class="table-index" cellpadding="0" cellspacing="0"> */ ?>

                              <aside class="td-image_aside">
                                  <!-- imagen personalizada (se agrega como fondo en el div.d-image_aside_div ) -->
                                  <div class="td-image_aside_div">
                                    <div id="fileuploader" style="<?php if(isset($user) && isset($user->archive_id)) { echo 'background-image:url(' .$this->Image->url($user->archive_id, 'full'); } ?>)" ></div>
                                  </div> 
                              </aside>


<?php /* </table> */ ?>
