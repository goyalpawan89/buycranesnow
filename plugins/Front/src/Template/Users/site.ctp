<?php 
	// camops personalizados del post
	
	$empresa_id = 2;

    $addressUser = $user->company_state; 
    $typeUser = $user->type; 
    $cityUser = $user->company_city;
    $countryUser = $user->company_city;
		if($user->id == 3) { $email = ''; } else { $email = $user->company_email; }
	

	if(!empty($user->archive_id)) { $logo = $this->Image->url($user->archive_id, 'full'); } else { $logo = $this->Url->build('/', true).$logo; } // logo de solo gruas si no hay imagen o logo del usuario (empresa)
	if(!empty($user->company_city)) { $name = $user->company_name; } else { $name = $user->name; } // logo de solo gruas si no hay imagen o logo del usuario (empresa)

?>

<section class="content background">
	<div class="wrap">

<!-- contenido principal -->

			<!-- publicidad superuir -->
			<?= $this->element('Front.publicity_up'); ?>

			<!-- descripcion superior -->
			<article class="category-description description">
				<table class="post-user_description">
					<tr> 
						<td>
							<aside class='post-user_img'>
                  <?= $this->Html->image($logo, ['alt' => $blogName]); ?>

                  <span class="star-rating">
                      <?php for ($a=1; $a <=5; $a++) { // hay que hacerlos manuales, con el helper Form no funciona.
                            if($a == $stars) { $check = 'checked="checked"'; } else { $check = NULL; } ?>
                          <input type="radio" name="ranking" class="stars" value="<?= $a; ?>" <?= $check; ?> ><i></i>
                      <?php } ?>
                  </span>
                  <br>
                
              </aside>
                                   

							<div class="post-user_text">
								<span class="post-user_text_title"><?= $name; ?></span>																
								<div>
  									<p>
  									   <span class="post-user_text_dir"><?php if(!empty($addressUser)) { echo $addressUser.", "; } if(!empty($cityUser)) { echo $cityUser." - "; } if(!empty($countryUser)) { echo $countryUser; } ?></span> 
  									</p>
  									<?php if(!empty($email)) { ?><p><b><?= $extras['email']; ?></b> <?= $this->Text->autoLinkEmails($email); ?></p><?php } 
                          if($typeUser == 'Premium') { echo $this->Html->image('premium.png', ['alt' => $blogName, 'fullBase' => true, 'class' => 'tag_premium tooltip', 'title' => __($extras['company']). ': '. $user->type ]); }  ?>
  								</div>
							</div>
						</td>
						<td>
							
							<div class="post-user_contact">
							
								<?php if(empty($this->request->pass[0]) || $authUser['id'] == $this->request->pass[0]) {

									echo $this->Form->create($user, array( 'id'=>'profile', 'class' => 'general_form', 'enctype' => 'multipart/form-data')); ?>
									
									<li class="post-user_contact_list">
										<?= $this->Html->link(__($extras['my_favorites']), ['controller' => 'Posts', 'action' => 'my_favorites'], ['class' => 'post-user_contact_list_item before-list_item favorite color3 colorh1 fondoh3']); ?>
									</li>
									<li class="post-user_contact_list">
										<?php if($user->role_id <= $empresa_id) { 
												echo $this->Html->link(__($extras['profile']), ['controller' => 'Users', 'action' => 'profile'], ['class' => 'post-user_contact_list_item before-list_item my_profile color3 colorh1 fondoh3']); 
											  } else { 
											  	echo $this->Form->button(__($extras['update_bussines_user']), ['label' => false, 'name' => 'role_id', 'value' => 2, 'type' => 'submit', 'class' => 'post-user_contact_list_item before-list_item color3 colorh1 fondoh3']); 
											  } ?>
									</li>
									<li class="post-user_contact_list">
										<?= $this->Html->link(__($extras['post_crane']), '/admin/posts/add', [ 'class' => 'post-user_contact_list_item before-list_item post_crane color3 colorh1 fondoh3', 'target' => '_blank']); ?>
									</li>
									<li class="post-user_contact_list">
										<?= $this->Html->link(__($extras['my_offers']), ['controller' => 'Users', 'action' => 'my_offers'], ['class' => 'btn btn-sell my_offers fondo1 fondoh3 color3 colorh0']); ?>									
									</li>

								<?= $this->Form->end(); 

									} else { ?>
									
									<li class="post-user_contact_list"><?= $this->Html->link(__($extras['profile']), ['controller' => 'Users', 'action' => 'profile'], ['class' => 'post-user_contact_list_item before-list_item my_profile color3 colorh1 fondoh3']); ?></li>
									<li class="post-user_contact_list"><?= $this->Html->link(__($extras['contact_us']), '#user-info', ['class' => 'fancybox btn btn-sell fondo1 color3 fondoh3 colorh0']); ?></li>

								<?php } ?>
							
							</div>

						</td>
					</tr>					
				</table>
			</article>
			


		
			<div class="content-side_gallery" style="min-height: inherit;">
        <br>
        <aside id="mapa"><div id='map_canvas'></div></aside>
      </div>


      <!-- descripcion y campos personalizados -->
        <aside class="content-side_description description_site user_description_site">

          <div class="content-side_description_bloque">
            <h1 class="fondo1 content-side_description_title"><?= __($extras['description']); ?></h1>
            <div class="content-side_description_text description_user">
              <?= $user->description; ?>
            </div>
            
            <aside class="all_fields">
              <h1 class="fondo2 color0 content-side_description_title details"><?= __($extras['user_data']); ?></h1>

                  <?php foreach ($userData as $name => $data) { 

                      if($user->id == 3 && $name == 'email') { $data = '';  } else { $data = $data; }

                          if(!empty($data)) { ?>
                          
                              <div class="content-side_description_text fields">
                                <b><?= __($extras[$name]); ?>: </b> 

                                <?php if($name == 'tel') { ?>
                                      <font><?php if(!empty($user->company_code_tel)) { echo $user->company_code_tel." "; } if(!empty($user->company_area_tel)) { echo $user->company_area_tel." "; } if(!empty($user->company_tel)) { echo $user->company_tel; } ?></font>
                                <?php } else { ?>
                                      <font><?= $this->Text->autoLinkEmails($data); ?></font>
                                <?php } ?>
                              </div>

                  <?php } } ?>

            </aside>


          </div>

        </aside>
        <!-- descripcion y campos personalizados -->


      </br>

		
		<?php if(!empty($posts)) { // VALIDAR SI HAY POR LO MENOS 1 POSTS  ?>
                
                <content class="content-table_content">


                      <!-- tipos de vistas para las gruas -->

                        <aside id="view_layout" class="list-description">  
                            <?php $descriCons = ['crane_thumbs' => 'index', 'crane_list' => 'crane_list', 'crane_photos'  => 'crane_photos'];
                                  foreach ($descriCons as $key => $link) { ?>
                                    
                                    <aside class="list-description_item table-cell">
                                        <?= $this->Html->link(__($extras[$key]), '#', ['class' => $key.' color3', 'data-sort-value' => $key ]); ?>
                                    </aside>

                                    <?php } ?>
                        </aside>
                        
                        <!-- filtros -->
                            
                                <?= $this->element('Front.post_info');?>

                      <!-- isotope -->

                </content>
        
    <?php } // VALIDAR SI HAY POR LO MENOS 1 POSTS  ?>

	</div>
