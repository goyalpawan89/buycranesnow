<?php 
	// camops personalizados del post
	$id = $content->id;
	$address = $this->Get->get_field_by_post_id($id, 'state'); 
	$city = $this->Get->get_field_by_post_id($id, 'city'); 
	$country = $this->Get->get_field_by_post_id($id, 'country'); 
	$brand = $this->Get->get_field_by_post_id($id, 'brand'); 
	$stars = $this->Get->get_field_by_post_id($id, 'ranking'); 
	//$avalible = $this->Get->get_field_by_post_id($id, 'avalible'); 

	$precio = $this->Get->get_field_by_post_id($id, 'price');
	$price = $this->Number->currency($precio, $info['currency']);
	$antes = $this->Get->get_field_by_post_id($id, 'price_before');
	$price_before = $this->Number->currency($antes, $info['currency']);
	$video = $this->Get->get_field_by_post_id($id, 'video'); 
	$mobile = $this->Get->is_mobile();

	$typeUser =  $content->user['type'];

	//obtener el id de la categoria a la que corresponde
	$avalible = $this->Get->get_cat_avalible($id);
	$avalibleName = 'avalible_'.$avalible;


	if(isset($content->user->archive_id) && !empty($content->user->archive_id)) { $companyImg = $this->Image->url($content->user->archive_id, 'full'); } else { $companyImg = $this->Url->build('/', true).$logo; }

	if($avalible == 11) { $btnAvalible = 'rent'; } else {  $btnAvalible = 'tender';  } // boton comprar  o alquilar

?>

<style type="text/css">
	header { background-color:transparent; }
	.nav a, .nav a:link, .nav a:visited, .nav a:hover, .nav a:focus { color:inherit; }
	.preview_aside-img a:before {  background-image: url(/<?= $logo; ?>); }
</style>

<script type="text/javascript">
	$(document).ready(function() {
		$('.nav > li a').css("color", "inherit"); 
    });

    $(window).bind('scroll', function(e) {
      var wintop = $(window).scrollTop(), docheight = $(document).height(), winheight = $(window).height(),
          showTrigger = '50',
          hideTrigger = '50';
          //aparece el background del header y achica el logo.
          if (wintop > showTrigger) { 
          		$("header .nav a").css("color", "#FFF");  } else { $("header .nav a").css("color", "inherit");  }
	});

</script>

<!-- publicidad superuir -->
			<aside class='float_search opacity'><?= $this->element('Front.buscador_post'); ?></aside>

