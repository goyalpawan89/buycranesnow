	

<section id="gallery_images" class="gallery overThumbnails"></section>
	
	<?php $pops = ['select_logo' => ['option_key' => 'logo', 'description' => 'select_logo_description', 'divID' => 'featured_image', 'ajaxID' => 'ajax', 'fileuploader_class' => 'logo-uploader', 'class_button' => 'index-image'],
				   'select_favicon' => ['option_key' => 'favicon', 'description' => 'select_favicon_description', 'divID' => 'featured_favicon', 'ajaxID' => 'ajax1', 'fileuploader_class' => 'favicon-uploader', 'class_button' => 'index-icono'],
				   'select_background' => ['option_key' => 'frontend_background_img', 'description' => 'select_background_description', 'divID' => 'featured_background_front', 'ajaxID' => 'ajax2', 'fileuploader_class' => 'background-uploader', 'class_button' => 'index-background_front'],
				  ]; ?>

		<?php foreach ($pops as $type => $popup) { ?>
				<!-- seleccion de imagen logotipo -->
					<div id="<?= $popup['divID']; ?>" class="gallery-div">
						
						<!-- seccion principal -->
				            <section class="content">   
				                    <section class="up-section section fondo5">
				                            <div class="table">
				                                <div class="table-cell">
				                                    <h1 class="principal color1"><?php echo __($imagesText[$type]); ?></h1>
				                                    <p class="principa-description"><?php echo __($imagesText[$popup['description']]); ?></p>
				                                </div>
				                                <div class="table-cell">
				                                <?php echo $this->Form->button(__($imagesText['submit_thumbnail']), ['name' => $extras['update'], 'id'=>'button', 'class' => 'btn fondo2 color5 fondoh3 index-'.$this->request->params['action'],]); ?>
				                                </div>
				                            </div>
				                    </section>
				            </section>
						<!-- seccion principal -->
							
							<section class="gallery-content content-table content">   
						                <section class="gallery-content_section section fondo5">
						                        <div class="content-gallery">
						                            <div id='<?= $popup['ajaxID']; ?>'></div>														
						                        </div>
						                </section>
						    </section>
					</div>
				<!-- seleccion de imagen logotipo -->
		<?php } ?>




<script>
         $(document).ready(function() {
	
	<?php foreach ($pops as $type => $popup) { ?>

	// abrir y cerrar seleccion imagen destacada
  	$(".<?= $popup['class_button']; ?>").click(function() {

  		$('#<?= $popup["ajaxID"]; ?>').html('<center><img id="loader-img" alt="" src="<?= $this->Url->build('/', true);?>administrator/img/loading.gif" width="450" height="150" align="center" /></center>');
	     
	  			//el link del ajax para todaas las imagenes en el front es el mismo
		     	$.get('<?= $this->Url->build("/", true)."admin/File/ /"; ?>', { 
		     			accion: "add", tipo: "<?= $this->request->params['controller']; ?>", option_key: "<?= $popup['option_key']; ?>", divID: "<?= $popup['divID']; ?>", fileuploader_class: "<?= $popup['fileuploader_class']; ?>" 
		     		}, 
		     	
		     	function( data ) {
		        	$("#<?= $popup['ajaxID']; ?>").html( data );
		       
		      	});

		  $('#<?= $popup["divID"]; ?>, #gallery_images').fadeToggle('fast');
		  $("#menu, .linea").toggleClass('hidden');
		  $("#pushobj").toggleClass('static');
		  return false;
	});

	<?php } ?>



	$(".overThumbnails").click(function() {
			  $('.gallery-div, .overThumbnails').fadeOut('fast');
			  $("#menu, .linea").toggleClass('hidden');
			  $("#pushobj").toggleClass('static');

			  //console.log('click');
	});

		
});
</script>