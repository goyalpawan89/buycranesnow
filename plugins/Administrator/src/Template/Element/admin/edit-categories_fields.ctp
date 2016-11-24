
<?php 

$fields = $this->Fields->fields_by_type($type); //llamamos los campos personalizados por type (variable type llamada desde el controlador).
      if($fields && !empty($fields)) { ?>

      <!-- seccion de campos personalizados -->
          <section class="table-cell left-content section fondo5">     
                <table cellpadding="0" cellspacing="0">
                    <tr>
                          <td class="no-padding table-edit_body_fields"> 

      						              <h2 class="fondo2 color5"><?php echo __($extras['custom_fields']) ?></h2>

                                <!-- custom_field_editor clase adicional para los textarea campos personalizados -->
                                <table id="custom-visual_editor" class="table-visual-editor" cellpadding="0" cellspacing="0">

                                  <?php foreach ($fields as $a => $options) { $opciones = json_decode($options['option_value'], TRUE); ?>
                                    <tr>
                                      <td class="<?php echo 'custom_'.$options['option_key']; ?>">
                                        
                                        <?php echo $this->Form->input('fields.'.$a.'.id',  array('type' => 'hidden', 'value' => $options['id']));

                                              if($opciones['input'] == 'select') { 
                                                  
                                                $selectOptions = explode(',', $opciones['options']);

                                                  if($options['option_key'] == 'avalible') {

                                                    $opts = ['rent' => __($extras['rent']), 'sell' => __($extras['sell'])];
                                                    $req = true;
                                                  
                                                  } elseif($options['option_key'] == 'country')  {

                                                    $opts = ""; // para traducir unicamente los nombres no los values
                                                    $req = false;

                                                  } else {

                                                    $opts = array_combine($selectOptions, $selectOptions);
                                                    $req = false;                                                    
                                                  }

                                                  if($options['option_key'] == 'country' || $options['option_key'] == 'city' || $options['option_key'] == 'state')  {

                                                      $default = $this->Get->get_field_by_post_id($id, $options['option_key']);

                                                    } else {

                                                      $default = $extras['select_default'];

                                                  }


                                                  echo $this->Form->input('fields.'.$a.'._joinData.value', ['label' => $options['option_label'], 'type'=> $opciones['input'], 'placeholder' => $opciones['placeholder'], 'options' => $opts, 'required' => $req, 'empty' => [$default => $default], 'class' => $options['option_key'] ]);

                                              } elseif($opciones['input'] == 'textarea') { 

                                                  echo $this->Form->input('fields.'.$a.'._joinData.value', ['label' => false, 'type'=> $opciones['input'], 'placeholder' => $options['option_label'].": ".$opciones['placeholder'] ]); 

                                              } else {

                                                  echo $this->Form->input('fields.'.$a.'._joinData.value', ['label' => $options['option_label'], 'type'=> $opciones['input'], 'placeholder' => $opciones['placeholder'] ]); 
                                              
                                              } ?>

                                      </td>
                                    </tr>
                                  <?php } ?>

                                </table>


                          </td>
                    </tr>
                </table>
          </section>
      <!--fin seccion de campos personalizados -->

<?php } ?>

<?php  if($this->request->params['controller'] == 'Posts' && $categories && !empty($categories)) { ?>
<!-- categorias -->
            <section class="table-cell right-content">     
                  <table id="table-edit" class="table-edit_body" cellpadding="0" cellspacing="0">
                      <tr>
                            <td class="no-padding table-edit_body_fields border-none">  
                                
                                  <h2 class="fondo2 color5"><?php echo __($extras['categories']) ?></h2>
                                  <div class="categories-checkbox fondo5">

                                    <table id="table-edit" class="table-index" cellpadding="0" cellspacing="0">

                                    <?php $a = 0; foreach ($categories as $key => $cat) { 
                                          $checked = $this->Get->get_category_checked($key, $id);
                                          if($checked == 'checked') { $check = true; } else { $check = false; } ?>

                                        <tr>
                                          <td>
                                           <?php echo $this->Form->input('categories.'.$a.'.id', ['type' => 'checkbox', 'value' => $key, 'label' => __($cat), 'hiddenField' => false, 'checked' => $check ]); ?>
                                          </td>
                                        </tr>
                                    <?php $a++; } ?>

                                    </table>
                                </div>

                            </td>
                      </tr>
                  </table>
            </section>
        <!-- fin categorias -->
<?php } ?>


<script type="text/javascript">
      //autocompletar fechas
     $(document).ready(function() {

                             // fechas con Jquery
                            $('#fields-25-joindata-value').each(function(i) {
                            }).datepicker();                 

                            $('#fields-26-joindata-value').each(function(i) {
                                //this.class = 'datepicker' + i;
                            }).datepicker();                        
  });
</script>