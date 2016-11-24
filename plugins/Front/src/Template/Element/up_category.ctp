			

			<!-- descripcion de la categoria -->
			<article class="category-description description">
				<h1><?= $content->name; ?></h1>
				<?= $content->description; ?>
			</article>
			
			<aside class="list-description table">	
				<?php $descriCons = ['crane_thumbs' => 'index', 'crane_list' => 'crane_list', 'crane_photos'  => 'crane_photos', 'map_list' => ''];
				      foreach ($descriCons as $key => $link) { ?>
				      	
				      	<aside class="list-description_item table-cell">
							<?php if($key == 'map_list') { ?><span class="my_ubication"></span><?php } ?>
							<?= $this->Html->link(__($extras[$key]), '#', ['class' => $key.' color3', 'data-sort-value' => $key ]); ?>
				      	</aside>

                <?php } ?>
			</aside>
			<!-- fin descripcion de la categoria -->
				
			<div id="mapa"><div id='map_canvas' style="width:100%; height:400px;"></div></div>


<script type="text/javascript">


$(document).ready(function(){
	//attach a jQuery live event to the button
	if(localStorage.ciudad) {

		$('.my_ubication').html('<b><?= __($extras["you_are_in"]); ?>:</b> ' + localStorage.pais + ' - ' + localStorage.ciudad + '  ');

	} else {

		$.getJSON('http://ip-api.com/json', function(data) {
			$('.my_ubication').html('<b><?= __($extras["you_are_in"]); ?>:</b> ' + data.country + ' - ' + data.city + ' ');
			localStorage.ciudad = data.city;
			localStorage.pais = data.country;

			localStorage.latitud = data.lat;
			localStorage.longitud = data.lon;

		});
	}
	
});

$(window).load( function() {

					$('.map_list').addClass('btn btn-link fondo1 fondoh3 colorh1');

});

</script>