<!-- contenido principal -->
<section class="background">
	<div class="wrap">
				
			<!-- publicidad superuir -->
			<?= $this->element('Front.publicity_up'); ?>
			
			<!-- mapa -->	
			<br/>		
			<div id="mapa"><div id='map_canvas' style="width:100%; height:400px;"></div></div>


			<!-- descripcion superior -->
			<article class="category-description description">
				<table class="post-user_description">
					<tr>
						<td>
							<aside class='post-user_img'>
								<?= $this->Html->link($this->Html->image($companyImg, ['alt' => '']), $linkUser, ['class' => $fancy, 'escape' => false]);

									if($authUser) { echo '</br></br><div>'.$this->Html->link(__($extras['see_owner_site']), $linkUser, ['class' => 'btn btn-link fondo1 fondoh3 color3 colorh0']).'</div>'; }

 							  	    if($typeUser == 'Premium') { echo $this->Html->image('premium.png', ['alt' => $blogName, 'fullBase' => true, 'class' => 'tag_premium tooltip', 'title' => __($extras['company']). ': '. $user->type ]); } ?>

							</aside>
							
							<div class="post-user_text">
								<span class="post-user_text_title"><?= $brand; ?></span>
																
								<div>						
										<span class="post-user_text_dir"><?php if(!empty($address)) { $address. ' | '; } ?> <?php if(!empty($city)) { echo $city." - "; } ?> <?php if(!empty($country)) { echo $country; } ?></span><br>
										<?php if(!empty($city)) { echo $this->Html->link(__($extras['see_map']), '#mapa', ['class' => 'show-map post-user_text_dir btn btn-link fondo1 fondoh3 color3 colorh0']); } ?>
								</div>
							</div>
						</td>
						<td>
							
							<!-- listado de botones -->
							<div class="post-user_contact">
								<li class="post-user_contact_list">
								<?php 
									if($authUser) {

											if($favorite == 1) { // si favorito es 1, el post ya fue relacionado con el usuario 
												
											$action = 'remove_favorite';
											$class = 'post-user_contact_list_item before-list_item favorite fondoremove fondoh3 color0';

											} else { 

											$action = 'save_favorite';
											$class = 'fondoh1 post-user_contact_list_item before-list_item favorite color3 fondoh3 colorh1';

											}

											echo $this->Form->postLink($extras[$action], ['action' => $action, $id], ['title' => __($extras['save_favorite']), 'class' => $class]); 

									} else {

											echo $this->Html->link(__($extras['save_favorite']), $loginDiv, ['class' => 'fancybox post-user_contact_list_item before-list_item favorite color3 fondoh3 colorh1']);	
									}
								?>
								</li>

								<li class="post-user_contact_list">
								  <?= $this->Html->link(__($extras['alert_email']), $emailAlert, ['title' => __($extras['alert_email']), 'class' => 'fancybox post-user_contact_list_item before-list_item alert_email color3 fondoh3 colorh1']); ?>
								</li>

								<li class="post-user_contact_list">
								  <?= $this->Html->link(__($extras['quote']), $quote, ['target' => $quoteTarget, 'class' => 'post-user_contact_list_item before-list_item quote color3 fondoh3 colorh1']); ?>
								</li>

								<li class="post-user_contact_list">
									<?= $this->Html->link(__($extras['see_contact']), $userInfo, ['id' => 'contact-'.$content->user->id, 'class' => 'fancybox post-user_contact_list_item before-list_item see-contact color3 fondoh3 colorh1']); ?>
								</li>
								
								<li class="post-user_contact_list">
									<span class="post-user_contact_list_item shared">

										<font><?= __($extras['shared']); ?></font>
										

										<aside class="icons_shared">
										<a class="share face color3 colorh2" href="javascript:window.open('https://www.facebook.com/sharer/sharer.php?t= » <?= $content->name; ?>&u=<?= $this->Get->get_url(); ?>', '_blank', 'width=400,height=500');void(0);"><i class="fa fa-facebook-square"></i>
										</a>

										<a class="share tw color3 colorh2" onClick="window.open('http://twitter.com/intent/tweet?text=<?= $content->name; ?>+<?= $blogName; ?>+<?= $this->Get->get_url(); ?>','sharer','toolbar=0,status=0,width=580,height=325');" href="javascript: void(0)">
											<i class="fa fa-twitter-square"></i>
										</a>

										<a class="share tw color3 colorh2" onClick="window.open('https://www.linkedin.com/cws/share?url=<?= $this->Get->get_url(); ?>','sharer','toolbar=0,status=0,width=580,height=325');" href="javascript: void(0)">
											<i class="fa fa-linkedin-square"></i>
										</a>

										</aside>

									</span>
								</li>
								
								<?php if($content->crane_status == 0) { ?>
								<li class="post-user_contact_list">
									<?= $this->Html->link(__($extras[$btnAvalible]), $avalibleAction, ['class' => $fancyOffer.' btn btn-sell fondo1 color3 fondoh3 colorh0', 'data-fancybox-type' => $iframe ]); ?>
								</li>
								<?php } ?>
								<!-- listado de botones -->

							</div>
							<!-- fin listado de botones -->

						</td>
					</tr>					
				</table>
			</article>
			
						<!-- breadcrumbs -->
						<aside id="breadcrumbs" class="list-description table">	

							<aside class="list-description_item table-cell"><b><?= $extras['you_are_in']; ?>: </b> <?= $this->Get->get_breadcrumb($id); ?></aside>

							      <aside class="list-description_item table-cell">
							      	<span class="date"><?= __($extras['publicated']); ?>: <?= date_format($content->created, 'Y-m-d') ?> </span> | <span class="date"><?= __($extras['modified']); ?>: <?= date_format($content->modified, 'Y-m-d') ?> </span>
							      	
							      	<?php 

							      	if($authUser) {
							      			//pdfs
							      			if(isset($pdfs) && !empty($pdfs)) { 
							      		  			foreach ($pdfs as $pdf) { 
							      						echo $this->Html->link(__($extras['download_list']), $pdf->folder.$pdf->filename, ['title' => $pdf->name, 'target' => '_blank', 'class' => 'download_list color3 colorh1']);
							      					}
							      			} 

							      			//video
							      			if(isset($video) && !empty($video)) { 
							      					echo ' | ' . $this->Html->link(__($extras['video']), $video, ['title' => $content->name, 'target' => '_blank', 'rel' => $rel, 'class' => 'fancybox-media video color3 colorh1']); 
							      			}
							      	} ?>

							      </aside>
						</aside>
						<!-- fin breadcrumbs -->

			<!-- fin descripcion superior -->

		
			<aside id="next_prev_post" class="">
				
				<?php $nextLink = $this->Get->get_link($this->Get->get_next_post_id($content->id), 'Posts');
					  $prevLink = $this->Get->get_link($this->Get->get_prev_post_id($content->id), 'Posts'); 

				if(isset($prevLink) && !empty($prevLink)) { ?><li class="btn_controls fondo2 fondoh1 <?= $this->Get->get_prev_post_id($content->id); ?>"><?= $this->Html->link('<i class="fa fa-chevron-left"></i>',  $prevLink, ['escape' => false, 'class' => 'color0 tooltip', 'title' => __($extras['prev']), 'rel' => $rel]); ?></li> <?php } 
				if(isset($nextLink) && !empty($nextLink)) { ?> <li class="btn_controls fondo2 fondoh1"><?= $this->Html->link('<i class="fa fa-chevron-right"></i>',  $nextLink, ['escape' => false, 'class' => 'color0 tooltip', 'title' => __($extras['next']), 'rel' => $rel]); ?></li> <?php } ?>
				
			</aside>


			<section class="content-post">
				
				<!-- imagenes y oferta -->
				<aside class="content-side_gallery">
					

					<aside class="preview">
								
								<aside class="preview_aside-img" data-logo="<?= $this->Url->build('/', true).$logo; ?>">
										<a href="<?= $this->Image->url($content->archive_id, 'full'); ?>" class="cambio_img fancybox" title="<?= $content->name; ?>" rel="<?= $rel; ?>"><?= $this->Html->image($this->Image->url($content->archive_id, 'medium'), ['id' => 'main']); ?>

											<?php 
											if($content->crane_status == 0) { 
													if(isset($antes) && !empty($antes)) { ?>
														<aside class="tag big_tag"><span><?= __('Promoción'); ?></span></aside>
													<?php } ?>
											<?php } else { ?>

													<aside class="tag big_tag <?= 'avalible_'.$content->crane_status; ?>"><span><?= __($extras[$content->crane_status.'_avalible']); ?></span></aside>

											<?php } ?>
											
											<?php if(isset($avalible) && !empty($avalible)) { ?>
												<aside class="preview_aside-img-text">
													<h1 class="fondo1 color3"><?= $content->name; ?></h1>
													<span class="color0 fondo2"><b><?= __($extras['avalible_for']). '</b> ' . __($extras[$avalibleName]); ?> 
													<?php if(isset($price) && !empty($price) && $price != 'US$0,00' && $avalible == 11) { echo ' | <b>' . __($extras['price']). '</b> ' . $price . ' | ' .$extras['price_month']; } ?>
													</span>
												</aside>
											<?php } ?>
										</a>
								</aside>


							<?php if(isset($content->archives) && !empty($content->archives)) { ?>
								
								<nav id="nav_thumbs <?php if($mobile != 0 && empty($authUser)) { echo 'dont_show'; } ?>">
									<div class="slider2">

								          <?php foreach ($content->archives as $a => $archive) {
								                 $thumbUrl = $this->Image->url($archive->id, 'medium');
								                 $fullUrl = $this->Image->url($archive->id, 'full'); ?>
								                <div class="slide marcas_slide">
								                  <a class="miniatura fancybox" href="<?= $fullUrl; ?>" rel="<?= $rel; ?>" title="<?= $content->name; ?>" style="background-image:url(<?= $thumbUrl; ?>);"></a>
								                </div>
								          <?php } ?>

								          <?php if(isset($video) && !empty($video)) { ?>
												<div class="slide marcas_slide">
													<?= $this->Html->link('<i class="fa fa-play-circle-o"></i>',  $video, ['escape' => false, 'class' => 'fancybox-media video_thumbnail color1 colorh0 fondo3 tooltip', 'title' => __($extras['video']). " ".$content->name, 'rel' => $rel]); ?>
												</div>
										  <?php } ?>
										  
								    </div>

								    <?php if (!$authUser && isset($a) && !empty($a) && $a > 3) { ?>
									 	<aside class="opacity_nav"><?= $this->Html->link(__($extras['login_to_see_more']), $loginDiv, ['class' => 'fancybox color3 colorh3']);  ?></aside>
									<?php } ?>

						        </nav>

							<?php } ?>

				</aside>
				<!-- imagenes y oferta -->
					
				<?php if(isset($authUser) && !empty($authUser) && $content->crane_status == 0) { ?>	

					<div class="content-post_ofert">

						<a href="#compare_box" id='list_button' class='fondoh1 post-user_contact_list_item before-list_item compare color3 fondoh3 colorh1 fancybox'><?php echo $extras['compare_cranes'];?></a>
						<?php if($avalible == 12 && $content->crane_status == 0) { echo $this->Html->link(__($extras[$btnAvalible]), $avalibleAction, ['class' => $fancyOffer.' btn btn-sell fondo1 color3 fondoh3 colorh0 btn_offer', 'data-fancybox-type' => $iframe ]); } ?>

					</div>

				<?php } ?>


				</aside>
				<!-- imagenes y oferta -->
				

				<!-- descripcion y campos personalizados -->
				<aside class="content-side_description">

					<div class="content-side_description_bloque">
						<h1 class="fondo1 content-side_description_title"><?= __($content->name); ?> | <?= __($extras['code']); ?>-<?= $content->id; ?></h1>
						<div class="content-side_description_text">
							<strong><?= __($extras['description']); ?></strong>
							<?= $content->description; ?>
						</div>
						
						<aside class="all_fields">
							<h1 class="fondo2 color0 content-side_description_title details"><?= __($extras['details']); ?></h1>
							
							<?php if(!empty($content->categories)) { ?>
										<div class="content-side_description_text fields">
												<b><?= __($extras['type']); ?>: </b> <font><?= $content->categories[0]->name; ?></font>
										</div>
							<?php } ?>

							<?php 
							foreach ($content->fields as $field) {
							      if(!empty($field->option_key)) {
							      	  if($field->option_key == 'price' || $field->option_key == 'price_before') {

							      	  		if(isset($authUser)) {
							      				$val = $this->Number->currency($this->Get->get_field_by_post_id($id, $field->option_key), $info['currency']);

							      			} else {
							      				$val = null;
							      			}

								      } else { 
								      		$val = $field->_joinData->value; 
								      } ?>
							
										<?php if(!empty($val)) { ?>
											<div class="content-side_description_text fields">
												<b><?= __($extras[$field->option_key]); ?>: </b> <font><?= $val; ?></font>
											</div>
										<?php } ?>

							<?php } } ?>

						</aside>


					</div>

				</aside>
				<!-- descripcion y campos personalizados -->
			
			</section>


			<!-- Organic Tabs (Example One) -->
		<section id="example-one" class="site-tabs">

		<?php if (!$authUser && isset($a) && !empty($a) && $a > 3) { ?>
				 	<aside class="opacity_nav"><?= $this->Html->link(__($extras['login_to_see_more']), $loginDiv, ['class' => 'fancybox color3 colorh3']);  ?></aside>
		<?php } ?>


        	<ul id="tabs_posts" class="nav">
        		
        		<?php $a=0; foreach ($fieldsByTabs as $item => $value) { ?>
                			<li class="nav-one post-tab"><a href="#<?= $item; ?>" class="<?php if($a == 0) { echo 'current'; } ?> color3 fondoh2 colorh4"><?= $extras[$item]; ?></a></li>
                <?php $a++; } ?>

            </ul>

        	<div class="list-wrap">

        		<?php $a=0; foreach ($fieldsByTabs as $key => $value) { ?>
        		
	        		 <ul id="<?php echo $key; ?>" class="<?php if($a!=0) { echo 'hide'; } ?>">
						
						<?php foreach ($value as $key => $field) { 
							  $value = $this->Get->get_field_by_post_id($id, $field['option_key']); ?>
							<li>
									<b><?= __d('front', $field['option_label']); ?></b> 

									<?php if(!empty($value)) { 

												if (is_numeric($value) && strpos($field['option_key'], 'price') !== false) {
													     
													     echo $this->Number->currency($value, $info['currency']);

												} else { 

													     echo __d('front', $value);
											    }

										  } else { echo __d('front', $extras['n_a']); } ?>
							</li>	

						<?php } ?>

	        		 </ul>

	        	<?php $a++; } ?>
        	</div>

        </section>



	</div>
