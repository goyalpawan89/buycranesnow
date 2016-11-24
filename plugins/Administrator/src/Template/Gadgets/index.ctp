
<!-- seccion principal -->
    <section class="content content-table">     
    	<section class="section fondo5">

			<!-- tabla de $gadgets -->
			<table id="table-index" class="table-index" cellpadding="0" cellspacing="0">
				<tr class="fondo2 color5">
								
							    <th><?= $this->Form->checkbox('select-all', ['hiddenField' => false, 'id' => 'select-all', 'class' => 'check', ]); ?></th>

						<?php $titles = ['id' => $extras['table_id'],
										 'name' => $controllerText['table_name'], 
										 //'type' => $controllerText['table_type'], 
										 'created' => $extras['table_created'], 
										 'modified' => $extras['table_modified'], 
										 'actions' => $extras['actions'], 
										 ]; 

							foreach ($titles as $key => $title) { ?>
								<th><?= $this->Paginator->sort($key, __($title)); ?></th>
						<?php } ?>

						<?php foreach($gadgets as $a => $gadget) {  ?>
								<tr>
									<td>
										<?= $this->Form->checkbox('checkbox', ['name' => 'checkbox[]', 'value' => $gadget->id, 'hiddenField' => false, 'id' => 'checkbox-'.$a, 'class' => 'check']);  ?>
									</td>

									<?php $datos = ['id' => $gadget->id, 
													'name' => $gadget->name, 
													//'type' => $gadget->type, 
													'modified' => date_format($gadget->modified, 'Y-m-d'), 
													'created' => date_format($gadget->created, 'Y-m-d'),
										           ];
									
									foreach ($datos as $key => $dato) { ?>
										<td class="<?php echo 'table-index_'.$key; ?>">
											<?php if($key == 'name' && $this->request->params['action'] == 'index') { 

													echo $this->Html->link($dato, ['action' => 'edit',$gadget->id], ['class' => 'color1 colorh2']); 
												  
												  } else { 

												  	echo $dato; 

												  }  ?>
										</td>
									<?php } ?>

									<td class="actions">
										
										<?php if($this->view=='trash') { 
											  	$btns = ['restore' => ['title' => $extras['restore'], 'action' => 'restore/'.$gadget->id, 'class' => 'btn-restore' ],  
											  			 'delete' =>  ['title' => $extras['delete'], 'action' => 'delete/'.$gadget->id, 'class' => 'btn-delete', /*'confirm' => $extras['confirm_delete_user']*/ ]
											  	];
											  } else { 
											  	$btns = ['edit' =>    ['title' => $extras['edit'], 'action' => 'edit/'.$gadget->id, 'class' => 'btn-restore' ],  
											  			 'clear' =>  ['title' => $extras['trash'], 'action' => 'clear/'.$gadget->id, 'class' => 'btn-trash' ],
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


				</tr>
			</table>

			<!-- paginador del index -->
			<?php echo $this->element('admin/index-paginator'); // seccion superior vistas index solamente aparecerá en vistas trash e index ?>
			<!-- fin paginador del index -->
			

		</section>
	</section>