
<?php 
      //link para los usuarios
      $userLink = $this->Get->get_route_link('Users');

?>

<!-- contenido principal -->
<section class="content background">
	<div class="wrap wrap-user_profile">

      <!-- publicidad superuir -->
      <?= $this->element('Front.publicity_directory'); ?>

      </br>

			<aside id="mapa"><div id='map_canvas' style="width:100%; height:400px;"></div></aside>
			
			<!-- up section -->
			<article class="directory-description table">
				  <div class="table-cell">
              <h1><?= __($extras['business_directory']); ?></h1>
				      <p><?= __($extras['business_directory_description']); ?></p>
          </div>

          <div class="directory_search table-cell">
            
            <?php $datos = ['company' => ['label' => false, 'placeholder' => __($extras['search_company']), 'input'], 
                            __($extras['search']) => ['id' => 'Buscar', 'label' => false, 'type' => 'submit', 'class' => 'submit fondoh1 colorh3', 'value' => __($extras['search_submit']) ], 
                          ]; 

                      echo $this->Form->create('Users', ['url' => ['controller' => 'Users', 'action' => 'index'], 'type' => 'get', 'class' => 'search_company']);
                      
                              foreach ($datos as $name => $options) {
                                     echo $this->Form->input($name, $options);
                              } 
                      
                      echo $this->Form->end(); ?>

          </div>
			</article>		
			<!-- up section -->

			
			<content class="bussines_table">
						

					<article class="users_table-item">
						<table width="100%">
              
              <tr class="fondo1">
                  <?php $titles = ['image' => $extras['image'], 
                           'company_name' => $extras['company_responsible'], 
                           //'company_continent' => $extras['continent'], 
                           'company_country' => $extras['country'], 
                           'company_state' => $extras['state'], 
                           'company_city' => $extras['city'], 
                           'company_tel' => $extras['phone'], //para que no aparezca la palabra indicativo en extras['company_tel']
                           'industry_type' => $extras['industry_type_label'], 
                           //'actions' => $extras['actions'], 
                           ]; 

                    foreach ($titles as $key => $title) { ?>
                      <th><?php echo $this->Paginator->sort($key, __($title)); ?></th>
                  <?php } ?>
                </tr>

                <?php foreach ($users as $user) {
                      if(empty($user->archive_id)) { $image = ''; } else { $image = $this->Image->url($user->archive_id, 'medium'); }
                          if($authUser) { $urlUser = ['controller' => 'Users', 'action' => 'site', $user->id]; $fancy = 'color2 tooltip'; } else { $urlUser = '#login'; $fancy = 'fancybox color2'; } 

                      $country = $this->Get->get_company_country($user->id);

            //aparecerá en el directorio si minimo tiene el nombre de la compañia generado ?>

							<tr>
								<td><?php if(!empty($user->archive_id)) { echo $this->Html->link($this->Html->image($image, ['class' => 'bussines_image']), $urlUser, ['class' => $fancy, 'escape' => false, 'title' => __($extras['more_information'])]); } ?></td>
								<td><span class="<?= $user->type; ?>"><?= $this->Html->link(__($this->Get->get_company_name($user->id)), $urlUser, ['class' => $fancy, 'title' => __($extras['company']). ': '. $user->type  ]); ?></span></td>
                <?php /*<td><?= $user['countries']['continent']; ?></td> */ ?>
                <td><?= $user['company_country']; ?></td>
                <td><span><?= __($user->company_state); ?></span></td>
                <td><span><?= $user['company_city']; ?></span></td>
								<td><span><?= __($this->Get->get_company_tel($user->id)); ?></span></td>
								<td><span><?php if(isset($user->industry_type) && !empty($user->industry_type)) { echo __($extras[$user->industry_type]); } ?></span></td>
								<!--<td><span><?= $this->Html->link(__($extras['contact_company']), $urlUser, ['class' => $fancy.' btn btn-link fondo1 fondoh3 color3 colorh0']); ?></span></td> -->
							</tr>

              <?php } ?>

						</table>
					</article>


			</content>
	
	</div>
</section>

			<!-- paginador -->
			<?= $this->element('Front.paginator_end'); ?>
			<!-- fin paginador <--></-->