</section>
<!-- fin contenido principal -->



<!-- email alert -->
<div id="email_alert" class="loginbox">
  <h2><?= __($extras['generate_alert']); ?></h2>
  <p></p>
</div>


<!-- compare box -->
<div id="compare_box" class="loginbox">
  <center><?= __($extras['loading_info']); ?></center>
</div>


<!-- nuevos arrivos -->
			<section class="up-section counter-section background">
                    <div class="wrap">
                       	<h2 class="title-section"><?= __($extras['relationship_cranes']); ?></h2>
                    </div>
						

						<section class="destacados background border1">
						    <div class="slider4">
						      
						      <?php foreach ($gruasRelacionadas as $post) { 
						        $image = $post->archive_id; //id de la imagen
						        $excerpt = $this->Get->get_excerpt($post->id, 70); //get excerpt (descricion o texto dependiendo de si existe o no)
						        $video = $this->Get->get_field_by_post_id($post->id, 'video'); ?>
						        
						          <div class="slide destacados_slide">
						                    <a href="<?= $this->Get->get_link($post->id, 'Posts'); ?>">
						                            <aside class="slide_img fondo0 border0 <?php if($video && !empty($video)) { echo 'list-post_image_video'; } ?>" style="background-image:url(<?= $this->Image->url($image, 'medium') ?>);">
						                                <h3 class="color0 fondo2 border1"><?= $post->name; ?></h3>
						                            </aside>
						                    </a>
						          </div>
						      <?php } ?>
						    </div>
						</section>

			</section>
