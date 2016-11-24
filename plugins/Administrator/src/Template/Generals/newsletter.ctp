 
<?php # $extras['item']; variable de textos extra, $controllerText['item']; variable de texto del controlador. ?>

<?= $this->Form->create('newsletter', array('enctype' => 'multipart/form-data')); ?> 

<!-- seccion principal -->
    <section class="content content-table">     
    	<section class="section fondo5">

			<!-- tabla de $catss -->
			<table id="table-index" class="table-index" cellpadding="0" cellspacing="0">
				<tr class="fondo2 color5">
								
								<th><?php echo $this->Form->checkbox('select-all', ['hiddenField' => false, 'id' => 'select-all', 'class' => 'check', ]); ?></th>
						<?php 
						// validar si estoy en Posts o Pages
						$titles = [ 'email' => $extras['email'], 
									'created' => $extras['created'], 
									'modified' => $extras['modified'], 
								  ]; 

							foreach ($titles as $key => $title) { ?>
								<th><?php echo $this->Paginator->sort($key, __($title)); ?></th>
						<?php } ?>

				</tr>
						<?php foreach($newsletters as $a => $registro) { ?>

								<tr>
									<td><?php echo $this->Form->checkbox('checkbox', ['name' => 'checkbox[]', 'value' => $registro->id, 'hiddenField' => false, 'id' => 'checkbox-'.$a, 'class' => 'check']);  ?></td>
																		
									<?php $datos = ['email' => $registro->email, 
													'modified' => date_format($registro->modified, 'Y-m-d'), 
													'created' => date_format($registro->created, 'Y-m-d'),
										           ]; 

									foreach ($datos as $key => $dato) { ?>
										<td class="<?php echo 'table-index_'.$key; ?>">

												<?php if($key == 'email') { echo $this->Text->autoLinkEmails($dato); } else { echo $dato; } ?>

										</td>
									<?php } ?>
									
								</tr>
						<?php } ?>


			</table>
			<!--fin tabla de $catss -->
			
			<!-- paginador del index -->
			<?php echo $this->element('admin/index-paginator'); // seccion superior vistas index solamente aparecerá en vistas trash e index ?>
			<!-- fin paginador del index -->


		</section>
	</section>

<?php echo $this->Form->end(); ?>