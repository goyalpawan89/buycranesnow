
<?php 
echo $this->element('admin/icons'); // clases para llamar los iconos como select
$fontAwesomeURL = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$this->Url->build('/', true).'administrator/css/fuentes/font-awesome.css';



use BCA\FontAwesomeIterator\Iterator as FontAwesomeIterator; $iconsFont = new FontAwesomeIterator($fontAwesomeURL); 

echo $this->Form->create($category, array( 'id'=>'upload', 'enctype' => 'multipart/form-data')); ?>

<!-- cabecera de edicion -->
    <section class="content-table">     
    	<section class="up-section section fondo5">

    		<div id="table-edit" class="table table-edit table-edit_category">


                    <div class="table-cell">
                    	<?php echo $this->Form->input('name', ['label'=> false, 'placeholder'=> $controllerText['title_placeholder'], 'class' => 'edit-title', ]); ?>
                    	<p class="edit-info">
                    		<?php if($category->slug) { echo __($extras['custom_link']); ?>: <?php echo $this->Html->link($category->slug, ['action' => ''], ['class' => 'color2 colorh3', 'target' => '_blanck']); ?> | <?php } ?>
                    		<?php echo __($extras['created']); ?>: <span class="color2"><?php echo $creado; ?></span> |
                    		<?php echo __($extras['modified']); ?>: <span class="color2"><?php echo $modificado; ?></span>
                    	</p>

                    </div>

                    <div class="table-cell btn-section">
							<?php if($this->request->params['action'] != 'add') { // si estamos en la vista add no se muestra boton papelera
										echo $this->Form->button($extras['move_trash'], ['id'=>'button', 'class' => 'btn fondo1 color5 fondoh3 index-index',  
																	  			   		 'formaction' => $this->Url->build(["controller" => $this->request->params['controller'], "action" => 'clear/'.$category->id ]) ]); 
										// si estamos en la vista add no se muestra boton papelera
								  } 
							
							echo $this->Form->button(__($controllerText['submit']), ['name' => $extras['update'], 'id'=>'button', 'class' => 'btn fondo2 color5 fondoh3 index-'.$this->request->params['action'],]); ?>
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
			    					<td id="table-edit" class="table-edit_body_image">
			    						<table id="table-edit" class="table-index" cellpadding="0" cellspacing="0">

			    								<?php echo $this->element('upload_files/upload_files'); // archivo incluye tr y td de la tabla ?>

			    								
			    								
												<?php $datos = ['category_theme' => ['type' => 'select', 'options' => $themes, 'label' => __($extras['theme']),]]; ?>

													<tr>
														<td class="td-select">

														<table id="table-edit" class="table-index" cellpadding="0" cellspacing="0">
															<?php foreach ($datos as $name => $options) { ?>
															<tr>
																<td class="<?php echo $name; ?>"><?php echo $this->Form->input($name, $options); ?></td>
															</tr>
															<?php } ?>
															<tr>
																<td class="icons">
																	<div class="input select">
																	<label for="icon"><?php echo $extras['icon']; ?></label>
																	<select name="icon" class="fa-select select input">
																		<option value=""><?php echo $extras['select_default'];?></option>
																		<?php foreach ($iconsFont as $icon) {
																			  if($category->icon == $icon->unicode) { $selected = 'selected="selected"'; } else { $selected = NULL; }
				                                                                
																		        echo '<option '.$selected.' value="'.$icon->unicode.'"> &#x'.substr($icon->unicode, 1).'; ' .$icon->name.'</option>';
																		    } ?>
																		</select>																
																	</div>
																</td>
															</tr>
														</table>

														</td>
													</tr>

			    						</table>
			    					</td>
			    				<!-- fin seccion de imagen de la edicion -->

			    				<!-- seccion de campos de texto de la edicion -->
				    				<td class="no-padding table-edit_body_fields">
		    									
		    									<h2 class="fondo2 color5"><?php echo __($extras['general_description']) ?></h2>

						    					<?php $datos = ['slug' =>        ['label' => __($extras['custom_link']), 'placeholder' => __($extras['custom_link_placeholder']) ], 
						    									'parent_id' =>   ['label' => __($controllerText['up_categories']), 'type'=>'select','options'=> $superiores, 'empty' => __($extras['select_default'])], 
						    									'description' => ['label' => false, 'type'=>'textarea', 'id' => 'redactor'], // id es necesario para llamar el editor visual.
						    								   ]; ?>

		    									<table id="table-edit" class="table-index table-visual-editor" cellpadding="0" cellspacing="0">
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

<!-- seccion inferior -->
<section class="table content-table">
        
        <!-- seccion de campos personalizados -->
          <?php echo $this->element('admin/edit-categories_fields'); // elemento de camops personalizados llamados por tipo ?>
        <!--fin seccion de campos personalizados -->
</section>
<!-- seccion inferior -->


<!-- galeria de imagenes -->
        <?php echo $this->element('admin/edit-gallery'); ?>
<!--fin galeria de imagenes -->

<?php echo $this->Form->end(); ?>