<!--fin nuevos arrivos -->


<!-- fancybox sections -->
<section class="post-user_info" id="user-info">	
	<h2 class="fondo1 content-side_description_title"><?= __($extras['user_data']); ?></h2>

	<?php $userData = ['name' => $user->name.' '.$user->last_name, 'company_name' => $user->company_name, 'email' => $user->company_email, 'company_position' => $user->company_position, 
					   'country' => $user->company_country, 'city' => $user->company_city, 'address' => $user->company_address, 'phone' => $user->company_tel];

	foreach ($userData as $name => $data) { 
			if(!empty($data)) { 
			if($data == 'email' && $user->id == 3) { } else { ?>
	<div class="content-side_description_text fields">
		<b><?= __($extras[$name]); ?>: </b> <font><?php if($name == 'phone') { echo $user->company_code_tel.$user->company_area_tel. ' ' .$user->company_tel;  } else { echo $this->Text->autoLinkEmails($data); } ?></font>
	</div>
	<?php } } } ?>

	<div class="content-side_description_text fields">
		<span><?= $this->Html->link(__($extras['see_owner_site']), ['controller' => 'Users', 'action' => 'site/'.$content->user['id']], ['class' => 'color3 colorh2']); ?></span>
	</div>
		
</section>
<!-- fin fancybox sections -->

