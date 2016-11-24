
<script src="http://maps.google.com/maps/api/js?sensor=false&.js"></script>
<?= $this->Html->script('markers'); ?>

  
<script type="text/javascript">

  var myPoints = [ <?php foreach ($posts as $post) { 
                    $address = $this->Get->get_field_by_post_id($post['id'], 'state'); 
                    $city = $this->Get->get_field_by_post_id($post['id'], 'city'); 
                    $country = $this->Get->get_field_by_post_id($post['id'], 'country');
                    $image = $this->Image->url($post['archive_id'], 'medium');
                    $logo = $this->Image->get_image_by_user_id($post->user_id, 'medium');
                    $href = $this->Get->get_link($post['id'], 'Posts');
                    $logolink = '/'.$info['Users'].'/site/'.$post->user_id;

                    echo "['".$country."', '', '', '', '', ''],";  } ?> 
                  ];

    var map = null;
    var markerArray = []; //create a global array to store markers
    var delay = 100;
    var geocoder = new google.maps.Geocoder(); 
    <?php /*var myPoints =  <?php echo json_encode($ar) ?>; //create global array to store points */ ?>

    function initialize() {

        var lat, long;

              //si el usuario dio sus datos de geolocalización
              if(localStorage.longitud) {

                  var lat = localStorage.latitud;
                  var long = localStorage.longitud;

              } else {
              //si no los da dejamos por defecto datos globales
                  var lat = 71.3867745;
                  var long = -66.9502861;

              }

        var myOptions = {
            zoom: 8,
            center: new google.maps.LatLng(lat, long),
            mapTypeControl: true,
            mapTypeControlOptions: {
                style: google.maps.MapTypeControlStyle.DROPDOWN_MENU
            },
            navigationControl: true,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        }
        
        map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);

        var mcOptions = {
            gridSize: 50,
            maxZoom: 15
        };
        var mc = new MarkerClusterer(map, [], mcOptions);

        google.maps.event.addListener(map, 'click', function() {
            infowindow.close();
        });


        function geocodeAddress(address, next, img, href, title, logo, logolink) {
                    
                    geocoder.geocode({address:address}, function (results,status) { 
                        
                        if (status == google.maps.GeocoderStatus.OK) {
                              var p = results[0].geometry.location;
                              var randomNumber =  Math.floor(Math.random() * 500)/800000;

                              var lat=p.lat() + randomNumber;
                              var lng=p.lng();
                              createMarker(address,lat,lng, img, href, title, logo, logolink);
                              mc.addMarkers(markerArray , true);


                        } 

                        else {
          
                            if (status == google.maps.GeocoderStatus.OVER_QUERY_LIMIT) {
          
                            nextAddress--;
                            delay++;
                            
                            } else { }


                        }

                        console.log(status);

                    });

        } 


              // Set up markers based on the number of elements within the myPoints array
              /*var nextAddress = 0;

              for(var i=0; i<myPoints.length; i++){    
                    geocodeAddress(myPoints[i][0], myPoints[i][1], myPoints[i][2], myPoints[i][3], myPoints[i][4], myPoints[i][5]);

              }*/

              var nextAddress = 0;

              function theNext() {
                
                if (nextAddress < myPoints.length) {
                  
                  setTimeout('geocodeAddress("'+myPoints[nextAddress][0]+'",theNext, "'+ myPoints[nextAddress][1]+'", "'+myPoints[nextAddress][2]+'", "'+myPoints[nextAddress][3]+'", "'+myPoints[nextAddress][4]+'", "'+myPoints[nextAddress][5]+'")', delay);
                  nextAddress++;

                  console.log(nextAddress);

                } else {
                  //map.fitBounds(bounds);
                }

              }

              theNext();


    }

    var infowindow = new google.maps.InfoWindow({
        size: new google.maps.Size(150, 50)
    });

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
             zIndex: Math.round(lat * -100000) << 5
        });

       //marker.setAnimation(google.maps.Animation.BOUNCE);

       google.maps.event.addListener(marker, 'click', function() {
         infowindow.setContent('<aside id="infoMaps"><a href="' +hrefContent + '"><img src="' +imageContent + '" width="170"></a> <a href="'+ logoLinkContent +'"><img src="'+ logoContent + '" width="170" /></a> <h4>' + titleContent + '</h4><span style="font-size:11px;">' + contentString + '</span>  <a href="'+ hrefContent +'" class="btn btn-link fondo1 fondoh3 color3 colorh0"><center><?= __($extras["more_information"]); ?></center></a> </aside>'); 
         infowindow.open(map,marker);
       });

      //bounds.extend(marker.position);
      markerArray.push(marker); 

      //console.log(markerArray);

    }




window.onload = initialize;


</script>
