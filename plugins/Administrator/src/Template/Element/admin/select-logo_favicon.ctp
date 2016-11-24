

<section id="gallery_images" class="gallery overThumbnails"></section>

<!-- seleccion de imagen logotipo -->
	<div id="featured_image" class="gallery-div">
		
		<!-- seccion principal -->
            <section class="content">   
                    <section class="up-section section fondo5">
                            <div class="table">
                                <div class="table-cell">
                                    <h1 class="principal color1"><?php echo __($imagesText['select_logo']); ?></h1>
                                    <p class="principa-description"><?php echo __($imagesText['select_logo_description']); ?></p>
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
		                               
		                               <div id='ajax'></div>

										
		                            </div>
		                    </section>
		            </section>
	</div>
<!-- seleccion de imagen logotipo -->

<!-- seleccion de imagen favicon -->
	<div id="see_all_files" class="gallery-div">
		
		<!-- seccion principal -->
            <section class="content">   
                    <section class="up-section section fondo5">
                            <div class="table">
                                <div class="table-cell">
                                    <h1 class="principal color1"><?php echo __($imagesText['select_favicon']); ?></h1>
                                    <p class="principa-description"><?php echo __($imagesText['select_favicon_description']); ?></p>
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
		                               
		                               <div id='ajax1'></div>

										
		                            </div>
		                    </section>
		            </section>
		<!-- seleccion de galeria de imagenes -->
	</div>
<!-- seleccion de imagen favicon -->




<script>
         $(document).ready(function() {
	
// abrir y cerrar seleccion imagen destacada
  	$(".index-image").click(function() {

  		$('#ajax').html('<center><img id="loader-img" alt="" src="<?php echo $this->Url->build('/', true);?>administrator/img/loading.gif" width="450" height="150" align="center" /></center>');
	     
	  
		     	$.get( "<?php echo $this->Url->build('/', true);?>admin/File/getLogo/" , {accion: "add"}, function( data ) {
		        $( "#ajax" ).html( data );
		       
		      });

		  $('#featured_image, #gallery_images').fadeToggle('fast');
		  $("#menu, .linea").toggleClass('hidden');
		  $("#pushobj").toggleClass('static');
		  return false;
	});

	// abrir y cerrar galeria completa
	$(".index-icono").click(function() {

		  $('#ajax1').html('<center><img id="loader-img" alt="" src="<?php echo $this->Url->build('/', true);?>administrator/img/loading.gif" width="450" height="150" align="center" /></center>');

	   
		     	$.get( "<?php echo $this->Url->build('/', true);?>admin/File/getFav/" , {accion: "add"}, function( data ) {
		        $( "#ajax1" ).html( data );
		       
		      });

		  $('#see_all_files, #gallery_images').fadeToggle('fast');
		  $("#menu, .linea").toggleClass('hidden');
		  $("#pushobj").toggleClass('static');
		  return false;
	});


	$(".overThumbnails").click(function() {
			  $('#see_all_files, #featured_image, .overThumbnails').fadeOut('fast');
			  $("#menu, .linea").toggleClass('hidden');
			  $("#pushobj").toggleClass('static');

			  //console.log('click');
	});

		
});
</script>