<div id='data_compare_crane'></div>

<?= $this->Html->script('Front.tabs/organictabs.jquery'); // tabs ?>

<script type="text/javascript">

//organic tabs
$(function() {
    $("#example-one").organicTabs();
});


// script de la galería que cambia sobre la imagen grande
$(window).load(function() { 
	  $("aside.preview nav").show();
	  var previewImg = $("img#main");
	  var imgTitle = $("nav img:first-child").attr("title");
	  
	  $("a:first").addClass("active");
	  $(".caption").html(imgTitle);
	  $("nav .miniatura").click(function(){
	    imgTitle = $(this).attr("title");
	    var link = $(this);  
	    var linkHref = link.attr("href");     
	    var linkAlt = link.attr("alt");     
	    if( $(link).hasClass("active") == false)
	    {
	      $("a").removeClass("active");
	      link.addClass("active");                      
	      $(previewImg).animate({
	        opacity: 0.8,
	      }, 300, function() {
	        if(imgTitle != "") $(".caption").html(imgTitle);
	        previewImg.attr("src", linkHref);
	        $('.cambio_img').attr("href", linkHref);      
	        previewImg.attr("alt", linkAlt);       
	        $(this).animate({
	          opacity: 1,
	          }, 300
	        );              
	      });     
	    }
	    return false;
	  });
  
});

