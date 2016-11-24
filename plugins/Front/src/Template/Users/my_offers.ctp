
<!-- contenido principal -->
<section class="content background">
	<div class="wrap wrap-user_profile">

			<aside class="post-publicity"><?php echo $this->Html->link($this->Html->image('publicidad.png', ["class" => "", "alt" => ""]),  "#",   ['escape' => false]); ?></aside>
			
			<!-- up section -->
			<article class="category-description description">
				<h1><?= __($extras['my_offers']); ?></h1>
				<p><?= __($extras['my_offers_description']); ?></p>
			</article>		
			<!-- up section -->

			<content class="bussines_table">
						
				<!-- Organic Tabs (Example One) -->
				<div id="example-one" class="site-tabs my_offerts_tabs">

						        	<ul class="nav">
						        		
						        		<?php $list = ['for_sell' => 'sell', 'for_rent' => 'rent'];
						        		$a=0; foreach ($list as $key => $item) { ?>
						                	<li class="nav-one"><a href="#<?php echo $key; ?>" class="<?php if($a==0) { echo 'current'; } ?> color3 fondoh1 colorh4"><?php echo $extras[$key]; ?></a></li>
						                <?php $a++; } ?>

						            </ul>
									
									<div class="list-wrap">
									<?php $a=0; foreach ($list as $key => $item) { ?>
	        		 				<ul id="<?php echo $key; ?>" class="<?php if($a!=0) { echo 'hide'; } ?>">

											<article class="users_table-item fondo1">
												<table width="100%">
													<tr>
														<?php 

															if($item == 'rent') {
															  $titles = ['image' => $extras['image'], 
																		 'name' => $extras['name'], 
																		 'price' => $extras['price'], 
																		 'type' => $extras['avalible'], 
																		 'date_start' => $extras['since'], 
																		 'date_end' => $extras['until'], 
																		 'status' => $extras['status'], 
																		 'send_email' => $extras['send_email'], 
																		 ]; 
															} else {

																$titles = [ 'image' => $extras['image'], 
																		    'name' => $extras['name'], 
																		    'price' => $extras['price'], 
																		    'value' => $extras['my_offer'], 
																		    'type' => $extras['avalible'], 
																			'status' => $extras['status'], 
																		 	'send_email' => $extras['send_email'], 
																			 ];

															}

															foreach ($titles as $key => $title) { ?>
																<th><?php echo $this->Paginator->sort($key, __($title)); ?></th>
														<?php } ?>
													</tr>
												</table>
											</article>

											<?php foreach ($posts as $post) {												  
												  $image = $this->Image->get_thumbnail_by_id($post->post_id, 'medium');
												  $link = $this->Get->get_link($post->post_id, 'Posts');
												  $name = $this->Get->get_name($post->post_id, 'Posts');
												  $avalible = $this->Get->get_field_by_post_id($post->post_id, 'avalible');
							   				  	  $price = $this->Get->get_field_by_post_id($post->post_id, 'price');
							   				  	  $precio = $this->Number->currency($price, $info['currency']); 
							   				  	  $status = $post->status; 
							   				  	  $offert = $post->value; 
							   				  	  $since = $post->date_start; 
							   				  	  $until = $post->date_end; 
							   				  	  $oferta = $this->Number->currency($offert, $info['currency']); 
							   				  	  $email = 'mailto:'.$this->Get->get_company_email($post->author_id);

												  if($avalible == $item) {

										    ?>

															<article class="users_table-item">
																<table width="100%">
																	<tr class="fondo0">
																		<td><?= $this->Html->link($this->Html->image($image, ['class' => 'bussines_image']), $link, ['class' => '', 'escape' => false]); ?></td>
																		<td><?= $this->Html->link($name, $link, ['class' => 'color2 colorh3']); ?></td>
																		<td><span><?= $precio; ?></span></td>
																		<?php if(!empty($offert)) { ?><td><span><?= $oferta; ?></span></td><?php } ?>
																		<td><span><?= __($avalible); ?></span></td>
																		<?php if(!empty($since)) { ?><td><span><?= $since; ?></span></td><?php } ?>
																		<?php if(!empty($until)) { ?><td><span><?= $until; ?></span></td><?php } ?>
																		<td><span><?= __($extras[$status]); ?></span></td>
																		<td><span><?= $this->Html->link($extras['send_email'], $email, ['class' => 'color2 colorh3']); ?></span></td>
																	</tr>
																</table>
															</article>

											<?php } } ?>
										
										</ul>
										<?php $a++; } ?>
				</div> <!-- END Organic Tabs (Example One) -->

			</content>

	</div>
</section>

<?= $this->Html->script('Front.tabs/organictabs.jquery'); // tabs ?>
<script type="text/javascript">
    //organic tabs
    $(function() {
        $("#example-one").organicTabs();
    });
</script>