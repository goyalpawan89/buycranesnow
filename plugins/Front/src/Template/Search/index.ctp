	
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
											<?= $this->Html->link(__($extras[$key]), '#', ['class' => $key.' color3', 'data-sort-value' => $key]); ?>
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
			
			<?php /*
			<!-- paginador -->
			<section class="up-section counter-section fondo5">
                            <div class="wrap">
                                <div class="pagin-count">
                                    <p><?php echo $this->Paginator->counter(['format' => ''.__($extras['page']).' {{page}} '.__($extras['of']).' {{pages}}, '.__($extras['showing']).' {{current}} '.__($extras['log']).' {{count}}']);?></p>
                                    <nav>
                                        <?php echo $this->Paginator->prev('');
                                              echo $this->Paginator->numbers(['separator' => ' - ','currentTag' => 'a', 'currentClass' => 'active','tag' => 'li','first' => 1]);
                                              echo $this->Paginator->next(''); ?>
                                    </nav>
                                </div>
                            </div>
			</section>
			<!-- fin paginador -->
			*/ ?>


	</div>
</section> 


<?= $this->element('Front.script_gruas_mapa');?>

<?php if(isset($this->request->query["city"]) && !empty($this->request->query["city"])) { ?>
			
			<script type="text/javascript">
					
					$(window).load( function() {

						var city = $('#city');
						city.empty();

						city.append('<option selected="selected" value="<?= $this->request->query["city"]; ?>"><?= $this->request->query["city"]; ?></option>');

						$.post("/admin/Config/api_cities", // buscamos las ciudades desde el controlador config funcion api_cities
			                             { pais: '<?= $this->request->query["country"]; ?>', }, // mandamos el nombre del pais para buscar las ciudades.
			                                          
			                             function(data) {

			                                var ciudades = data.split(",");               
			                                var cityPerCountry, i;

			                                for (i = 0; i < ciudades.length; i++) {
			                                        cityPerCountry +=  '<option  value="'+ ciudades[i] + '">'+ ciudades[i] +'</option>';
			                                }

			                                //$('#sidebarSearch #city').innerHTML = '<option>Bogotá</option>';
			                                //console.log(cityPerCountry);
			                                city.append(cityPerCountry);

			                              }
			                      );   



					});

					
			</script>

<?php } ?>