</section>
<!-- end section tabs and map -->


<!-- fancybox sections -->
<section class="post-user_info" id="user-info">	
	<h2 class="fondo1 content-side_description_title"><?= __($extras['user_data']); ?></h2>

	<?php foreach ($userData as $name => $data) { 
			if(!empty($data)) { ?>
	<div class="content-side_description_text fields">
		<b><?= __($extras[$name]); ?>: </b> <font><?= $this->Text->autoLinkEmails($data); ?></font>
	</div>
	<?php } } ?>
</section>
<!-- fin fancybox sections -->



<?= $this->Html->script('Front.tabs/organictabs.jquery'); // tabs ?>
<script type="text/javascript">
    //organic tabs
    //
    $(function() {
        $("#example-one").organicTabs();
    });

    //abrir más datos de la última grua
    $( ".more_field" ).click(function() {
	  $('.all_fields').toggleClass( "completo" );
	});


    //calificaciones
$(".stars").click(

  
    function(event) {
      $.post( 
          "<?= $this->Url->build('/', true);?>ranking",
          { id: "<?= $id;?>", value: ''+ $(this).val() +'', user: "<?= $authUser['id'];?>" }, 
          function(data) {
             $('#stage').html(data);
             console.log('almacenado');
          }
      );
      console.log($(this).val());
});



