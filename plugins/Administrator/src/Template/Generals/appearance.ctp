<?php foreach ($frontColors as $key => $color) { ?>
<style type="text/css">
    .fondo_front<?= $key; ?> { background-color:#<?= $color; ?>; }
</style>
<?php } ?>

<?= $this->Form->create('appearence', array( 'id'=>'upload', 'enctype' => 'multipart/form-data')); ?> 

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
                                      <td class="td-colors frontend_colors">
                                        <?php $a = 1; foreach ($frontColors as $key => $color) { //opciones generales dwe la web (variable llmada desde el controlador) (USAR $a y no key por tema de clases IMPORTANTE) (key para que la llave si sea la misma)
                                              echo $this->Form->input('colors.'.$key, ['label' => $controllerText['color'.$a], 'type'=> 'text', 'value' => $color, 'class' => 'colores fondo_front'.$key]);
                                         $a++; } ?>
                                     </td>
                                  </tr>
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
                                
                                    <h2 class="fondo2 color5"><?= __($controllerText['info_web']) ?></h2>
                                      <table class="general-data_appearance fondo5" cellpadding="0" cellspacing="0">
                                        <?php foreach ($generals as $general) { //opciones generales dwe la web (variable llmada desde el controlador) 
                                              if($general->option_key == 'name' || $general->option_key == 'email') { ?>
                                            <tr>
                                              <td><?= $this->Form->input('general.'.$general->option_key, ['label' => $extras[$general->option_key], 'type'=> 'text', 'value' => $general->option_value, 'disabled' => 'disabled']);  ?></td>
                                            </tr>
                                        <?php } } ?>
                                            <tr>
                                              <td class="td-btns-appearence">
                                              <?= $this->Form->button(__($controllerText['submit']), ['name' => $extras['update'], 'id'=>'button', 'class' => 'btn fondo2 color5 fondoh3 index-edit',]); 
                                                    echo $this->Form->button(__($extras['restart_colors']), ['name' => 'restart_colors', 'id'=>'button', 'class' => 'btn fondo2 color5 fondoh3 index-edit',]); ?></td>    
                                            </tr>
                                    </table>

                            </td>
                      </tr>
                  </table>
            </section>
        <!-- imagenes del index -->


    </section>
<!-- fin cuerpo de edicion -->


<?php
  

 $mainc = 1; foreach ($menus as $keyMenu => $menu) {  ?>

<!-- cuerpo de edicion -->
    <section class="table content-table">     
     
      
    <!-- seccion de campos personalizados -->
          <section class="table-cell left-content section fondo5" style="width:400px;">     
                <table cellpadding="0" cellspacing="0">
                    <tr>
                          <td class="no-padding table-edit_body_fields"> 

                            <h2 class="fondo2 color5"><?= __($extras[$keyMenu]) ?></h2>
                            <!-- custom_field_editor clase adicional para los textarea campos personalizados -->
                            <table id="custom-visual_editor" class="table-visual-editor" cellpadding="0" cellspacing="0">
                                    
                                    <?php if($keyMenu == 'frontend_main') { ?>
                                    <tr>
                                      <td class="">
                                        <?= $this->Form->input('front.frontend_main_home', ['label' => $controllerText['frontend_main_home'], 'placeholder' => $controllerText['main_home_placeholder'], 'type'=> 'text', 'value' => $this->Get->get_option_value('frontend_main_home', 'Frontend') ]);  ?>
                                      </td>
                                    </tr>
                                    <?php } ?>

                                    <tr>
                                      <td>
                                        
                                        <section class="ac-container create_menu cm_<?= $keyMenu; ?>">
                                          
                                            <?php $e =1; foreach ($contents as $name => $content) { // variable $contents llamada desde beforefilter de GeneralsController con los componentes GET ?>
                                                  <div class="desplegable">
                                                    <input id="ac-<?= $mainc; ?>-<?= $e; ?>" name="accordion-<?= $keyMenu; ?>" type="radio" <?php if($e==1) { echo "checked"; } ?> />
                                                    <label class="ac-principal_label" for="ac-<?= $mainc; ?>-<?= $e; ?>"><?= __($extras[$name]); ?></label>
                                                    <article class="ac-large">
                                                      <aside class="categories-checkbox fondo5">
                                                        <table id="table-edit" class="table-index" cellpadding="0" cellspacing="0">
                                                            <?php $a=0; foreach ($content as $key => $value) { 
                                                                  $nombre = $this->Get->get_title_by_type_and_id($key, $name); ?>
                                                                <tr>
                                                                  <td>
                                                                   <?= $this->Form->input($name.'.'.$a.'.id', ['type' => 'checkbox', 'value' => $key, 'label' => __d('administrator', $value), 'hiddenField' => false, 'data-type' => $name, 'data-name' => $nombre, 'id' => 'link-'.$key.'-'.$keyMenu ]); ?>
                                                                  </td>
                                                                </tr>
                                                            <?php $a++; } ?>
                                                          </table>
                                                      </aside>
                                                    </article>
                                                  </div>
                                              <?php $e++; } ?>

                                        </section>
                                        
                                        <div class="div-add_menu">
                                            <?= $this->Html->Link($controllerText['add_menu'], '', ['class' => 'btn fondo2 color5 fondoh3 index-edit addMenuButton addMenu'.$keyMenu]); ?>
                                        </div>


                                      </td>
                                    </tr>
                            </table>

                          </td>
                    </tr>
                </table>
          </section>
        <!--fin seccion de campos personalizados -->

         <!-- imagenes del index -->
            <section class="table-cell right-content" style="width:auto;">     
                  <table id="table-edit" class="table-edit_body" cellpadding="0" cellspacing="0">
                      <tr>
                            <td class="no-padding table-edit_body_fields border-none">  
                                
                                    <h2 class="fondo2 color5"><?= __($controllerText['main_order']) ?></h2>
                                          
                                          <?php  if(isset($menu) && !empty($menu) && is_array($menu)) { ?>
                                            <section class="cf nestable-lists fondo5">  
                                                <aside class="dd" id="nestable_<?= $keyMenu; ?>">
                                                    <ol class="dd-list principal-list">

                                                        <?php foreach($menu as $key => $menu) {
                                                              $title = $this->Get->get_title_by_type_and_id($menu['id'], $menu['type']);

                                                              if(isset($title) && !empty($title)) {  ?>

                                                                      <li class="dd-item" data-id="<?= $menu['id']; ?>" data-type="<?= $menu['type']; ?>">
                                                                          <div class="dd-handle"><?= $title; ?></div>
                                                                          <i class="fa fa-times-circle delete item-<?= $menu['id']; ?>"></i>

                                                                          <?php if(isset($menu['children'])) { ?>
                                                                          <ol class="dd-list">
                                                                              <?php foreach($menu['children'] as $subId => $sub) { ?>
                                                                              <li class="dd-item" data-id="<?= $sub['id']; ?>" data-type="<?= $sub['type']; ?>">
                                                                                  <div class="dd-handle"><?= $this->Get->get_title_by_type_and_id($sub['id'], $sub['type']); ?></div>
                                                                                  <i class="fa fa-times-circle delete item-<?= $sub['id']; ?>"></i>

                                                                                  <?php if(isset($sub['children'])) {?>
                                                                                  <ol class="dd-list">
                                                                                      <?php foreach($sub['children'] as $sub_subId => $sub_sub) { ?>
                                                                                      <li class="dd-item" data-id="<?= $sub_sub['id']; ?>" data-type="<?= $sub_sub['type']; ?>">
                                                                                          <div class="dd-handle"><?= $this->Get->get_title_by_type_and_id($sub_sub['id'], $sub_sub['type']); ?></div>
                                                                                          <i class="fa fa-times-circle delete item-<?= $sub_sub['id']; ?>"></i>
                                                                                      </li>
                                                                                      <?php } ?>
                                                                                  </ol>
                                                                                  <?php } ?>
                                                                              </li>
                                                                              <?php } ?>
                                                                          </ol>
                                                                          <?php } ?>
                                                                      </li>

                                                        <?php } } ?>

                                                    </ol>
                                                </aside>  

                                                <?= $this->Form->input('general.'.$keyMenu, ['id' => 'nestable-output_'.$keyMenu, 'class' => 'menu-web main_'.$keyMenu, 'label' => false, 'type' => 'hidden']); ?>

                                            </section>

                                            <?php } ?>

                            </td>
                      </tr>
                  </table>
            </section>
        <!-- imagenes del index -->


      

    </section>
<!-- fin cuerpo de edicion -->


<?php $mainc++; } ?>



<?= $this->Form->end(); ?>


<?= $this->Html->css('administrador/acordeon'); // acordeon de categorías

      echo $this->Html->css('color/colpick'); // colorPick CSS
      echo $this->Html->script('color/colpick'); // colorPick JS

      echo $this->Html->css('nestableMenu/nestableMenu'); //  nestable menu CSS
      
      echo $this->Html->script('nestableMenu/nestableMenu'); //  nestable menu CSS


?>



<!-- cambio de colores y nestableMenu -->
<script type="text/javascript">
//FUNCIOON PARA EL CAMBIO DE COLORES
    <?php foreach ($colores as $key => $color) { //opciones generales dwe la web (variable llmada desde el controlador) (USAR $a y no key por tema de clases IMPORTANTE) ?>
      $('.fondo_front<?= $key; ?>').colpick({
      layout:'hex',
      submit:0,
      onChange:function(hsb,hex,rgb,el,bySetColor) {
        var background = $('.fondo_front<?= $key; ?>');
        $(background).css( "background", "#"+hex );
              
        if(!bySetColor) $(el).val(hex);
      }
    });
  <?php } ?>


    <?php $mainc = 1; foreach ($menus as $keyMenu => $menu) { ?>
        //NESTABLE MENU
        var updateOutput = function(e)
        {
            var list   = e.length ? e : $(e.target),
                output = list.data('output');
            if (window.JSON) {
                output.val(window.JSON.stringify(list.nestable('serialize')));//, null, 2));
            } else {
                output.val('JSON browser support required for this demo.');
            }
        };

        // activate Nestable for list 1
        $('#nestable_<?= $keyMenu; ?>').nestable({
            group: 1
        })
        .on('change', updateOutput);

        // output initial serialised data
        updateOutput($('#nestable_<?= $keyMenu; ?>').data('output', $('#nestable-output_<?= $keyMenu; ?>')));

        // eliminar los elementos de cada menú
        $('#nestable_<?= $keyMenu; ?> .dd-list').on('click', '.delete', function(e) {
          e.preventDefault();
          $(this).parent(".dd-item").remove();
          console.log( updateOutput($('#nestable_<?= $keyMenu; ?>').data('output', $('#nestable-output_<?= $keyMenu; ?>'))) ); //actualiza en tiempo real la salida de li´
        });

                  
                  // FUNCION PARA NESTABLEMENU
                    function object(elId, elType, elNombre) { this.id = elId; this.type = elType;  this.name = elNombre; };
                        
                        $(".addMenu<?= $keyMenu; ?>").click(function(event){
                            event.preventDefault();
                            var searchIDs = $(".cm_<?= $keyMenu; ?> input:checkbox:checked").map(function(){
                            
                            var id = $(this).val();
                            var tipo = $(this).data('type');
                            var nombre = $(this).data('name');
                            
                            var checked = new object(id, tipo);
                            
                            //agregar elementos al menu administrable nestableMenu.
                            $('#nestable_<?= $keyMenu; ?> .principal-list').append("<li class='dd-item' data-id='" + id + "' data-type='"+ tipo +"'><div class='dd-handle'>" + nombre + "</div><i class='fa fa-times-circle delete item-"+ id +"'></i></li>");
                            
                            //eliminar elementos de la lista de menu create-menu.
                            $(this).parents( ".create_li" ).detach();
                              
                            return JSON.stringify(checked);


                        }).get(); // <----

                      $('input[type="checkbox"]').prop('checked', false);

                      var menuDefault = $('#nestable-output_<?= $keyMenu; ?>').val();
                      var menuArray = $.parseJSON(menuDefault); // convertir del menu ya creado el string a objet para hacer el array combine (.contact()).
                      var checks = $.parseJSON(searchIDs); // convertir de los checboxes a objet para hacer el array combine (.contact()).
                      
                      var combine = menuArray.concat(checks); // se hace el .contact para combinar los arrays o los objets
                      var fianlito = JSON.stringify(combine); // se pasa el array como json (stringify)

                      $('#nestable-output_<?= $keyMenu; ?>').val(fianlito); // se da el nuevo valor al input que actualizará finalmente el menu.

                      
                    });

    <?php $mainc++; } ?>


</script>
<!--fin cambio de colores y nestableMenu -->
