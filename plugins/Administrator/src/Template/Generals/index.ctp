
<!-- cuerpo de edicion -->
    <section class="table content-table">     
     
			
		<!-- seccion de campos personalizados -->
          <section class="table-cell left-content section fondo5">     
                <table cellpadding="0" cellspacing="0">
                    <tr>
                          <td class="no-padding table-edit_body_fields"> 

      						<h2 class="fondo2 color5"><?= __($controllerText['main_fields']) ?></h2>
                            <!-- custom_field_editor clase adicional para los textarea campos personalizados -->
                            <table id="custom-visual_editor" class="table-visual-editor" cellpadding="0" cellspacing="0">

                                <?php foreach ($generals as $general) { //opciones generales dwe la web (variable llmada desde el controlador) ?>
                                    <tr>
                                      <td class="">
                                        <?= $this->Form->input('general.'.$general->option_key, ['label' => $extras[$general->option_key], 'type'=> 'text', 'value' => $general->option_value ]);  ?>
                                      </td>
                                    </tr>
                                <?php } ?>
                            </table>

                          </td>
                    </tr>
                </table>
          </section>
      	<!--fin seccion de campos personalizados -->

      	<!-- imagenes del index -->
            <section class="table-cell right-content">     
                  <table id="table-edit" class="table-edit_body" cellpadding="0" cellspacing="0">
                      <tr>
                            <td class="no-padding table-edit_body_fields border-none">  
                                
                                  	<h2 class="fondo2 color5"><?= __($extras['logo']) ?></h2>
			                        <table class="table-index table-logo" cellpadding="0" cellspacing="0">
			                            <tr>
							                    <td class="border-none no-padding td-image">
							                              <aside class="td-image_aside">
							                              <!-- imagen personalizada (se agrega como fondo en el div.d-image_aside_div ) -->
							                              <div class="td-image_aside_div">
							                                <div id="fileuploader" class="logo-uploader" style="<?= 'background-image:url('.$this->Url->build('/', true).$logo.');'; ?>" ></div>
							                              </div> 
							                              </aside>

							                              <div class="image-buttons">
							                                <?= $this->Html->link(__($imagesText['change_logo']), ['action' => '#featured_image'], ['class' => 'btn fondo2 color5 fondoh3 index-image']);
                                                    echo $this->Form->button(__($controllerText['submit']), ['name' => $extras['update'], 'id'=>'button', 'class' => 'btn fondo2 color5 fondoh3 index-edit',]); ?>
							                              </div>
							                    </td>
							            <tr>
			                        </table>

                                </div>

                            </td>
                      </tr>
                  </table>
            </section>
        <!-- imagenes del index -->



    </section>
<!-- fin cuerpo de edicion -->