<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&language=<?= $lang; ?>"></script>
<script type="text/javascript">
  var delay = 100;
  var infowindow = new google.maps.InfoWindow();
  var mapOptions = {
    zoom: 7,
    mapTypeId: google.maps.MapTypeId.ROADMAP,
  }

  var geocoder = new google.maps.Geocoder(); 
  var map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
  var bounds = new google.maps.LatLngBounds();

  //USO DEL localStorage PARA GUARDAR LA VARIABLE DE MI UBICACIÓN ACTUAL
  if(localStorage.latitud) {

			$(window).load(function() { 
			    initialLocation = new google.maps.LatLng(localStorage.latitud, localStorage.longitud);
			    map.setCenter(initialLocation);
          map.setZoom(7);
			});

				  
  } else {

			//geolocalización (compartir el lugar del cliente para centrar el mapa donde debe)
			if (navigator.geolocation) {
					     navigator.geolocation.getCurrentPosition(function (position) {
					         initialLocation = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
					         map.setCenter(initialLocation); //centrar el mapa en dependiendo de la geolocalozación
					         localStorage.latitud = position.coords.latitude; //guardar la variable en el localStorage
					         localStorage.longitud = position.coords.longitude; //guardar la variable en el localStorage
                   map.setZoom(7);

					});
			}

  }




  function geocodeAddress(address, next, img, href, title) {
    geocoder.geocode({address:address}, function (results,status)
      { 
         if (status == google.maps.GeocoderStatus.OK) {
          var p = results[0].geometry.location;
          var randomNumber =  Math.floor(Math.random() * 500)/800000;

          var lat=p.lat() + randomNumber;
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
	           });

  google.maps.event.addListener(marker, 'click', function() {
     infowindow.setContent('<aside id="infoMaps"><a <?php if(isset($userRole) && $userRole > 3) { ?> href="' +hrefContent + '" <?php } ?>><img src="' +imageContent + '" width="170"></a> <h4>' + titleContent + '</h4>' + contentString + '  <a <?php if(isset($userRole) && $userRole > 3) { ?> href="' +hrefContent + '" <?php } ?> class="btn btn-link fondo1 fondoh3 color3 colorh0"><?= __($extras["more_information"]); ?></a> </aside>'); 
     infowindow.open(map,marker);
   });

   bounds.extend(marker.position);

}

  var locations = [ <?php foreach ($users as $user) { $country = $user['company_country']; $state = $user['company_state'];  echo "\"".$country." - ".$state."\",";  } ?> ];
  var images = [ <?php foreach ($users as $user) { $image = $this->Image->url($user['archive_id'], 'medium');  echo "\"".$image."\","; } ?> ];
  var hrefs = [ <?php foreach ($users as $user) { if($authUser) { $link = '/'.$info['Users'].'/site/'.$user['id']; } else { $link = ''; } echo "\"".$link."\","; } ?> ];
  var titles = [ <?php foreach ($users as $user) { echo "\"".$user->company_name."\","; } ?> ];

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

 
//circulo de referencia de cercania de acuerdo a mi posicion
 function drawCircle(point, radius, dir) { 
  var d2r = Math.PI / 120;   // degrees to radians 
  var r2d = 120 / Math.PI;   // radians to degrees 
  var earthsradius = 3963; // 3963 is the radius of the earth in miles

  var points = 32; 

  // find the raidus in lat/lon 
  var rlat = (radius / earthsradius) * r2d; 
  var rlng = rlat / Math.cos(point.lat() * d2r); 

  var extp = new Array(); 
  if (dir==1) {
     var start=0;
     var end=points+1; // one extra here makes sure we connect the path
  } else {
     var start=points+1;
     var end=0;
  }
  for (var i=start; (dir==1 ? i < end : i > end); i=i+dir)  
  { 
     var theta = Math.PI * (i / (points/2)); 
     ey = point.lng() + (rlng * Math.cos(theta)); // center a + radius x * cos(theta) 
     ex = point.lat() + (rlat * Math.sin(theta)); // center b + radius y * sin(theta) 
     extp.push(new google.maps.LatLng(ex, ey)); 
  } 
  return extp;
}

if(localStorage.latitud) {

    $(window).load(function() { 

          var circle = new google.maps.Polygon({
                         map: map,
                         paths: [drawCircle(new google.maps.LatLng(localStorage.latitud, localStorage.longitud), 100, 1)],
                         strokeOpacity: 0.5,
                         strokeWeight: 1,
                         fillColor: "#000000",
                         fillOpacity: 0.35
          });
    });
}

<?php /*
  //autocompletar tipo de industria
 $(document).ready(function() {

                        //input de países
                          $("#company").autocomplete({
                              source: [ <?php foreach ($industryType as $type) { echo "\"".$type."\","; } ?> <?php foreach ($countryNames as $country) { echo "\"".$country."\","; } ?>  ],
                              minLength: 3
                          });

  });
*/ ?>


<?php if($userRole == 3) { ?>

  $('.bussines_table a, #infoMaps a').removeAttr('href');

<?php } ?>

</script>

