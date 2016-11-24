

<!-- contenido principal -->
<section class="content background">
	<div class="wrap">
			
			<!-- descripcion de superior -->
			<article class="category-description description">
				<h1><?= __($extras['my_favorites']); ?></h1>
				<p><?= __($extras['my_favorites_description']); ?></p>
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
			<!-- fin descripcion superior -->
				
			<div id="mapa"><div id='map_canvas' style="width:100%; height:400px;"></div></div>

			<!-- Contenido de la categoria -->
			<table class="content-table">
				<tr>
					<td class="fondogris">
						<?= $this->element('sidebar');?>
					</td>
					<td>
						<content class="content-table_content">
						
									  <?= $this->element('Front.post_info');?>

						</content>
					</td>
				</tr>
			</table>
			<!-- fin contenido de la categoria -->

			<!-- paginador -->
			<section class="up-section counter-section fondo5">
                            <div class="wrap">
                                <div class="pagin-count">
                                    <p><?= $this->Paginator->counter(['format' => ''.__($extras['page']).' {{page}} '.__($extras['of']).' {{pages}}, '.__($extras['showing']).' {{current}} '.__($extras['log']).' {{count}}']);?></p>
                                    <nav>
                                        <?= $this->Paginator->prev('');
                                              echo $this->Paginator->numbers(['separator' => ' - ','currentTag' => 'a', 'currentClass' => 'active','tag' => 'li','first' => 1]);
                                              echo $this->Paginator->next(''); ?>
                                    </nav>
                                </div>
                            </div>
			</section>
			<!-- fin paginador -->


	</div>
</section> 


<!-- nuevos arrivos -->
			<section class="up-section counter-section background">
                    <div class="wrap">
                       	<h2 class="title-section"><?= __($extras['new_arrivals']); ?></h2>
                    </div>
					<?= $this->element('Front.destacados');?>
			</section>
<!--fin nuevos arrivos -->


<script>
	$( ".map_list" ).click(function() {
	  $('#mapa').toggleClass( "completo" );
	  return false;
	});

</script>

<?= $this->element('Front.script_gruas_mapa');?>

