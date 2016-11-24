

<aside id="publicity_directory" class="post-publicity">
	<?php if(isset($publicityDirectory) && !empty($publicityDirectory)) { ?>
	<div id="cycler">
		
		<?php foreach ($publicityDirectory as $key => $image) {
				
				if($key == 0) { $class='active'; } else { $class = ''; } //activa la prima imagen

				if(!empty($image['_joinData']['url'])) { $link = $image['_joinData']['url']; } else { $link = '#'; }

			    	echo $this->Html->link($this->Html->image($this->Image->url($image['id'], 'full'), ["target" => "_blank"]),  $link,   ['escape' => false, "class" => $class, 'target' => '_blank']);
			   	} 

		?>

	</div>
	<?php } ?>
</aside>