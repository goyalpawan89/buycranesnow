
<!DOCTYPE html>
<html class="html_map">
<head>

	<?= $this->Html->charset() ?>
    <meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' /> 

    <meta property="fb:app_id" content="498389210308893" />
    <meta property="og:type" content="article" />
    <meta property="og:site_name" content="<?= $blogName; ?>"/>   
    
    <?php if($this->request->params['controller'] == 'Posts' && $this->request->params['action'] == 'index') { 
             $description = $this->Get->get_excerpt($content->id, 125); $title = $content->name; $image = $this->Image->url($content->archive_id, 'full'); $url = $this->Get->get_url(); 
          } else { 
            $description = $blogDescription; $title = $blogName; $image = $this->Url->build('/', true).$logo; $url = $this->Url->build('/', true); 
          } ?>
    
    <meta name="description" content='<?= $description; ?>'>
    <meta property='og:title' content='<?= $title; ?>' />
    <meta property='og:url' content='<?= $url; ?>' />
    <meta property='og:description' content='<?= $description; ?>' />
    <meta property='og:image' content='<?= $image; ?>' />

    <title><?= $blogName; ?></title>

  <?php

	echo $this->Html->meta('icon', $favicon);


    //echo $this->Html->script('//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.js');   
    echo $this->Html->script('front/jquery-1.7.2.min');   
    echo $this->Html->css('Front.front/elymki', ['media' => 'screen']);

	
	$id = $content->id;
	$address = $this->Get->get_field_by_post_id($id, 'state'); 
	$city = $this->Get->get_field_by_post_id($id, 'city');

?>


<?php foreach($colors as $key => $color) { ?>
  <style type="text/css">
        .color<?=  $key; ?>, .colorh<?=  $key; ?>:hover { color:#<?=  $color; ?>; }
        .fondo<?=  $key; ?>, .fondoh<?=  $key; ?>:hover { background-color:#<?=  $color; ?>; }
        .border<?=  $key; ?>, .borderh<?=  $key; ?>:hover { border-color:#<?=  $color; ?> !important; }       
  </style>
<?php } ?>
  
  <style type="text/css">
    .background { background-color: <?=  $background; ?>; } /* background-principal */
    /* colores personalizados */

    .nav li a:hover, .pagin-count nav a:hover { color:#<?=  $colors[1]; ?>; } 
    .buscador .submit:before, .bx-wrapper .bx-pager.bx-default-pager a:hover, .bx-wrapper .bx-pager.bx-default-pager a.active, .footer_title:before, .slide_info h3:before, .order-table .input-sort:hover, .order-table a:hover, .is-checked, .pagin-count nav a, #example-one ul li a.current 
    { background-color:#<?=  $colors[1]; ?>; } 
    
    .order-table .input-sort, .order-table a, .pagin-count nav a, .users_table-item th a, #example-one ul li.post-tab a.current, #infoMaps span a, .content-side_description_text font a, a[href^="mailto"] { color:#<?=  $colors[2]; ?>; }

    .buscador .submit:hover :before, .bx-wrapper .bx-pager.bx-default-pager a, .pagin-count nav a:hover, .formulario div  { background-color:#<?=  $colors[2]; ?>; }

    a.btn { text-align: center; margin:5px 0; }

    

  </style>

</head>

<body class="body_maps" style="width:100%;">

<div id="maps" class="map"></div>

<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&language=<?= $lang; ?>"></script>
<script type="text/javascript">	
//google maps
  var delay = 0;
  var infowindow = new google.maps.InfoWindow();
  var mapOptions = {
    zoom: 16,
    mapTypeId: google.maps.MapTypeId.ROADMAP
  };
  
  var geocoder = new google.maps.Geocoder(); 
  var map = new google.maps.Map(document.getElementById("maps"), mapOptions);
  	  $(window).load(function() { 
  	  		map.setZoom(16);
  	  });
  var bounds = new google.maps.LatLngBounds();

function geocodeAddress(address, next, img, href, title, logo, logoLink) {
    geocoder.geocode({address:address}, function (results,status)
      { 
         if (status == google.maps.GeocoderStatus.OK) {
          var p = results[0].geometry.location;
          var lat=p.lat();
          var lng=p.lng();
          createMarker(address,lat,lng, img, href, title, logo, logoLink);
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

function createMarker(add,lat,lng, img, href, title, logo, logoLink) {
   var contentString = add;
   var imageContent = img;
   var hrefContent = href;
   var titleContent = title;
   var logoContent = logo;
   var logoLinkContent = logoLink;
   var marker = new google.maps.Marker({
     position: new google.maps.LatLng(lat,lng),
     map: map,
     icon: '/front/img/marker.png',
           });

  google.maps.event.addListener(marker, 'click', function() {
     infowindow.setContent('<aside id="infoMaps"><a href="' +hrefContent + '"><img src="' +imageContent + '" width="170"></a> <a href="' + logoLinkContent + '"><img src="' + logoContent + '" width="170"></a> <h4>' + titleContent + '</h4>' + contentString + ' <a href="'+ hrefContent +'" class="btn btn-link fondo1 fondoh3 color3 colorh0"><?= __($extras["more_information"]); ?></a> </aside>'); 
     infowindow.open(map,marker);
   });

   bounds.extend(marker.position);

 }
  var locations = [ <?= "\"".$address." - ".$city."\",";  ?> ];
  var images = [ <?php $image = $this->Image->url($content->archive_id, 'medium'); echo "\"".$image."\",";  ?> ]
  var hrefs = [ <?php $link = $this->Get->get_link($content->id, 'Posts'); echo "\"".$link."\",";  ?> ]
  var titles = [ <?= "\"".$content->name."\","; ?> ]
  var logo = [ <?= "\"".$this->Image->get_image_by_user_id($content->user['id'], 'medium')."\","; ?> ]
  var logoLinks = [ <?php $userLink = '/'.$info['Users'].'/site/'.$content->user['id'];  echo "\"".$userLink."\",";  ?> ]


  var nextAddress = 0;
  function theNext() {
    if (nextAddress < locations.length) {
      setTimeout('geocodeAddress("'+locations[nextAddress]+'",theNext, "'+images[nextAddress]+'", "'+hrefs[nextAddress]+'", "'+titles[nextAddress]+'", "'+logo[nextAddress]+'", "'+logoLinks[nextAddress]+'")', delay);
      nextAddress++;
    } else {
      map.fitBounds(bounds);
    }
  }

theNext();


</script>


</script>

</html>