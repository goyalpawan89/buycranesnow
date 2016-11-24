
<?php if(isset($publicityUser) && !empty($publicityUser)) { 
      if(!empty($publicityUser['_joinData']['url'])) { $link = $publicityUser['_joinData']['url']; } else { $link = '#'; } ?>

			<?= $this->Html->link($this->Html->image($this->Image->url($publicityUser['id'], 'full'), ["class" => "publish", "target" => "_blank"]),  $link,   ['escape' => false]); ?>

<?php } ?>