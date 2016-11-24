 
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
						if($this->request->params['controller'] == 'Posts') { $tableName = 'Categories.name'; $tableValue = $extras['categories']; } else { $tableName = ''; $tableValue = ''; }

						$titles = ['name' => $controllerText['table_name'], 
										 $tableName => $tableValue, 
										 'slug' => $extras['slug'], 
										 'author' => $extras['author'], 
										 'location' => $extras['location'], 
										 'modified' => $extras['table_modified'], 
										 'actions' => $extras['actions'], 
										 ]; 

							foreach ($titles as $key => $title) { ?>
								<th><?php echo $this->Paginator->sort($key, __($title)); ?></th>
						<?php } ?>

				</tr>
						<?php foreach($posts as $a => $post) { 

						// validar si estoy en Posts o Pages
						if($this->request->params['controller'] == 'Posts') { $tabName = 'categories'; $tabValue = $post->categories; } else { $tabName = ''; $tabValue = ''; } ?>

								<tr>
									<td><?php echo $this->Form->checkbox('checkbox', ['name' => 'checkbox[]', 'value' => $post->id, 'hiddenField' => false, 'id' => 'checkbox-'.$a, 'class' => 'check']);  ?></td>
																		
									<?php $datos = ['name' => $post->name, 
													$tabName => $tabValue,
													'slug' => $post->slug, 
													'author' => $post->user->name, 
													'location' => $post->location,
													'modified' => date_format($post->modified, 'Y-m-d'), 
										           ]; 

									foreach ($datos as $key => $dato) { ?>
										<td class="<?php echo 'table-index_'.$key; ?>">
											<?php if($key == 'name' && $this->request->params['action'] == 'index') { // filtros de las diferentes opciones de la tabla (usuario, nombre y enlace de la publicacion etc...)

															echo $this->Html->link($dato, ['action' => 'edit',$post->id], ['class' => 'color1 colorh2']); 
												  
												  } elseif($key == 'categories') { 

													  	foreach($dato as $key => $cat){ // llamo las categorias desde el array de $datos	
													  	 	//echo $this->Form->postLink($cat->name." ", ['class' => 'color1 colorh2', 'value' => $cat->id, 'url' => ['action' => 'index'] ]);
													  	 	echo $this->Form->button($cat->name, ['class' => 'boton-sin color1 colorh2', 'name' => 'cat', 'value' => $cat->id, 'url' => ['action' => 'index'] ]);
													  	}

												  } else {  echo $dato; } // filtros de las diferentes opciones de la tabla (usuario, nombre y enlace de la publicacion etc...) ?>

										</td>
									<?php } ?>
									<td class="actions">
										
										<?php if($this->view=='trash') { 
											  	$btns = ['restore' => ['title' => $extras['restore'], 'action' => 'restore/'.$post->id, 'class' => 'btn-restore' ],  
											  			 'delete' =>  ['title' => $extras['delete'], 'action' => 'delete/'.$post->id, 'class' => 'btn-delete', /*'confirm' => $extras['confirm_delete_user']*/ ]
											  	];
											  } else { 
											  	$btns = ['edit' =>    ['title' => $extras['edit'], 'action' => 'edit/'.$post->id, 'class' => 'btn-restore' ],  
											  			 'clear' =>  ['title' => $extras['trash'], 'action' => 'clear/'.$post->id, 'class' => 'btn-trash' ],
											  	];
											  } 

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
						<?php } ?>


			</table>
			<!--fin tabla de $catss -->
			
			<!-- paginador del index -->
			<?php echo $this->element('admin/index-paginator'); // seccion superior vistas index solamente aparecerá en vistas trash e index ?>
			<!-- fin paginador del index -->


		</section>
	</section>
