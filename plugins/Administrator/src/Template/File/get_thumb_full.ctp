    
    <?php //echo $this->Html->script('upload_files/selects'); // javascript funcion select imagenes ?>

    <?php 


    if(isset($archives) && !empty($archives)){ //obtenemos las imágenes desde componente GET y appcontroller variable $archives ?>
                    
                    <fieldset>
                                <ul class="checklist">
                              
                              <?php $a=0; foreach ($archives as $key => $archive) { 
                                
                                $img = $this->Image->url($archive->id, 'medium'); //obtener URL de la imagen por id con tamaño 
                                $extention = pathinfo($img, PATHINFO_EXTENSION); //obtenemos la extensión del archivo

                                if (!empty($archive->filename) &&  file_exists($img) ) { //validar si el fichero existe (se hace substr para quitar el / de la url (no reconoce el enlace con el "/") )

                                    if($this->Image->gallery_image_checked($id, $archive->id, $controller) == 'checked') { $checked = 'checked'; } else { $checked = NULL; } // validar si es imagen destacada. ?>
                              
                                <li class="tooltip <?= $extention; ?> <?php if($checked == 'checked') { echo "selected fondo3 fondoh2"; } else { echo "fondo5 fondoh2"; } ?>" title="<?= $archive->name; ?>">
                                      <label for="choice_<?php echo $archive->id; ?>" style="background-image:url(<?php echo $this->Url->build('/', true).$img; ?>);"></label>
                                      <a class="checkbox-select" href="#"></a>
                                      <a class="checkbox-deselect color3 colorh2" href="#"></a>
                                      <?= $this->Form->input('archives.'.$a.'.id', ['value' => $archive->id, 'id' => 'choice_'.$archive->id, 'label' => false, 
                                                         'hiddenField' => false, 'type' => 'checkbox', 'checked' => $checked, 'class' => 'check']); ?>
                                  </li>

                                <?php $a++; }  } ?>

                                </ul>
                        </fieldset>

    <?php } ?>


<script>
$(".checklist input:checked").parent().addClass("selected");
  /* handle the user selections */
  $(".checklist .checkbox-select").click(
    function(event) {
      event.preventDefault();
      $(this).parent().addClass("selected fondo3");
      $(this).parent().find(":checkbox").attr("checked","checked");
      

      //Actualización via AJAX de la galeria de imagenes
      $.post( 
          "<?php echo $this->Url->build('/', true);?>admin/file/gallery",
          { id: "<?php echo $id;?>", file: ''+ $(this).parent().find(":checkbox").val() +'' }, 
          function(data) {
             $('#stage').html(data);
          }
      );
    

      
    }
  );
  $(".checklist .checkbox-deselect").click(
    function(event) {
      event.preventDefault();
      $(this).parent().removeClass("selected fondo3");
      $(this).parent().find(":checkbox").removeAttr("checked");


      //Actualización via AJAX de la galeria de imagenes
      $.post( 
          "<?php echo $this->Url->build('/', true);?>admin/file/deselect",
          { id: "<?php echo $id;?>", file: ''+ $(this).parent().find(":checkbox").val() +'' }, 
          function(data) {
             $('#stage').html(data);
          }
      );


    }
  );
</script>
