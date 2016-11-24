

<aside class="post-publicity">
	<?php if(isset($publicityUp) && !empty($publicityUp)) { ?>
	<div id="cycler">
		
		<?php foreach ($publicityUp as $key => $image) {
				
				if($key == 0) { $class='active'; } else { $class = ''; } //activa la prima imagen

				if(!empty($image['_joinData']['url'])) { $link = $image['_joinData']['url']; } else { $link = '#'; }

			    	echo $this->Html->link($this->Html->image($this->Image->url($image['id'], 'full'), ["target" => "_blank"]),  $link,   ['escape' => false, "class" => $class, 'target' => '_blank']);
			   	} 

		?>

	</div>
	<?php } ?>
</aside>