</script>



<?php /* <script type="text/javascript" src="http://maps.google.com/maps/api/js?key=AIzaSyBAYS9EYLMZbsDLzWpoBkZ82L-ELikGqbw"></script> */ ?>
<script type="text/javascript" src="https://maps.google.com/maps/api/js?sensor=false&language=<?= $lang; ?>"></script>
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


/**************/

var geocoderUser = new google.maps.Geocoder(); 
    geocoderUser.geocode({
        address : '<?= $addressUser; ?> - <?= $cityUser; ?> ', 
        region: 'no' 
      },
        function(results, status) {
          if (status.toLowerCase() == 'ok') {
          // Get center
          var userCords = new google.maps.LatLng(
            results[0]['geometry']['location'].lat(),
            results[0]['geometry']['location'].lng()
          );
          
          //alert('Latitute: ' + userCords.lat() + '    Longitude: ' + userCords.lng() );

          $(window).load(function() { 
             
              initialLocation = new google.maps.LatLng(userCords.lat(), userCords.lng());
              map.setCenter(initialLocation);
              //map.setZoom(7);

          });

 
          }
      }
    );

/**************/


  function geocodeAddress(address, next, img, href, title, type) {
    geocoder.geocode({address:address}, function (results,status)
      { 
         if (status == google.maps.GeocoderStatus.OK) {
          var p = results[0].geometry.location;
          var lat=p.lat();
          var lng=p.lng();
          createMarker(address,lat,lng, img, href, title, type);
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
 function createMarker(add,lat,lng, img, href, title, type) {
   var contentString = add;
   var imageContent = img;
   var hrefContent = href;
   var titleContent = title;
   var typeContent = type;

   if(typeContent == 'user') { var icono = '';  } else { var icono = '/front/img/marker.png';  }

   var marker = new google.maps.Marker({
                   position: new google.maps.LatLng(lat,lng),
                   map: map,
                   icon: icono,
           });


     var divInfo = '<aside id="infoMaps"><a href="' +hrefContent + '"><img src="' +imageContent + '" width="170"></a> <h4>' + titleContent + '</h4>' + contentString + '</aside>';

      google.maps.event.addListener(marker, 'click', function() {
         infowindow.setContent(divInfo); 
         infowindow.open(map,marker);
      });

      if(typeContent == 'user') {
          infowindow.setContent(divInfo);
          infowindow.open(map,marker);
      }

   bounds.extend(marker.position);

 }

  var locations = [ <?=  "\"".$addressUser." - ".$cityUser."\","; ?> <?php foreach ($posts as $post) { $state = $this->Get->get_field_by_post_id($post['id'], 'state'); $city1 = $this->Get->get_field_by_post_id($post['id'], 'city');  echo "\"".$state." - ".$city1."\",";  } ?> ];
  var images = [ <?= "\"".$logo."\",";  ?> <?php foreach ($posts as $post) { $image = $this->Image->url($post['archive_id'], 'medium');  echo "\"".$image."\","; } ?> ]
  var hrefs = [ "",  <?php foreach ($posts as $post) { $link = $this->Get->get_link($post['id'], 'Posts');  echo "\"".$link."\","; } ?> ]
  var titles = [ <?= "\"".$user->company_name."\","; ?> <?php foreach ($posts as $post) { echo "\"".$this->Get->get_company_name($post->user_id)." - ".$post->name."\","; } ?> ]
  var types = [ 'user', <?php foreach ($posts as $post) { echo "\"posts\",";  } ?> ];

  var nextAddress = 0;
  function theNext() {
    if (nextAddress < locations.length) {
      setTimeout('geocodeAddress("'+locations[nextAddress]+'",theNext, "'+images[nextAddress]+'", "'+hrefs[nextAddress]+'", "'+titles[nextAddress]+'", "'+types[nextAddress]+'")', delay);
      nextAddress++;
    } else {
      map.fitBounds(bounds);
    }
  }
  theNext();

</script>

