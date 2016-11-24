

<!-- contenido principal -->
<section class="content background">
	<div class="wrap">
			
			<!-- descripcion de la categoria -->
			<article class="category-description description">
				<h1><?= __($extras['results_search']); ?></h1>
			</article>
			<br><br>
			
			
							
			<div id="mapa"><div id='map_canvas' style="width:100%; height:400px;"></div></div>

			<!-- Contenido de la categoria -->
			<table class="content-table">
				<tr>
					<td class="fondogris">
						<?= $this->element('sidebar');?>
					</td>
					<td>
						<content class="content-table_content">
						
						<table id="filters" class="button-group sort-by-button-group order-table">
							<tr>
										<td><?= $this->Form->button(__($extras['original_order']), ['label' => false, 'class' => 'input-sort is-checked', 'data-sort-value' => 'original-order']); ?></td>
										<?php 
											  $titles = ['brand' => $extras['maker'],
											  			 'year' => $extras['year_maker'],  
														 'tons' => $extras['tons'], 
														 'city' => $extras['city'], 
														 'created' => $extras['recent'], 										 
														 ]; 

											foreach ($titles as $key => $title) { ?>
												<td>
												<?= $this->Form->button(__($title), ['label' => false, 'class' => 'input-sort', 'data-sort-value' => $key]); ?>
												</td>
										<?php } ?>
							</tr>
						</table>
							
							

							<!-- isotope -->
								<div class="grid-overflow">
										<div class="grid">
											
											  <?php foreach ($posts as $key => $post) 	{
													  setlocale(LC_MONETARY, 'en_US');

													  $precio = $this->Number->currency($this->Get->get_field_by_post_id($post['id'], 'price'), $info['currency']);
													  $disponible = $this->Get->get_field_by_post_id($post['id'], 'avalible');
													  $beforePrice = $this->Get->get_field_by_post_id($post['id'], 'price_before');
													  $antes = $this->Number->currency($beforePrice, $info['currency']);
													  $link = $this->Get->get_link($post['id'], 'Posts');
													  $year = $this->Get->get_field_by_post_id($post['id'], 'year');
													  $marca = $this->Get->get_field_by_post_id($post['id'], 'brand');
													  $tons = $this->Get->get_field_by_post_id($post['id'], 'tons');
													  $city = $this->Get->get_field_by_post_id($post['id'], 'city');
													  $location = $this->Get->get_field_by_post_id($post['id'], 'location');
													  if($disponible == 'ALQUILER') { $btnAvalible = 'rent'; } else {  $btnAvalible = 'sell'; } // boton comprar  o alquilar ?>

													<article id="<?= $this->request->params['action']; ?>" class="element-item list-post border1 <?php if(!empty($beforePrice)) { echo 'promotion'; } ?>" 
																									data-brand="<?= $marca; ?>" 
																									data-id="<?= $post['id']; ?>" 
																									data-year="<?= $year; ?>" 
																									data-tons="<?= $tons; ?>" 
																									data-tons="<?= $tons; ?>" 
																									data-city="<?= $city; ?>" 
																									data-created="<?= date_format($post['created'], 'Y-m-d')?>">

														
														<a class="list-post_enlace" href="<?= $link; ?>">
															<aside class="list-post_image" style="background-image:url(<?= $this->Image->url($post['archive_id'], 'medium'); ?>);">
																<span class="list-post_name fondo2 color0"><?= __($post['name']); ?></span>
															</aside>
														</a>
														
														<aside class="list-post_text">
															<div>
																<h2 class="list-post_title"><?= __($post['name']); ?> <?php if(!empty($beforePrice)) { echo '<span class="color1">'. __($extras['promotion']). '</span>'; } ?></h2> 
																<?php if($precio != 'US$0,00') { ?><span class="list-post_prince"><?= $precio; ?></span><?php } ?>
															</div>

															<aside class="list-post_text_description">
																<font><?= __($extras['date_publish']); ?>: <?= date_format($post['created'], 'Y-m-d'); ?> </font>
																<p><font><?= __($extras['year_maker']); ?>: <?= __($year); ?></font></p>
																<?php /*<span><?= __($extras['description']); ?></span>
																<p class="text"><?= $this->Get->get_excerpt($post['id'], 200); ?></p>*/?>
																
																<div>
																	<strong><?= __($extras['speak_seller']); ?></strong>
																	<div class='list-post_text_ofert'>
																		<?= $this->Html->link(__($extras['more_information']), $link, ['class' => 'btn btn-link fondo1 fondoh3 color3 colorh0']);?> <?= $this->Html->link(__($extras[$btnAvalible]), '#login', ['class' => 'fancybox btn btn-link fondo1 fondoh3 color3 colorh0']);?>
																		<?php if ($authUser) { ?>
																				<?php if($disponible == 'VENTA' || $disponible == 'SELL') { ?>
																				<aside class="aside-ofert">
																						<?= $this->Form->input('ofert', ['label' => false, 'class' => 'input-ofert', 'placeholder' => __($extras['tender_placeholder'])]); ?>

																						<aside class="aside-tender"><?= $this->Form->button(__($extras['tender']), ['label' => false, 'class' => 'btn btn-link fondo1 fondoh3 color3 colorh0']); ?>
																						</aside>
																				</aside>
																				<?php } ?>
																		<?php } ?>
																	</div>

																</div>
																
															</aside>

															<aside class="list-post_data">
																<?php if(!empty($beforePrice)) { ?><font class="list-post_price_before"><?= $antes; ?></font><?php } ?>
																<span class="list-post_avalible"><?= __($disponible); ?></span>
																<div class="list-post_data_map">
																	<a href="#mapa<?= $post->id; ?>" class="fancybox" title="<?= __($extras['location']); ?> <?= $post->name; ?>"><i class="fa fa-map-marker color1 colorh3"></i></a>
																</div>
																<div class="list-post_data_rent">
																	<?php if(!empty($location)) { ?><strong><?= __($extras['location']); ?>: </strong> <font><?= $location; ?></font><?php } ?>
																	<?php if(!empty($city)) { ?><p><strong><?= __($extras['city']); ?>: </strong> <font><?= $city; ?></font></p><?php } ?>
																<div>
															</aside>

															<aside id="mapa<?= $post->id; ?>" class="category_map"><div id='map_canvas' style="width:100%; height:400px;"></div></aside>

															


														</aside>

													</article>
												<?php } ?>

										<div>
								<div>
							<!-- isotope -->

						</content>
					</td>
				</tr>
			</table>
			<!-- fin contenido de la categoria -->

			<!-- paginador -->
			<section class="up-section counter-section fondo5">
                            <div class="wrap">
                                <div class="pagin-count">
                                    <p><?= $this->Paginator->counter(['format' => ''.__($extras['page']).' {{page}} '.__($extras['of']).' {{pages}}, '.__($extras['showing']).' {{current}} '.__($extras['log']).' {{count}}']);?></p>
                                    <nav>
                                        <?= $this->Paginator->prev('');
                                              echo $this->Paginator->numbers(['separator' => ' - ','currentTag' => 'a', 'currentClass' => 'active','tag' => 'li','first' => 1]);
                                              echo $this->Paginator->next(''); ?>
                                    </nav>
                                </div>
                            </div>
			</section>
			<!-- fin paginador -->


	</div>
