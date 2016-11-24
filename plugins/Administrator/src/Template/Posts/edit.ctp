
<?php 

//echo pr($_SERVER);

/*
echo $this->element('admin/icons'); // clases para llamar los iconos como select
$fontAwesomeURL = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$this->Url->build('/', true).'administrator/css/fuentes/font-awesome.css';

use BCA\FontAwesomeIterator\Iterator as FontAwesomeIterator; $iconsFont = new FontAwesomeIterator($fontAwesomeURL); 
*/

echo $this->Form->create($post, array( 'id'=>'upload', 'enctype' => 'multipart/form-data')); ?>

<!-- cabecera de edicion -->
    <section class="content-table">     
      <section class="up-section section fondo5">

            <div id="table-edit" class="table table-edit table-edit_category">
                    
                    <div class="table-cell">
                      <?= $this->Form->input('name', ['label'=> false, 'placeholder'=> $controllerText['title_placeholder'], 'class' => 'edit-title', ]); ?>
                      <p class="edit-info">
                        <?php if($post->slug) { echo __($extras['custom_link']); ?>: <?= $this->Html->link($post->slug, $this->Get->get_link($post->id, $this->request->params['controller']), ['class' => 'color2 colorh3', 'target' => '_blanck']); ?> | <?php } ?>
                        <?= __($extras['created']); ?>: <span class="color2"><?= $creado; ?></span> |
                        <?= __($extras['modified']); ?>: <span class="color2"><?= $modificado; ?></span>
                      </p>

                    </div>

                    <div class="table-cell btn-section">
                      <?= $this->Form->button(__($controllerText['submit']), ['name' => $extras['update'], 'id'=>'button', 'class' => 'btn fondo2 color5 fondoh3 index-'.$this->request->params['action']]);
                            
                            if($this->request->params['controller'] == 'Posts' && $this->request->params['action'] == 'edit' && $post->duplicated == 0) {
                                echo $this->Form->button($extras['duplicated_crane'], ['name' => 'duplicated', 'value' => $post->id, 'id'=>'button', 'class' => 'btn fondo2 color5 fondoh3 index-'.$this->request->params['action'], 
                                                        'formaction' =>  $this->Url->build(["controller" => $this->request->params['controller'], "action" => 'duplicated']) ]); 
                            }

                            if($this->request->params['action'] != 'add') { // si estamos en la vista add no se muestra boton papelera
                                        echo $this->Form->button($extras['move_trash'], ['id'=>'button', 'class' => 'btn fondo1 color5 fondoh3 index-index',  
                                                                 'formaction' => $this->Url->build(["controller" => $this->request->params['controller'], "action" => 'clear/'.$post->id ]) ]); 
                                        // si estamos en la vista add no se muestra boton papelera
                            }
                      ?>

                    </div>                   
            </div>

      </section>
    </section>
<!--fin cabecera de edicion -->


<!-- cuerpo de edicion -->
    <section class="content-table">     
      <section class="section fondo5">
          
          <table id="table-edit" class="table-edit_body" cellpadding="0" cellspacing="0">
              <tr>
                  <!-- seccion de imagen de la edicion -->
                    <td class="table-edit_body_image">
                            
                        <table class="table-index" cellpadding="0" cellspacing="0">

                                  <?=   $this->element('upload_files/upload_files'); // archivo incluye tr y td de la tabla ?> 

                                  <tr>
                                    <td class="td-select">

                                    <table cellpadding="0" cellspacing="0">
                                            <?php if($this->request->params['controller'] == 'Pages') { ?>
                                            <tr>
                                              <td class="locations"><?= $this->Form->input('location', ['type' => 'select', 'options' => $locations, 'label' => __($extras['location']), 'empty' => $extras['select_default']] ); ?></td>
                                            </tr>
                                            <?php } ?>

                                            <?php foreach ($datos as $name => $options) { ?>
                                            <tr>
                                              <td class="<?= $name; ?>"><?= $this->Form->input($name, $options); ?></td>
                                            </tr>
                                            <?php } ?>

                                            <?php /*
                                            <tr>
                                              <td class="icons">
                                                <div class="input select">
                                                  <label for="icon"><?= $extras['icon']; ?></label>
                                                  <select name="icon" class="fa-select select input">
                                                    <option value=""><?= $extras['select_default'];?></option>
                                                    <?php foreach ($iconsFont as $icon) {
                                                                if($post->icon == $icon->unicode) { $selected = 'selected="selected"'; } else { $selected = NULL; }
                                                                
                                                                echo '<option '.$selected.' value="'.$icon->unicode.'"> &#x'.substr($icon->unicode, 1).'; ' .$icon->name.'</option>';
                                                          } ?>
                                                  </select>                               
                                                </div>
                                              </td>
                                            </tr>
                                            */ ?>
                                    </table>

                                </td>
                              </tr>

                        </table>
                    </td>
                  <!-- fin seccion de imagen de la edicion -->

                  <!-- seccion de campos de texto principales de la edicion -->
                    <td class="no-padding table-edit_body_fields">
                          
                          <h2 class="fondo2 color5"><?= __($extras['general_description']) ?></h2>

                          <?php $datos = ['slug' =>        ['label' => __($extras['custom_link']), 'placeholder' => __($extras['custom_link_placeholder']) ], 
                                          'excerpt' =>     ['label' => __($controllerText['excerpt']), 'type' => 'text', 'placeholder' => __($controllerText['excerpt_placeholder']) ], 
                                          'description' => ['label' => false, 'type'=>'textarea', 'id' => 'redactor', 'placeholder' => __($extras['description'])], // id es necesario para llamar el editor visual.
                                   ]; ?>

                          <table class="table-index table-visual-editor" cellpadding="0" cellspacing="0">
                          <?php foreach ($datos as $name => $options) { ?>
                          <tr>
                            <td class="<?= $name; ?>"><?= $this->Form->input($name, $options); ?></td>
                          </tr>
                          <?php } ?>
                        </table>

                    </td>
                  <!-- fin seccion de campos de texto de la edicion -->

              </tr>
          </table>

      </section>
    </section>
<!-- fin cuerpo de edicion -->

<!-- seccion inferior -->
<section class="table content-table">
        <!-- seccion de campos personalizados -->
          <?= $this->element('admin/edit-categories_fields'); // elemento de camops personalizados llamados por tipo y las categorias si estoy en el controlador Posts ?>
        <!--fin seccion de campos personalizados -->
</section>
<!--fin seccion inferior -->


<!-- galeria de imagenes -->
        <?= $this->element('admin/edit-gallery'); ?>
<!--fin galeria de imagenes -->


<script type="text/javascript">

  var val = $('#fields-3-joindata-value').val();

  $('#fields-3-joindata-value').change(function() {
    var avalible = $(this).val();
      //alert(avalible);     

      //NO CAMBIAR ESTOS TEXTOS DE ALQUILER Y RENT
      if(avalible == 'rent') {
          $('#categories-11-id').prop('checked', false);
          $('#categories-10-id').prop('checked', true);
      
      } else {
          $('#categories-10-id').prop('checked', false);
          $('#categories-11-id').prop('checked', true);

      }
  

  });

  <?php 
  
  /*todas estas variables llamadas desde el app controller si el usuario es de role_id 2 y tipo es diferente a premium no puede agregar sino gruas en alquiler */

  if($user_Role != 1) { //eliminar los campos de venta de gruas del editor para estos usuarios que no son premium ?>

        $('#categories-11-id').parent().parent().hide();
        $('#fields-3-joindata-value option[value="<?= $extras["sell"]; ?>"]').remove();

  <?php } ?>


</script>


<?= $this->Form->end(); ?>