<!-- cuerpo de edicion -->
    <section class="table content-table">     
     
      
    <!-- seccion de campos personalizados -->
          <section class="table-cell left-content section fondo5">     
                <table cellpadding="0" cellspacing="0">
                    <tr>
                          <td class="no-padding table-edit_body_fields"> 

                            <h2 class="fondo2 color5"><?= __($controllerText['custom_colors']) ?></h2>
                            <!-- custom_field_editor clase adicional para los textarea campos personalizados -->
                            <table id="custom-visual_editor" class="table-visual-editor" cellpadding="0" cellspacing="0">
                                  <tr>
                                      <td class="td-colors backend_colors">
                                        <?php $a = 1; foreach ($colores as $key => $color) { //opciones generales dwe la web (variable llmada desde el controlador) (USAR $a y no key por tema de clases IMPORTANTE) (key para que la llave si sea la misma)
                                              echo $this->Form->input('colors.'.$key, ['label' => $extras['color'.$a], 'type'=> 'text', 'value' => $color, 'class' => 'colores fondo'.$a]);
                                         $a++; } ?>

                                         <aside><br><br><?= $this->Form->button(__($extras['restart_colors']), ['name' => 'restart_colors', 'id'=>'button', 'class' => 'btn fondo2 color5 fondoh3 index-edit',]); ?></aside>

                                     </td>
                                  </tr>
                            </table>
      
                            <h2 class="fondo2 color5"><?= __($extras['gadgets']) ?></h2>
                            <!-- custom_field_editor clase adicional para los textarea campos personalizados -->
                            <table id="custom-visual_editor" class="table-visual-editor" cellpadding="0" cellspacing="0">

                             <?php foreach ($gadgets as $gadget) { //opciones generales dwe la web (variable llmada desde el controlador) ?>
                                    <tr>
                                      <td class="">
                                        <?= $this->Form->input('general.'.$gadget->option_key, ['label' => $extras[$gadget->option_key], 'type'=> 'select', 'options' => $gadgetsList, 'value' => $gadget->option_value ]);  ?>
                                      </td>
                                    </tr>
                                <?php } ?>
                            </table>


                            <h2 class="fondo2 color5"><?= __($controllerText['routes']) ?></h2>
                            <!-- custom_field_editor clase adicional para los textarea campos personalizados -->
                            <table id="custom-visual_editor" class="table-visual-editor" cellpadding="0" cellspacing="0">

                             <?php foreach ($routes as $route) { //opciones generales dwe la web (variable llmada desde el controlador) ?>
                                    <tr>
                                      <td class="">
                                        <?= $this->Form->input('general.'.$route->option_key, ['label' => $extras[$route->option_key], 'type'=> 'text', 'value' => $route->option_value ]);  ?>
                                      </td>
                                    </tr>
                                <?php } ?>
                            </table>


                          </td>
                    </tr>
                </table>
          </section>
        <!--fin seccion de campos personalizados -->

        <!-- imagenes del index -->
            <section class="table-cell right-content">     
                  <table id="table-edit" class="table-edit_body" cellpadding="0" cellspacing="0">
                      <tr>
                            <td class="no-padding table-edit_body_fields border-none">  
                                
                                <h2 class="fondo2 color5"><?= __($extras['favicon']) ?></h2>
                                <table class="table-index table-extra_image" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td class="border-none no-padding td-image">
                                                <aside class="td-image_aside">
                                                <!-- imagen personalizada (se agrega como fondo en el div.d-image_aside_div ) -->
                                                <div class="td-image_aside_div">
                                                  <div id="fileuploader" class="favicon-uploader" style="<?= 'background-image:url('.$favicon.');'; ?> background-size:auto;" ></div>
                                                </div> 
                                                </aside>

                                                <div class="image-buttons">
                                                  <?= $this->Html->link(__($imagesText['change_favicon']), ['action' => '#see_all_files'], ['class' => 'btn fondo2 color5 fondoh3 index-icono']); ?>
                                                </div>
                                        </td>
                                    <tr>
                                </table>

                                <h2 class="fondo2 color5"><?= __($extras['background']) ?></h2>
                                <table class="table-index table-extra_image" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td class="border-none no-padding td-image">
                                                <aside class="td-image_aside">
                                                <!-- imagen personalizada FONDO DEL FRONTEND (se agrega como fondo en el div.d-image_aside_div ) -->
                                                <div class="td-image_aside_div">
                                                  <div id="fileuploader" class="background-uploader" style="<?= 'background-image:url('.$this->Url->build('/', true).$fondo.');'; ?> background-size:cover;" ></div>
                                                </div> 
                                                </aside>

                                                <div class="image-buttons">
                                                  <?= $this->Html->link(__($imagesText['change_background']), ['action' => '#see_all_files'], ['class' => 'btn fondo2 color5 fondoh3 index-background_front']); ?>
                                                </div>
                                        </td>
                                    <tr>
                                </table>

                                </div>

                            </td>
                      </tr>
                  </table>
            </section>
        <!-- imagenes del index -->



    </section>
<!-- fin cuerpo de edicion -->


<!-- galeria de imagenes -->
        <?= $this->element('admin/select-logo_favicon_background'); ?>
<!--fin galeria de imagenes -->


<?php 
    echo $this->Html->css('color/colpick'); // menu principal del soft
    echo $this->Html->script('color/colpick'); // menu principal del soft

?>

<script type="text/javascript">
    
    <?php $a=1; foreach ($colores as $key => $color) { //opciones generales dwe la web (variable llmada desde el controlador) (USAR $a y no key por tema de clases IMPORTANTE)

    //clases personalizadas para cada cambio de color
    $elements = [1=> ['color' => '.top-bar li a::before, .table-index_user a, .table-index_email a:hover', 'fondo' => '.levelHolderClass, .redactor-box textarea#redactor'],
                 ['color' => '.table-index_user a:hover, .table-index_email a', 'fondo' => '#bar-publication .ui-progressbar-value, #bar-page .ui-progressbar-value, .redactor-toolbar li a:hover, .td-image_aside:before, .state-hover, .pagin-count li.active a, .pagin-count li a:hover '],
                 ['color' => '.multilevelpushmenu_wrapper .cursorPointer', 'fondo' => '.multilevelpushmenu_wrapper a:hover, .multilevelpushmenu_wrapper .multilevelpushmenu_inactive, .pagin-count a, .ajax-file-upload'],
                 ['color' => 'color4', 'fondo' => 'fondo4'],
                 ['color' => '.multilevelpushmenu_wrapper a, .multilevelpushmenu_wrapper h2, .multilevelpushmenu_wrapper .cursorPointer:hover, .table-index th a, .pagin-count a', 'fondo' => 'fondo5'],
                ]; ?>


    $('#colors-<?= $key; ?>').colpick({
    layout:'hex',
    submit:0,
    onChange:function(hsb,hex,rgb,el,bySetColor) {
      
      var background = $('.fondo<?= $a; ?>, .fondoh<?= $a; ?>:hover, <?= $elements[$a]["fondo"]; ?>');
      $(background).css( "background", "#"+hex );
      
      var color = $('.color<?= $a; ?>, .colorh<?= $a; ?>:hover, <?= $elements[$a]["color"]; ?>');
      $(color).css( "color", "#"+hex );
      
      if(!bySetColor) $(el).val(hex);
    }
  });

  <?php $a++; } ?>
    
</script>