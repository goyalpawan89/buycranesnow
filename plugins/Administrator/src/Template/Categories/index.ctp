
<?php # $extras['item']; variable de textos extra, $controllerText['item']; variable de texto del controlador. ?>

<!-- seccion principal -->
    <section class="content content-table">     
    	<section class="section fondo5">

			<!-- tabla de $catss -->
			<table id="table-index" class="table-index" cellpadding="0" cellspacing="0">
				<tr class="fondo2 color5">
								
								<th><?php echo $this->Form->checkbox('select-all', ['hiddenField' => false, 'id' => 'select-all', 'class' => 'check', ]); ?></th>
						<?php $titles = ['id' => $extras['table_id'],
										 'name' => $controllerText['table_name'], 
										 'description' => $controllerText['table_description'], 
										 'created' => $extras['table_created'], 
										 'modified' => $extras['table_modified'], 
										 'actions' => $extras['actions'], 
										 ]; 

							foreach ($titles as $key => $title) { ?>
								<th><?php echo $this->Paginator->sort($key, __($title)); ?></th>
						<?php } ?>

				</tr>

						<?php foreach($categorias as $a => $cats) {  ?>
								<tr>
									<td><?php echo $this->Form->checkbox('checkbox', ['name' => 'checkbox[]', 'value' => $cats->id, 'hiddenField' => false, 'id' => 'checkbox-'.$a, 'class' => 'check']);  ?></td>
																		
									<?php $datos = ['id' => $cats->id, 'name' => $cats->name, 'description' => $cats->description, 'modified' => date_format($cats->modified, 'Y-m-d'), 'created' => date_format($cats->created, 'Y-m-d'),
										           ]; 

									foreach ($datos as $key => $dato) { ?>
										<td class="<?php echo 'table-index_'.$key; ?>">
											<?php if($key == 'name' && $this->request->params['action'] == 'index') { 

													echo $this->Html->link($arbol[$cats->id], ['action' => 'edit',$cats->id], ['class' => 'color1 colorh2']); 
												  
												  } elseif($key == 'description') { 

												  	echo $this->Text->excerpt(strip_tags($dato), 'method', 50, '...'); 

												  } else { 

												  	echo $dato; 

												  }  ?>
										</td>
									<?php } ?>
									<td class="actions">
										
										<?php 	//variables $editRestore, $trasDelete enviadas desde el controlador para validar si estoy en la vista index o trash.

												if($cats->id == 1 || $cats->id == 10 || $cats->id == 11 || $cats->id == 12) { $disabled = 'disabled';  } else { $disabled = false; }

											  	$btns = ['edit_restore' => ['options' => ['id' => 'btn-table_index', 'title' => $extras[$editRestore], 'class' => 'btn-restore fondo3 color5 fondoh2 tooltip',
											  						   				 'formaction' => $this->Url->build(["action" => $editRestore.'/'.$cats->id]) 
											  						   				 ]
											  						  ],

											  			 'trash_delete' => ['options' => ['id' => 'btn-table_index', 'title' => $extras[$trashDelete], 'class' => 'btn-'.$trashDelete.' fondo3 color5 fondoh2 tooltip',  $disabled => $disabled, 
											  						   				 'formaction' => $this->Url->build(["action" => $trashDelete.'/'.$cats->id ]) 
											  						   				 ]
											  						  ],
											  	];
											  

											foreach ($btns as $key => $btn) { 
															
															echo $this->Form->button('', $btn['options']);
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