$(document).ready(function(){

//mostrar o esconder el mapa.
$( ".request-price" ).click(function() {
	  $('.ofert-form').toggleClass( "show" );
	  return false;
});

// carousel imagenes del post
	  $('.slider2').bxSlider({
	  			slideWidth: 120,
			    minSlides: 4,
			    maxSlides: 6,
			    moveSlides: 1,
			    slideMargin: 0,
			    pager: false,
			    nextText: '',
			    prevText: '',
	  	<?php if($authUser) { // si es un usuario registrado que funcione el carousel, si no, que no se muestre ?>
	  			auto:true,
	  			controls: true,
	    <?php } else { ?>
	    		auto:false,
	    		controls: false,
	    <?php } ?>
	  });


});

</script>


<?php echo $this->Html->script('http://maps.google.com/maps/api/js?key=AIzaSyCCgFqBWasG_SmdBjd93zNpPg5ee5T_iwY&language='.$lang);
      echo $this->Html->script('markers'); ?>

<script type="text/javascript">

  var delay = 100;
  var markerArray = []; //create a global array to store markers  
  var infowindow = new google.maps.InfoWindow();
  var mapOptions = {
    zoom: 8,
    mapTypeId: google.maps.MapTypeId.ROADMAP,
  }

  var geocoder = new google.maps.Geocoder(); 
  var map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);

  //opciones que llamamos desde el marchivo makers.js para que formando cuadros o grillas organicemos en conjuntos las grúas cercanas
  var mcOptions = { gridSize: 50, maxZoom: 18 }; // tamaño de la cuadricula y el zoom que acepta más zoom más profundo se puede ver el conjunto
  var mc = new MarkerClusterer(map, [], mcOptions); 

  //centrar dependiendo de la grua que se ve
  var geocoder =  new google.maps.Geocoder();
    geocoder.geocode( { 'address': '<?= $address; ?>, <?= $city; ?>'}, function(results, status) {
    if (status == google.maps.GeocoderStatus.OK) {

            $(window).load(function() { 
			    initialLocation = new google.maps.LatLng(results[0].geometry.location.lat(), results[0].geometry.location.lng());
			    map.setCenter(initialLocation);
          		//map.setZoom(12);
			});

          } 
    })


  function geocodeAddress(address, next, img, href, title, logo, logolink, id) {
    geocoder.geocode({address:address}, function (results,status)
      { 
         if (status == google.maps.GeocoderStatus.OK) {
          var p = results[0].geometry.location;
          var randomLat =  Math.floor(Math.random() * 500)/79673;
          var randomNLong =  Math.floor(Math.random() * 500)/70673;
          var lat=p.lat() + randomLat;
          var lng=p.lng() + randomNLong;

          createMarker(address,lat,lng, img, href, title, logo, logolink, id);
        }

        else {

            if (status == google.maps.GeocoderStatus.OVER_QUERY_LIMIT) {
            		nextAddress--;
            		delay++;
          	}

        }

        next();
        mc.addMarkers(markerArray , true);

      }
    );
  }