</section> 


<!-- nuevos arrivos -->
			<section class="up-section counter-section background">
                    <div class="wrap">
                       	<h2 class="title-section"><?= __($extras['new_arrivals']); ?></h2>
                    </div>
					<?= $this->element('Front.destacados');?>
			</section>
<!--fin nuevos arrivos -->


 <script src="http://isotope.metafizzy.co/isotope.pkgd.js"></script>

<script>
// external js: isotope.pkgd.js

$(document).ready( function() {
	  // init Isotope
	  var $grid = $('.grid').isotope({
	    itemSelector: '.element-item',
	    layoutMode: 'fitRows',
	    getSortData: {
	      id: '[data-id] parseFloat',
	      brand: '[data-brand]',
	      year: '[data-year] parseFloat',
	      tons: '[data-tons] parseFloat',
	      created: '[data-created]',
	      city: '[data-city]',

	      weight: function( itemElem ) {
	        var weight = $( itemElem ).find('.weight').text();
	        return parseFloat( weight.replace( /[\(\)]/g, '') );
	      }
	    }
	  });

	  // bind sort button click
	  $('.sort-by-button-group').on( 'click', 'button', function() {
	    var sortValue = $(this).attr('data-sort-value');
	    $grid.isotope({ sortBy: sortValue });
	  });

	  // change is-checked class on buttons
	  $('.button-group').each( function( i, buttonGroup ) {
	    var $buttonGroup = $( buttonGroup );
	    $buttonGroup.on( 'click', 'button', function() {
	      $buttonGroup.find('.is-checked').removeClass('is-checked');
	      $( this ).addClass('is-checked');
	    });
	  });
  
});


	$( ".map_list" ).click(function() {
	  $('#mapa').toggleClass( "completo" );
	  return false;
	});

