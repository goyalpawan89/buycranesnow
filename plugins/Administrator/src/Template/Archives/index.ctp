
<?php # $extras['item']; variable de textos extra, $controllerText['item']; variable de texto del controlador. ?>

<!-- seccion principal -->
    <section class="content content-table">     
    	<section class="section fondo5">

			<!-- tabla de $catss -->
			<table id="table-index" class="table-index" cellpadding="0" cellspacing="0">
				<tr class="fondo2 color5">
								
								<th><?php echo $this->Form->checkbox('select-all', ['hiddenField' => false, 'id' => 'select-all', 'class' => 'check', ]); ?></th>
						<?php 
						// validar si estoy en Posts o Pages
						
						$titles = ['name' => $controllerText['table_name'], 
								   'user_id' => $extras['author'], 
								   'created' => $extras['table_created'], 
								   'actions' => $extras['actions'], 
								  ]; 

							foreach ($titles as $key => $title) { ?>
								<th><?php echo $this->Paginator->sort($key, __($title)); ?></th>
						<?php } ?>

				</tr>

						<?php if(isset($posts) && !empty($posts)) { foreach($posts as $a => $post) { if(!empty($post->filename)) { ?>

								<tr>
									<td><?php echo $this->Form->checkbox('checkbox', ['name' => 'checkbox[]', 'value' => $post->id, 'hiddenField' => false, 'id' => 'checkbox-'.$a, 'class' => 'check']);  ?></td>
																		
									<?php $datos = ['name' => $post->name, 'author' => $post->user->name. " " .$post->user->last_name, 'created' => date_format($post->created, 'Y-m-d'),]; 

									foreach ($datos as $key => $dato) { ?>
										<td class="<?php echo 'table-index_'.$key; ?>">
											<?php if($key == 'name' && $this->request->params['action'] == 'index') { 

												echo $this->Html->link(
																	   '<aside class="image-gallery" style="background-image:url('.$this->Image->get_image_url($post->id, 'medium').');"></aside>',
																	    array(
																	        'action' => 'edit/'.$post->id,
																	    ),
																	    array(
																	        'title'=> $dato,
																	        'class'=>'tooltip',
																	        'escape'=>false  //NOTICE THIS LINE ***************
																	    )
																	);

												  
												  } else {  echo $dato; } // filtros de las diferentes opciones de la tabla (usuario, nombre y enlace de la publicacion 
											?>

										</td>
									<?php } ?>
									<td class="actions">
										
										<?php $btns = [	 'edit' => ['title' => $extras['edit'], 'action' => 'edit/'.$post->id, 'class' => 'btn-restore' ],
											  			 'delete' =>  ['title' => $extras['delete'], 'action' => 'delete/'.$post->id, 'class' => 'btn-delete', /*'confirm' => $extras['confirm_delete_user']*/ ]
											  	];

											foreach ($btns as $key => $btn) { 
												if(isset($btn['confirm']) && !empty($btn['confirm'])) { 
															echo $this->Form->postLink('', $this->Url->build(["controller" => $this->request->params['controller'], "action" => $btn['action'] ]), 
																		   			  ['id' => 'btn-table_index', 'class' => $btn['class'].' fondo3 color5 fondoh2 tooltip', 'title' => $btn['title'], 'confirm' => $btn['confirm'] ]);
												} else {
															echo $this->Form->button('', ['id' => 'btn-table_index', 'class' => $btn['class'].' fondo3 color5 fondoh2 tooltip', 'title' => $btn['title'], 
																	  					  'formaction' => $this->Url->build(["controller" => $this->request->params['controller'], "action" => $btn['action'] ]) ]);
												}
											}
											

										 ?>

									</td>
									
								</tr>
						<?php } } } ?>


			</table>
			<!--fin tabla de $catss -->
			
			<!-- paginador del index -->
			<?php echo $this->element('admin/index-paginator'); // seccion superior vistas index solamente aparecerá en vistas trash e index ?>
			<!-- fin paginador del index -->


		</section>
	</section>
