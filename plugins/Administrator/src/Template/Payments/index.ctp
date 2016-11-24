 
<?php # $extras['item']; variable de textos extra, $controllerText['item']; variable de texto del controlador. ?>

<!-- seccion principal -->
    <section class="content content-table">     
    	<section class="section fondo5">

			<!-- tabla de pagos -->
			<table id="table-index" class="table-index" cellpadding="0" cellspacing="0">
				<tr class="fondo2 color5">
								
						<th><?= $this->Form->checkbox('select-all', ['hiddenField' => false, 'id' => 'select-all', 'class' => 'check', ]); ?></th>
						<?php 
						// validar si estoy en Posts o Pages
						if($this->request->params['controller'] == 'Posts') { $tableName = 'Categories.name'; $tableValue = $extras['categories']; } else { $tableName = ''; $tableValue = ''; }

						$titles =  ['name' => $controllerText['table_name'], 
									'item_name' => $controllerText['table_item_name'], 
									'payment_status' => $controllerText['table_payment_status'], 
									'payment_gross' => $controllerText['table_payment_gross'], 
									'txn_id' => $controllerText['table_txn_id'], 
									'plan' => $controllerText['table_plan'], 
									'actions' => $extras['actions'], 
								  ]; 

							foreach ($titles as $key => $title) { ?>
								<th><?= $this->Paginator->sort($key, __($title)); ?></th>
						<?php } ?>

				</tr>
				
				<?php foreach($payments as $a => $pago) { ?>
				
				<tr>	
					<td><?= $this->Form->checkbox('checkbox', ['name' => 'checkbox[]', 'value' => $pago->id, 'hiddenField' => false, 'id' => 'checkbox-'.$a, 'class' => 'check']);  ?></td>

					<?php $datos = ['name' => $pago->user->company_name, 
									'item_name' => $pago->item_name, 
									'payment_status' => $pago->status, 
									'payment_gross' => $pago->payment_gross,
									'txn_id' => $pago->txn_id,
									'plan' => $pago->plan,
									]; 

									foreach ($datos as $key => $dato) { ?>
										<td class="<?php echo 'table-index_'.$key; ?>">
											<?php if($key == 'name') { // filtros de las diferentes opciones de la tabla (usuario, nombre y enlace de la publicacion etc...)

															echo $this->Html->link($dato, '#', ['class' => 'color1 colorh2']); 
												  
												  } elseif($key == 'payment_gross') {

												  	echo $this->Number->currency($dato, $info['currency']);

												  } else {  echo $dato; } // filtros de las diferentes opciones de la tabla (usuario, nombre y enlace de la publicacion etc...) ?>

										</td>
									<?php } ?>
									<td class="actions">
										
										<?php if($this->view=='trash') { 
											  	$btns = ['restore' => ['title' => $extras['restore'], 'action' => 'restore/'.$pago->id, 'class' => 'btn-restore' ],  
											  			 'delete' =>  ['title' => $extras['delete'], 'action' => 'delete/'.$pago->id, 'class' => 'btn-delete', /*'confirm' => $extras['confirm_delete_user']*/ ]
											  	];
											  } else { 
											  	$btns = ['edit' =>    ['title' => $extras['edit'], 'action' => 'edit/'.$pago->id, 'class' => 'btn-restore' ],  
											  			 'clear' =>  ['title' => $extras['trash'], 'action' => 'clear/'.$pago->id, 'class' => 'btn-trash' ],
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


				<?php } ?>



			</table>

			<!--fin tabla de pagos -->
			
			<!-- paginador del index -->
			<?= $this->element('admin/index-paginator'); // seccion superior vistas index solamente aparecerá en vistas trash e index ?>
			<!-- fin paginador del index -->


		</section>
	</section>
