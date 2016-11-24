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



          function geocodeAddress(address, next, img, href, title, logo, logolink) {
            geocoder.geocode({address:address}, function (results,status)
              { 
                 if (status == google.maps.GeocoderStatus.OK) {
                  var p = results[0].geometry.location;
                  var randomNumber =  Math.floor(Math.random() * 500)/800000;

                  var lat=p.lat() + randomNumber;
                  var lng=p.lng();
                  createMarker(address,lat,lng, img, href, title, logo, logolink);
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

           bounds.extend(marker.position);

        }

          var locations = [ <?php foreach ($posts as $post) { $address = $this->Get->get_field_by_post_id($post['id'], 'state'); $city = $this->Get->get_field_by_post_id($post['id'], 'city'); $country = $this->Get->get_field_by_post_id($post['id'], 'country');  echo "\"".$city." - ".$country.", ".$address."\",";  } ?> ];
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
            } else {
              map.fitBounds(bounds);
            }
          }
          theNext();


</script>