function createMarker(add,lat,lng, img, href, title, logo, logolink, id) {
   var contentString = add;
   var imageContent = img;
   var hrefContent = href;
   var titleContent = title;
   var logoContent = logo;
   var logoLinkContent = logolink;
   var idContent = id;
   var icono;
   var zIndex;

   if(idContent == '<?= $content->id; ?>') { icono = ''; zIndex = 999999; } else { icono =  '<?= $this->Url->build('/', true); ?>/img/marker.png'; zIndex = 0; }
   
   var marker = new google.maps.Marker({
					   position: new google.maps.LatLng(lat,lng),
					   map: map,
					   icon: icono,
					   zIndex: zIndex,
		           });

   		var divInfo = '<aside id="infoMaps"><a href="' +hrefContent + '"><img src="' +imageContent + '" width="170"> <a href="'+ logoLinkContent +'"><img src="'+ logoContent + '" width="170" style="max-height:70px;" /></a> <h4>' + titleContent + '</h4>' + contentString + '  <a href="'+ hrefContent +'" class="btn btn-link fondo1 fondoh3 color3 colorh0"><?= __($extras["more_information"]); ?></a> </aside>';

   		//abrir los markers
    	google.maps.event.addListener(marker, 'click', function() {
     		infowindow.setContent(divInfo); 
    		infowindow.open(map,marker);
  	 	});

    	//marker abierto 
  	 	if(idContent == '<?= $content->id; ?>') {
	    
	          infowindow.setContent(divInfo);
	          infowindow.open(map,marker);
      	
      	} else {

      		markerArray.push(marker); 
      	}

}

  var locations = [ <?php foreach ($posts as $post) { $state = $this->Get->get_field_by_post_id($post['id'],'state'); $city = $this->Get->get_field_by_post_id($post['id'],'city'); $country = $this->Get->get_field_by_post_id($post['id'],'country');  echo "\"".$country." - ".$city.", ".$state."\",";  } ?> ];
  var images = [ <?php foreach ($posts as $post) { $image = $this->Image->url($post['archive_id'], 'medium');  echo "\"".$image."\","; } ?> ];
  var hrefs = [ <?php foreach ($posts as $post) { $link = $this->Get->get_link($post['id'], 'Posts');  echo "\"".$link."\","; } ?> ];
  var titles = [ <?php foreach ($posts as $post) { echo "\"".$post->name."\","; } ?> ];
  var logos = [ <?php foreach ($posts as $post) { $logo = $this->Image->get_image_by_user_id($post->user_id, 'medium');  echo "\"".$logo."\","; } ?> ];
  var logosLinks = [ <?php foreach ($posts as $post) { $userLink = '/'.$info['Users'].'/site/'.$post->user_id;  echo "\"".$userLink."\","; } ?> ];
  var ids = [ <?php foreach ($posts as $post) {  echo "\"".$post->id."\",";  } ?> ];

  var nextAddress = 0;
  function theNext() {
    if (nextAddress < locations.length) {
      setTimeout('geocodeAddress("'+locations[nextAddress]+'",theNext, "'+images[nextAddress]+'", "'+hrefs[nextAddress]+'", "'+titles[nextAddress]+'", "'+logos[nextAddress]+'", "'+logosLinks[nextAddress]+'", "'+ids[nextAddress]+'")', delay);
      nextAddress++;
    } 
  }
  theNext();


  //usuario SOLOGRUAS
  $('#contact-3').attr('href', '<?= $this->Get->get_link(8, 'Pages'); ?>').removeClass('fancybox');

</script>


<?php if($authUser) { ?>

<script type="text/javascript">
		
		//ranking
		$(':radio').change(  function(){ 
				$(':radio').removeAttr('checked');
				$(this).attr('checked', 'checked'); 
		});

		//calificaciones
		$(".stars").click(
		    function(event) {
		      $.post( 
		          "<?= $this->Url->build('/', true); ?>ranking",
		          { id: "<?= $id;?>", value: ''+ $(this).val() +'', user: "<?= $authUser['id'];?>" }, 
		          function(data) {
		             $('#stage').html(data);
		          }
		      );
		  		console.log($(this).val());
		});


		$(".compare").click(
		    function(event) {

		      $.post( 
		          "<?= $this->Url->build('/', true);?>compare_request",
		          { id: "<?= $id;?>", user: "<?= $authUser['id'];?>" }, 
		          function(data) {
		            $('#compare_box').html(data);
		             
					//$("#compare_pop").fancybox().trigger('click');

				    console.log('almacenado');

				    //console.log(data);
		          }
		      );
		  		//console.log($(this).val());
		});


		//email alert
		$(".alert_email").click(
		   function(event) {
		     $.post( 
		         "<?= $this->Url->build('/', true);?>alert",
		         { id: "<?= $id;?>", user: "<?= $authUser['id'];?>" }, 
		         function(data) {
		            $('#stage').html(data);
		         }
		     );
		 	console.log($(this).val());
		});

</script>
<?php } ?>

