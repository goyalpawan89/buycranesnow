<style type="text/css">
	
	.formulario_contacto div:nth-child(8) #city { width: 64%; }

</style>

<!-- contenido principal -->
<section class="content background">
	<div class="wrap">
			
			<!-- publicidad superuir -->
			<?= $this->element('Front.publicity_up'); ?>

			<aside id="breadcrumbs" class="list-description table">	
				<aside class="list-description_item table-cell"><b><?= $extras['you_are_in']; ?>: </b> 
					<?php $this->Html->addCrumb($content->name, '', ['class' => 'color2']); 
						  echo $this->Html->getCrumbs(' » '); ?>
				</aside>
			</aside>
			<!-- fin descripcion de la categoria -->

			<!-- Contenido de la categoria -->
			<table class="content-table content-table_page">
				<tr>
					<td class="fondogris">
						<?= $this->element('sidebar');?>
					</td>
					<td style="text-align: left; padding-left: 20px;">
						<!-- descripcion de la categoria -->
						<article class="formulario_content">
							<h1 class="fondo1 content-side_description_title"><?= $content->name; ?></h1><br>							

									<?php echo $this->Form->create('contact', ['class' => 'formulario formulario_contacto']);

										    foreach ($campos as $name => $options) {
				                                    echo $this->Form->input($name, $options); 
				                            } 
				                            
				                    echo $this->Form->end(); ?>

						</article>

					</td>
				</tr>
			</table>

	</div>
</section>

<script type="text/javascript">
	
	

	jQuery(document).ready(function() {
                        
                        $('<?= $this->Form->input('code_phone', ['label' => false, 'class' => 'code_phone input-contact', 'empty' => __($extras["indicative"]), 'div' => false, 'type' => 'select', 'options' => $codigosTelefono, 'required' => 'required']); ?>').insertBefore("#tel");
                        $('<?= $this->Form->input('area_phone', ['label' => false, 'class' => 'input-contact area_phone', 'placeholder' => __($extras["area_phone"]), 'div' => false, 'required' => 'required']); ?>').insertBefore("#tel");
                        
                        $('<?= $this->Form->input('code_cel', ['label' => false, 'class' => 'code_phone input-contact', 'empty' => __($extras["indicative"]), 'div' => false, 'type' => 'select', 'options' => $codigosTelefono, 'required' => 'required']); ?>').insertBefore(".indicative_cel");
                        $('<?= $this->Form->input('area_cel', ['label' => false, 'class' => 'input-contact area_phone', 'placeholder' => __($extras["area_cel"]), 'div' => false, 'required' => 'required']); ?>').insertBefore(".indicative_cel");


                        $('.country_search').change(function(){
                                  
		                  cities = $('.city_search');

		                  cities.empty();
		                  cities.append('<option><?= __($extras["loading"]); ?></option>'); 

		                      $.post("/admin/Config/api_cities", // buscamos las ciudades desde el controlador config funcion api_cities
		                             { pais: $(this).val(), }, // mandamos el nombre del pais para buscar las ciudades.
		                                          
		                             function(data) {

		                                var ciudades = data.split(",");               
		                                var cityPerCountry, i;

		                                for (i = 0; i < ciudades.length; i++) {
		                                        cityPerCountry +=  '<option  value="'+ ciudades[i] + '">'+ ciudades[i] +'</option>';
		                                }

		                                //$('#sidebarSearch #city').innerHTML = '<option>Bogotá</option>';
		                                cities.empty();
		                                cities.append(cityPerCountry);

		                              }
		                      );                             

		                });
                        
	});

</script>