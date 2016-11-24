<?= $this->Form->create($post, array( 'id'=>'upload', 'enctype' => 'multipart/form-data'));
    $fulURL = $this->Image->url($post->id, 'medium'); ?>

<!-- cabecera de edicion -->
    <section class="content-table">     
      <section class="up-section section fondo5">

            <div id="table-edit" class="table table-edit table-edit_category">
                    
                    <div class="table-cell">
                      <?php echo $this->Form->input('name', ['label'=> false, 'placeholder'=> $controllerText['title_placeholder'], 'class' => 'edit-title', ]); ?>
                      <p class="edit-info">
                        <?php if($post->slug) { echo __($extras['custom_link']); ?>: <?php echo $this->Html->link($post->slug, ['action' => ''], ['class' => 'color2 colorh3', 'target' => '_blanck']); ?> | <?php } ?>
                        <?php echo __($extras['created']); ?>: <span class="color2"><?php echo $creado; ?></span> |
                        <?php echo __($extras['modified']); ?>: <span class="color2"><?php echo $modificado; ?></span>
                      </p>

                    </div>

                    <div class="table-cell btn-section">
                      <?php echo $this->Form->button(__($controllerText['submit']), ['name' => $extras['update'], 'id'=>'button', 'class' => 'btn fondo2 color5 fondoh3 index-'.$this->request->params['action'],]);
                            if($this->request->params['action'] != 'add') { // si estamos en la vista add no se muestra boton papelera
                                        echo $this->Form->button($extras['delete'], ['id'=>'button', 'class' => 'btn fondo1 color5 fondoh3 index-index',  
                                                                                         'formaction' => $this->Url->build(["controller" => $this->request->params['controller'], "action" => 'delete/'.$post->id ]) ]); 
                                        // si estamos en la vista add no se muestra boton papelera
                            } ?>
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

                            <tr>
                                    <td class="td-image">
                                              <aside class="td-image_aside">
                                              <!-- imagen personalizada (se agrega como fondo en el div.d-image_aside_div ) -->
                                              <div class="td-image_aside_div">
                                                  <div id="file-image" style="<?php if($fulURL) { echo 'background-image:url('.$fulURL.');'; } ?>" ></div>
                                              </div> 
                                              </aside>                                              
                                    </td>
                            <tr>
                            <tr>
                                    <td class="td-select">
                                    <?php $datos = ['mimetype' => ['type' => 'text', 'disabled' => 'disabled', 'label' => __($extras['mimetype']), ],
                                                    'user' =>  ['type' => 'text', 'disabled' => 'disabled', 'label' => __($extras['author']), 'value' => $post->user->name." ".$post->user->last_name ],
                                                    'filesize' => ['type' => 'text', 'disabled' => 'disabled', 'label' => __($extras['filesize']), ],
                                                    ]; ?>

                                    <table cellpadding="0" cellspacing="0">
                                            <?php foreach ($datos as $name => $options) { ?>
                                            <tr>
                                              <td class="<?php echo $name; ?>"><?php echo $this->Form->input($name, $options); ?></td>
                                            </tr>
                                            <?php } ?>
                                    </table>

                                </td>
                              </tr>

                        </table>
                    </td>
                  <!-- fin seccion de imagen de la edicion -->

                  <!-- seccion de campos de texto principales de la edicion -->
                    <td class="no-padding table-edit_body_fields">
                          
                          <h2 class="fondo2 color5"><?php echo __($extras['general_description']) ?></h2>

                          <?php $datos = [//'slug' =>        ['label' => __($extras['custom_link']), 'placeholder' => __($extras['custom_link_placeholder']) ], 
                                          'url' => ['label' => __($extras['url']), 'type' => 'text', 'disabled' => 'disabled', 'value' => $fulURL ], 
                                          'description' => ['label' => false, 'type'=>'textarea', 'id' => 'redactor', 'placeholder' => __($extras['description'])], // id es necesario para llamar el editor visual.
                                   ]; ?>

                          <table class="table-index table-visual-editor" cellpadding="0" cellspacing="0">
                          <?php foreach ($datos as $name => $options) { ?>
                          <tr>
                            <td class="<?php echo $name; ?>"><?php echo $this->Form->input($name, $options); ?></td>
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


<?= $this->Form->end(); ?>