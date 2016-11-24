
<?= $this->Form->create($gadget, ['id'=>'upload', 'enctype' => 'multipart/form-data']); ?>

<!-- cabecera de edicion -->
    <section class="content-table">     
    	<section class="up-section section fondo5">

    		<div id="table-edit" class="table table-edit table-edit_category">

                    <div class="table-cell">
                    	<?= $this->Form->input('name', ['label'=> false, 'placeholder'=> $controllerText['title_placeholder'], 'class' => 'edit-title', ]); ?>
                    	<p class="edit-info">
                    		<?= __($extras['created']); ?>: <span class="color2"><?= $creado; ?></span> |
                    		<?= __($extras['modified']); ?>: <span class="color2"><?= $modificado; ?></span>
                    	</p>

                    </div>

                    <div class="table-cell btn-section">
							<?php if($this->request->params['action'] != 'add') { // si estamos en la vista add no se muestra boton papelera
										echo $this->Form->button($extras['move_trash'], ['id'=>'button', 'class' => 'btn fondo1 color5 fondoh3 index-index',  
																	  			   		 'formaction' => $this->Url->build(["controller" => $this->request->params['controller'], "action" => 'clear/'.$gadget->id ]) ]); 
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
												
												 <?php $datos = ['type' => ['type' => 'select', 'options' => $types, 'label' => __($extras['theme']), ]]; ?>
			    								<tr>
					                                    <td class="td-select">
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

			    				<!-- seccion de campos de texto de la edicion -->
				    				<td class="no-padding table-edit_body_fields">
		    									
		    									<h2 class="fondo2 color5"><?php echo __($extras['general_description']) ?></h2>

						    					<?php $datos = ['description' => ['label' => false, 'type'=>'textarea', 'id' => 'redactor']]; ?>

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

<!-- imagenes -->
    <section class="content-table">     
    	<section class="section fondo5">

			<!-- tabla de $catss -->
			<table id="table-index" class="table-index" cellpadding="0" cellspacing="0">
				<tr class="fondo2 color5">
						<?php $titles = ['image', 'url', 'description', 'button_text', 'new_tab', 'actions']; 
							foreach ($titles as $title) { ?>
								<th><span><?= __($extras[$title]); ?></span></th>
						<?php } ?>
				</tr>
				<?php 

				if(isset($gadget->archives) && !empty($gadget->archives)) {

				foreach ($gadget->archives as $a => $image) { ?>

				<tr id="tr-image_<?php echo $image->id; ?>">
					<?= $this->Form->input('archives.'.$a.'.id', ['type' => 'hidden', 'value' => $image->id ]); ?>
					<td><aside class="image_gadget" style="background-image:url(<?= $this->Image->get_image_url($image->id, 'medium'); ?>);"></aside></td>
					<td><?= $this->Form->input('archives.'.$a.'._joinData.url', ['label' => false, 'placeholder' => $extras['url'] ]); ?></td>
					<td><?= $this->Form->input('archives.'.$a.'._joinData.description', ['type' => 'text', 'label' => false, 'placeholder' => $extras['description'] ]); ?></td>
					<td><?= $this->Form->input('archives.'.$a.'._joinData.button_text', ['type' => 'text', 'label' => false, 'placeholder' => $extras['button_text'] ]); ?></td>
					<td><?= $this->Form->input('archives.'.$a.'._joinData.new_tab', ['type' => 'checkbox', 'label' => false, 'placeholder' => $extras['button_text'] ]); ?></td>
					<td>
						<center>
							<?= $this->Html->link('', ['action' => '#'], ['data-tr' => '#tr-image_'.$image->id, 'data-id' => $image->id, 'id' => 'btn-table_index', 'class' => 'delete_image btn-trash fondo3 color5 fondoh2 tooltip']);?>
						</center>
					</td>
				</tr>
				<?php } } ?>
			</table>

		</section>
	</section>
<!-- fin imagenes -->





<!-- seccion inferior -->
<section class="table content-table">
</section>
<!-- seccion inferior -->


<!-- galeria de imagenes -->
        <?php echo $this->element('admin/edit-gallery'); ?>
<!--fin galeria de imagenes -->

<?= $this->Form->end(); ?>


<script type="text/javascript">
	$(document).ready(function () {
		$('.delete_image').click(function(){
	        var id = $(this).attr('data-tr');
	        var archive_id = $(this).attr('data-id');
	        var confirmar = confirm('¿Desea elimiar esta imagen?');
	        
	        if (confirmar == true) {
	        	$(id).remove();

	        	 $.get( "/admin/Gadgets/deleteArchive/" , { id: "<?= $id; ?>", archive_id: archive_id }, function(data) {
			        //$( "#homepage" ).prepend(data);  
			    });

	        }

	        return false;
		});
	});
</script>