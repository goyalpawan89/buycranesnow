	
<!-- contenido principal -->
<section class="content background">
	<div class="wrap">
			
			<!-- descripcion de la categoria -->
			<article class="category-description description">
				<h1><?= __($controllerText['title']); ?></h1>
				<?= __($controllerText['description']); ?>
			</article>
							
							<aside class="list-description table">	
								<?php $descriCons = ['crane_thumbs' => 'index', 'crane_list' => 'crane_list', 'crane_photos'  => 'crane_photos', 'map_list' => ''];
								      foreach ($descriCons as $key => $link) { ?>
								      	
								      	<aside class="list-description_item table-cell">
											<?= $this->Html->link(__($extras[$key]), '#', ['class' => $key.' color3', 'data-sort-value' => $key ]); ?>
											<?php if($key == 'map_list') { ?><span class="my_ubication"></span><?php } ?>
								      	</aside>

				                <?php } ?>
							</aside>
							<!-- fin descripcion de la categoria -->
								
							<div id="mapa"><div id='map_canvas' style="width:100%; height:400px;"></div></div>
			<!-- fin descripcion de la categoria -->

			<!-- Contenido de la categoria -->
			<table class="content-table">
				<tr>
					<td class="fondogris">
						<?= $this->element('sidebar');?>
					</td>
					<td>
						<content class="content-table_content">		
								<?= $this->element('Front.post_info'); ?>
						</content>
					</td>
				</tr>
			</table>
			<!-- fin contenido de la categoria -->



	</div>
</section> 


<?= $this->element('Front.script_gruas_search');?>