</script>


<?php /* <script type="text/javascript" src="http://maps.google.com/maps/api/js?key=AIzaSyBAYS9EYLMZbsDLzWpoBkZ82L-ELikGqbw"></script> */ ?>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&language=<?= $lang; ?>"></script>
<script type="text/javascript">
  var delay = 100;
  var infowindow = new google.maps.InfoWindow();
  var mapOptions = {
    zoom: 5,
    mapTypeId: google.maps.MapTypeId.ROADMAP
  }
  var geocoder = new google.maps.Geocoder(); 
  var map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
  var bounds = new google.maps.LatLngBounds();

  function geocodeAddress(address, next, img, href, title) {
    geocoder.geocode({address:address}, function (results,status)
      { 
         if (status == google.maps.GeocoderStatus.OK) {
          var p = results[0].geometry.location;
          var lat=p.lat();
          var lng=p.lng();
          createMarker(address,lat,lng, img, href, title);
        }
        else {
           if (status == google.maps.GeocoderStatus.OVER_QUERY_LIMIT) {
            nextAddress--;
            delay++;
          } else {
                        }   
        }
        next();
      }
    );
  }
 function createMarker(add,lat,lng, img, href, title) {
   var contentString = add;
   var imageContent = img;
   var hrefContent = href;
   var titleContent = title;
   var marker = new google.maps.Marker({
     position: new google.maps.LatLng(lat,lng),
     map: map,
     icon: '/front/img/marker.png',

           });

  google.maps.event.addListener(marker, 'click', function() {
     infowindow.setContent('<aside id="infoMaps"><a href="' +hrefContent + '"><img src="' +imageContent + '" width="170"></a> <h4>' + titleContent + '</h4>' + contentString + '</aside>'); 
     infowindow.open(map,marker);
   });

   bounds.extend(marker.position);

 }
  var locations = [ <?php foreach ($posts as $post) { $address = $this->Get->get_field_by_post_id($post['id'], 'location'); $city = $this->Get->get_field_by_post_id($post['id'], 'city');  echo "\"".$address." - ".$city."\",";  } ?> ];
  var images = [ <?php foreach ($posts as $post) { $image = $this->Image->url($post['archive_id'], 'medium');  echo "\"".$image."\","; } ?> ]
  var hrefs = [ <?php foreach ($posts as $post) { $link = $this->Get->get_link($post['id'], 'Posts');  echo "\"".$link."\","; } ?> ]
  var titles = [ <?php foreach ($posts as $post) { echo "\"".$post->name."\","; } ?> ]

  var nextAddress = 0;
  function theNext() {
    if (nextAddress < locations.length) {
      setTimeout('geocodeAddress("'+locations[nextAddress]+'",theNext, "'+images[nextAddress]+'", "'+hrefs[nextAddress]+'", "'+titles[nextAddress]+'")', delay);
      nextAddress++;
    } else {
      map.fitBounds(bounds);
    }
  }
  theNext();

</script>

