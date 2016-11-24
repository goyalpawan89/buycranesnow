

    <?php  if(isset($archives) && !empty($archives)){ //obtenemos las imágenes desde componente GET y appcontroller variable $archives ?>
                
                <fieldset>
                            <ul class="thumblist select-thumbnail">
                          
                          <?php foreach ($archives as $archive) { 
                                
                                $img = $this->Image->url($archive->id, 'medium'); //obtener URL de la imagen por id con tamaño 
                                $extention = pathinfo($img, PATHINFO_EXTENSION);
                          
                                  if (!empty($archive->filename) && file_exists($img) ) { //validar si el fichero existe (se hace substr para quitar el / de la url (no reconoce el enlace con el "/") )

                                    if(isset($thumbnailId) && $archive->id == $thumbnailId) { $checked = 'checked'; } else { $checked = NULL; } // validar si es imagen destacada. ?>
                          
                                <li class="tooltip <?= $extention; ?> <?php if($checked == 'checked') { echo "selected fondo3 fondoh2"; } else { echo "fondo5 fondoh2"; } ?>" title="<?= $archive->name; ?>">
                                      <label for="choice_<?php echo $archive->id; ?>" style="background-image:url(<?php echo $this->Url->build('/', true).$img; ?>);"></label>
                                      <a class="checkbox-select" href="#" data-image="<?php echo $this->Url->build('/', true).$img; ?>"></a>
                                      <a class="checkbox-deselect color3 colorh2" href="#"></a>
                                      <?= $this->Form->input('archive_id', ['value' => $archive->id, 'id' => 'choice_'.$archive->id, 'label' => false, 'hiddenField' => false, 
                                                            'type' => 'checkbox', 'checked' => $checked, 'class' => 'check']); ?>
                                  </li>

                          <?php }  } ?>

                            </ul>
                    </fieldset>

      <?php } ?>  


<script>

$(".select-thumbnail .checkbox-select").click(
    function(event) {
      event.preventDefault();
      $(this).parent().addClass("selected fondo3");
      $(this).parent().find(":checkbox").attr("checked","checked");
      $('.thumblist li').not($(this).parent()).removeClass("selected fondo3");
      $('.thumblist input').not($(this).parent().find(":checkbox")).removeAttr("checked");
      var fondo = $(this).attr("data-image");
      $('#fileuploader').css('backgroundImage','url(' + fondo + ')'); // cambia el fondo de la imagen destacada
      
      <?php 
       //Validamos si es un EDIT
       if($accion!='add'){?>
      $.post( 
          "<?php echo $this->Url->build('/', true);?>admin/file/thumbnail",
          { id: "<?php echo $id;?>", tipo: "<?php echo $tipo;?>", file: ''+ $(this).parent().find(":checkbox").val() +'' }, 
          function(data) {
             $('#stage').html(data);
          }
      );
      <?php } ?>


      //Cerrar Automaticamente al momento de seleccionar la imagen destacada.
      $("#menu, .linea").toggleClass('hidden');
        $("#pushobj").toggleClass('static');
      $('#featured_image, #gallery_images').fadeToggle('fast');

      //Cerrar popup de Favicon
    }
  );


</script>