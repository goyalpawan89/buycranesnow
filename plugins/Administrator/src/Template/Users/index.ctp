<?php # $extras['item']; variable de textos extra, $controllerText['item']; variable de texto del controlador. ?>

<!-- seccion principal -->
    <section class="content content-table">     
    	<section class="section fondo5">
		
			<!-- tabla de usuarios -->
			<table id="table-index" class="table-index" cellpadding="0" cellspacing="0">
				<tr class="fondo2 color5">
								
								<th><?php echo $this->Form->checkbox('select-all', ['hiddenField' => false, 'id' => 'select-all', 'class' => 'check', ]); ?></th>
						<?php $titles = ['name' => $controllerText['table_name'], 
										 'company_name' => $extras['company_name'],
										 'role_id' => $controllerText['table_type'], 
										 'email' => $controllerText['table_email'], 
										 'company_country' => $extras['country'], 
										 'created' => $extras['table_created'], 
										 'modified' => $extras['table_modified'], 
										 'actions' => $extras['actions'], 
										 ]; 

							foreach ($titles as $key => $title) { ?>
								<th><?php echo $this->Paginator->sort($key, __($title)); ?></th>
						<?php } ?>

				</tr>

						<?php foreach($usuarios as $a => $usuario) { ?>
								<tr>
									<td><?php echo $this->Form->checkbox('checkbox', ['name' => 'checkbox[]', 'value' => $usuario->id, 'hiddenField' => false, 'id' => 'checkbox-'.$a, 'class' => 'check']);  ?></td>
									<td>
									<?php echo $this->Html->image('http://0.gravatar.com/avatar/ad516503a11cd5ca435acc9bb6523536?s=32', ['alt' => 'Avatar', 'class' => 'avatar']); ?>
									<?php if($this->request->params['action'] == 'index') { echo $this->Html->link($usuario->name." ".$usuario->last_name, ['action' => 'edit',$usuario->id], ['class' => 'color1 colorh2']); } 
										  else { echo __($usuario->name." ".$usuario->last_name); } ?>
									</td>
									
									<?php $datos = ['company_name' => $usuario->company_name, 'role' => $usuario->role->name, 'email' => $this->Text->autoLinkEmails($usuario->email), 'company_country' => $usuario->company_country, 'modified' => date_format($usuario->modified, 'Y-m-d H:i'), 'created' => date_format($usuario->created, 'Y-m-d H:i'),
										           ]; 

									foreach ($datos as $key => $dato) { ?>
										<td class="<?php echo 'table-index_'.$key; ?>"><?php echo $dato; ?></td>
									<?php } ?>
									<td class="actions">
										
										<?php if($this->view=='trash') { 
											  	$btns = ['restore' => ['title' => $extras['restore'], 'action' => 'restore/'.$usuario->id, 'class' => 'btn-restore' ],  
											  			 'delete' =>  ['title' => $extras['delete'], 'action' => 'delete/'.$usuario->id, 'class' => 'btn-delete', 'confirm' => $extras['confirm_delete_user'] ]
											  	];
											  } else { 
											  	$btns = ['edit' =>    ['title' => $extras['edit'], 'action' => 'edit/'.$usuario->id, 'class' => 'btn-restore' ],  
											  			 'clear' =>  ['title' => $extras['desactive_user'], 'action' => 'clear/'.$usuario->id, 'class' => 'btn-trash' ],
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
			<!--fin tabla de usuarios -->
			
			<!-- paginador del index -->
			<?php echo $this->element('admin/index-paginator'); // seccion superior vistas index solamente aparecerá en vistas trash e index ?>
			<!-- fin paginador del index -->


		</section>
	</section>

