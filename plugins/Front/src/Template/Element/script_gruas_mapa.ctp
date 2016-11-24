
<?php echo $this->Html->script('http://maps.google.com/maps/api/js?key=AIzaSyCCgFqBWasG_SmdBjd93zNpPg5ee5T_iwY&language='.$lang);
      echo $this->Html->script('markers'); ?>

<script type="text/javascript">
  
  var delay = 50;
  var markerArray = []; //create a global array to store markers
  var infowindow = new google.maps.InfoWindow();
  var mapOptions = {
                      zoom: 6,
                      mapTypeId: google.maps.MapTypeId.ROADMAP,
                   }

  var geocoder = new google.maps.Geocoder(); 
  var map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);

  //opciones que llamamos desde el marchivo makers.js para que formando cuadros o grillas organicemos en conjuntos las grúas cercanas
  var mcOptions = { gridSize: 50, maxZoom: 18 }; // tamaño de la cuadricula y el zoom que acepta más zoom más profundo se puede ver el conjunto
  var mc = new MarkerClusterer(map, [], mcOptions); 

          //USO DEL localStorage PARA GUARDAR LA VARIABLE DE MI UBICACIÓN ACTUAL
          var lat, long;
          //si el usuario dio sus datos de geolocalización
          if(localStorage.longitud) {
              //localización actual
              var lat = localStorage.latitud;
              var long = localStorage.longitud;

          } else {
              //si no los da dejamos por defecto datos globales (EU)
              var lat = 37.09024;
              var long = -95.712891;

          }

          //iniciamos la geolocalización ya sea por localstorage o la fija q dejamos (datos de EU como valor de localización por default)
          initialLocation = new google.maps.LatLng(lat, long);
          map.setCenter(initialLocation);

  //funcion de ubicación de gruas por dirección (ciudad estado pais etc)
  function geocodeAddress(address, next, img, href, title, logo, logolink) {
      geocoder.geocode({address:address}, function (results,status) { 
               if (status == google.maps.GeocoderStatus.OK) {
              
                    var p = results[0].geometry.location;
                    var randomLat =  Math.floor(Math.random() * 500)/79673;
                    var randomNLong =  Math.floor(Math.random() * 500)/70673;
                    var lat=p.lat() + randomLat;
                    var lng=p.lng() + randomNLong;
                    createMarker(address,lat,lng, img, href, title, logo, logolink);
              
              } else {
                
                  if (status == google.maps.GeocoderStatus.OVER_QUERY_LIMIT) {
                    nextAddress--;
                    delay++;
                  }

              }
              
              next();
              //creamos con el array ya mezclado los grupos de acuerdo a su ubicación cercana
              mc.addMarkers(markerArray , true);
      });
  }

//creador de los makers
function createMarker(add,lat,lng, img, href, title, logo, logolink) {
   var contentString = add;
   var imageContent = img;
   var hrefContent = href;
   var titleContent = title;
   var logoContent = logo;
   var logoLinkContent = logolink;
   var marker = new google.maps.Marker({
           position: new google.maps.LatLng(lat,lng),
           map: map,
           icon: '<?= $this->Url->build('/', true); ?>/img/marker.png',
       });

    google.maps.event.addListener(marker, 'click', function() {
       infowindow.setContent('<aside id="infoMaps"><a href="' +hrefContent + '"><img src="' +imageContent + '" width="170"></a> <a href="'+ logoLinkContent +'"><img src="'+ logoContent + '" width="170" /></a> <h4>' + titleContent + '</h4><span style="font-size:11px;">' + contentString + '</span>  <a href="'+ hrefContent +'" class="btn btn-link fondo1 fondoh3 color3 colorh0"><center><?= __($extras["more_information"]); ?></center></a> </aside>'); 
       infowindow.open(map,marker);
    });

    markerArray.push(marker); 

}

  var locations = [ <?php foreach ($posts as $post) { $state = $this->Get->get_field_by_post_id($post['id'],'state'); $city = $this->Get->get_field_by_post_id($post['id'], 'city'); $country = $this->Get->get_field_by_post_id($post['id'], 'country');  echo "\"".$country." - ".$city.", ".$state."\","; } ?> ];
  var images = [ <?php foreach ($posts as $post) { $image = $this->Image->url($post['archive_id'], 'medium');  echo "\"".$image."\","; } ?> ];
  var hrefs = [ <?php foreach ($posts as $post) { $link = $this->Get->get_link($post['id'], 'Posts');  echo "\"".$link."\","; } ?> ];
  var titles = [ <?php foreach ($posts as $post) { echo "\"".$post->name."\","; } ?> ];
  var logos = [ <?php foreach ($posts as $post) { $logo = $this->Image->get_image_by_user_id($post->user_id, 'medium');  echo "\"".$logo."\","; } ?> ];
  var logosLinks = [ <?php foreach ($posts as $post) { $userLink = '/'.$info['Users'].'/site/'.$post->user_id;  echo "\"".$userLink."\","; } ?> ];

  var nextAddress = 0;

  function theNext() {
      if (nextAddress < locations.length) {
          setTimeout('geocodeAddress("'+locations[nextAddress]+'",theNext, "'+images[nextAddress]+'", "'+hrefs[nextAddress]+'", "'+titles[nextAddress]+'", "'+logos[nextAddress]+'", "'+logosLinks[nextAddress]+'")', delay);
          nextAddress++;
      } 
  }
  
  theNext();
  
  
</script>
