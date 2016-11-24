<?php echo $this->Html->css('tabs/tabs'); // acordeon de categorías 
      echo $this->Html->css('administrador/acordeon'); // acordeon de categorías ?>


<?php echo $this->Form->create('custom_fields', array( 'id'=>'upload', 'enctype' => 'multipart/form-data')); ?> 

<!-- cuerpo de edicion -->
    <section class="table content-table">     
     
      
    <!-- seccion de campos personalizados -->
          <section class="table-cell left-content section fondo5">     
                <table cellpadding="0" cellspacing="0">
                    <tr>
                          <td class="no-padding table-edit_body_fields"> 

                            <h2 class="fondo2 color5"><?php echo __($controllerText['new_custom_field']) ?></h2>
                            <!-- custom_field_editor clase adicional para los textarea campos personalizados -->
                            <table id="custom-visual_editor" class="table-visual-editor" cellpadding="0" cellspacing="0">
                                  <tr>
                                      <td class="td-tabs">
                                          

                                          <div id="example-one">

                                                  <ul class="nav">
                                                      <?php $a = 1; foreach ($customFields as $type => $name) { // llamada de la variable customFields desde GeneralsController ?>
                                                        <li class="nav-<?php echo $a; ?>"><a href="#tab-<?php echo $a; ?>"  class="fondo3 fondoh2 color5 <?php if($a==1) { echo "current"; } ?>" ><?php echo __($extras[$name]); ?></a></li>
                                                      <?php $a++; } ?>
                                                  </ul>

                                                  <div class="list-wrap">
                                                    
                                                    <?php $a = 1; foreach ($customFields as $type => $name) { // llamada de la variable customFields desde GeneralsController ?>
                                                    
                                                      <ul id="tab-<?php echo $a; ?>" <?php if($a!=1) { ?> class="hide" <?php } ?> >
                                                          
                                                            <div class="content-tabs">
                                                              <h3><?php echo __($extras[$name]); ?>: <?php echo __($controllerText['new_custom_field']); ?></h3>

                                                              <table id="custom-visual_editor" class="table-visual-editor" cellpadding="0" cellspacing="0">
                                                    
                                                                <?php $campos = ['custom.'.$type.'.option_key' =>   ['type' => 'text', 'placeholder' => 'Nombre del campo sin espacios', 'label' => $controllerText["option_key"], 'options' => false], 
                                                                                 'custom.'.$type.'.option_label' => ['type' => 'text', 'placeholder' => 'Label del campo', 'label' => $controllerText["option_label"] ], 
                                                                                 'custom.'.$type.'.input' =>        ['type' => 'select', 'placeholder' => '', 'label' => $controllerText["input"],  'options' => $inputTypes ], 
                                                                                 'custom.'.$type.'.placeholder' =>  ['type' => 'text', 'placeholder' => 'placeholder del campo personalizado', 'label' => 'Placeholder', 'options' => false],
                                                                                 'custom.'.$type.'.options' =>      ['type' => 'text', 'placeholder' => 'Opciones separadas por comas Ej: opcion1, opcion2, opcion3', 'label' => $controllerText["options"], 'options' => false], 
                                                                                 //'custom.'.$type.'.location' =>     ['type' => 'select', 'label' => $extras["location"],  'options' => $location, 'empty' => $extras["select_default"] ], 
                                                                                 $controllerText["create"] =>       ['type' => 'submit', 'class'=> 'btn fondo2 color5 fondoh3 index-edit'], 
                                                                                ];

                                                                    foreach($campos as $llave => $campo) { ?>
                                                                        <tr>
                                                                          <td class="">
                                                                            <?php echo $this->Form->input($llave, $campo); ?>
                                                                          </td>
                                                                        </tr>
                                                                    <?php } ?>
                                                              </table>

                                                              <h3><?php echo __($controllerText['edit_custom_fields']); ?></h3>

                                                              <section id="edit-fields" class="ac-container create_menu">
                                          
                                                              <?php $e =1; foreach ($this->Get->get_fields_by_type($type) as $field) { // variable $contents llamada desde beforefilter de GeneralsController con los componentes GET
                                                                           $id = $field['id'];
                                                                           $key = $field['option_key'];
                                                                           $label = $field['option_label'];
                                                                           $value = json_decode($field['option_value']); // decodificamos el json                                                                          
                                                                           $input = array_merge([$value->input => $value->input], $inputTypes); // creamos el nuevo array con las opciones por defecto.
                                                                           $options = $value->options; // creamos el nuevo array con las opciones por defecto.
                                                                           $placeholder = $value->placeholder; ?>

                                                                    <div class="desplegable">
                                                                      <input id="ac-<?php echo $type.$e; ?>" name="accordion-<?php echo $type; ?>" type="radio" <?php if($e==1) { echo "checked"; } ?> />
                                                                      <label class="ac-principal_label" for="ac-<?php echo $type.$e; ?>"><?php echo $field['option_label']; ?></label>
                                                                      <article class="ac-large">
                                                                        <aside class="categories-checkbox fondo5">
                                                                            
                                                                            <table id="custom-visual_editor" class="table-visual-editor" cellpadding="0" cellspacing="0">
                                                    
                                                                            <?php $campos = ['fields.'.$id.'.option_key' =>   ['type' => 'text', 'disabled' => 'disabled', 'label' => $controllerText["option_key"], 'value' => $key], 
                                                                                             'fields.'.$id.'.option_label' => ['type' => 'text', 'placeholder' => 'Label del campo', 'label' => $controllerText["option_label"], 'value' => $label ], 
                                                                                             'fields.'.$id.'.input' =>        ['type' => 'select', 'placeholder' => '', 'label' => $controllerText["input"],  'options' => $input],
                                                                                             'fields.'.$id.'.placeholder' =>  ['type' => 'text', 'placeholder' => 'placeholder del campo personalizado', 'label' => 'Placeholder', 'value' => $placeholder],
                                                                                             'fields.'.$id.'.options' =>      ['type' => 'text', 'placeholder' => 'Opciones separadas por comas Ej: opcion1, opcion2, opcion3', 'label' => $controllerText["options"], 'value' => $options], 
                                                                                             //'fields.'.$type.'.location' =>   ['type' => 'select', 'label' => $extras["location"],  'options' => $location ], 
                                                                                            ];

                                                                                foreach($campos as $llave => $campo) { ?>
                                                                                    <tr>
                                                                                      <td class="">
                                                                                        <?php echo $this->Form->input($llave, $campo); ?>
                                                                                      </td>
                                                                                    </tr>
                                                                                <?php } ?>
                                                                          </table>


                                                                        </aside>
                                                                      </article>
                                                                    </div>
                                                                <?php $e++; } ?>

                                                          </section>



                                                            </div>

                                                      </ul>

                                                    <?php $a++; } ?>

                                                    

                                                   </div> <!-- END List Wrap -->

                                                   <aside class="btn-tabs_update"><?php echo $this->Form->input($controllerText['update_fields'], ['type' => 'submit', 'class'=> 'btn fondo2 color5 fondoh3 index-edit']); ?></aside>

                                          </div> <!-- END Organic Tabs (Example One) -->



                                     </td>
                                  </tr>
                            </table>

                          </td>
                    </tr>
                </table>
          </section>
        <!--fin seccion de campos personalizados -->

    </section>
<!-- fin cuerpo de edicion -->


<?php echo $this->Form->end(); ?>


<?php echo $this->Html->script('tabs/organictabs.jquery'); // acordeon de categorías ?>

<script type="text/javascript">
   $(function() {
            $("#example-one").organicTabs();
    });
</script>