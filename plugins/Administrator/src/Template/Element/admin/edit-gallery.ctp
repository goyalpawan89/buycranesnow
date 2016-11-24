<section id="gallery_images" class="gallery overThumbnails"></section>

<!-- seleccion de imagen destacada -->
	<div id="featured_image" class="gallery-div">
		
		<!-- seccion principal -->
            <section class="content">   
                    <section class="up-section section fondo5">
                            <div class="table">
                                <div class="table-cell">
                                    <h1 class="principal color1"><?php echo __($imagesText['featured_picture']); ?></h1>
                                    <p class="principa-description"><?php echo __($imagesText['gallery_featured_description']); ?></p>
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




<!-- seleccion de imagen destacada -->

<?php if($this->request->params['controller'] != 'Categories') { ?>

		<!-- seleccion de galeria de imagenes -->
			<div id="see_all_files" class="gallery-div">
				
				<!-- seccion principal -->
		            <section class="content">   
		                    <section class="up-section section fondo5">
		                            <div class="table">
		                                <div class="table-cell">
		                                    <h1 class="principal color1"><?php echo __($imagesText['gallery_title']); ?></h1>
		                                    <p class="principa-description"><?php echo __($imagesText['gallery_description']); ?></p>
		                                </div>

		                                <div class="table-cell">
		                                <?php echo $this->Form->button(__($imagesText['submit_gallery']), ['name' => $extras['update'], 'id'=>'button', 'class' => 'btn fondo2 color5 fondoh3 index-'.$this->request->params['action'],]); ?>
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
			</div>
		<!-- seleccion de galeria de imagenes -->

<?php } ?>





<script>
         $(document).ready(function() {
	
// abrir y cerrar seleccion imagen destacada
  	$(".index-image").click(function() {

  		$('#ajax').html('<center><img id="loader-img" alt="" src="<?php echo $this->Url->build('/', true);?>administrator/img/loading.gif" width="450" height="150" align="center" /></center>');
	     
	     <?php 
		     //Validamos si es un EDIT
		     if($this->request->params['action']!='add'){?>
		     $.get( "<?= $this->Url->build('/', true);?>admin/File/getThumbUrl/" , {id: "<?= $id;?>", tipo: "<?= $this->request->params['controller']; ?>", accion: "edit" }, function( data ) {
		        $( "#ajax" ).html( data );
		       
		      });
		     <?php }else{
		     	//add?>
		     	$.get( "<?php echo $this->Url->build('/', true);?>admin/File/getThumbUrl/" , {accion: "add", tipo: "<?= $this->request->params['controller']; ?>"}, function( data ) {
		        $( "#ajax" ).html( data );
		       
		      });
	     <?php } ?>

		  $('#featured_image, #gallery_images').fadeToggle('fast');
		  $("#menu, .linea").toggleClass('hidden');
		  $("#pushobj").toggleClass('static');
		  return false;
	});

	// abrir y cerrar galeria completa
	$(".index-gallery").click(function() {

		  $('#ajax1').html('<center><img id="loader-img" alt="" src="<?php echo $this->Url->build('/', true);?>administrator/img/loading.gif" width="450" height="150" align="center" /></center>');

	      <?php if($this->request->params['action']!='add'){?>
	      $.get( "<?php echo $this->Url->build('/', true);?>admin/File/getThumbFull/" , {id: "<?php echo $id;?>", tipo: "<?= $this->request->params['controller']; ?>" }, function( data ) {
	        $( "#ajax1" ).html( data );
	       
	      });
	      <?php }else{
		     	//add?>
		     	$.get( "<?php echo $this->Url->build('/', true);?>admin/File/getThumbFull/" , {accion: "add", tipo: "<?= $this->request->params['controller']; ?>"}, function( data ) {
		        $( "#ajax1" ).html( data );
		       
		      });
	     <?php } ?>

		  $('#see_all_files, #gallery_images').fadeToggle('fast');
		  $("#menu, .linea").toggleClass('hidden');
		  $("#pushobj").toggleClass('static');
		  return false;
	});


	$(".overThumbnails").click(function() {
			  $('#see_all_files, #featured_image, .overThumbnails').fadeOut('fast');
			  $("#menu, .linea").toggleClass('hidden');
			  $("#pushobj").toggleClass('static');
	});

		
});
</script>