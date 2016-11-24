 
<?php # $extras['item']; variable de textos extra, $controllerText['item']; variable de texto del controlador. ?>

<!-- seccion principal -->
    <section class="content content-table">     
    	<section class="section fondo5">

			<!-- tabla de $catss -->
			<table id="table-index" class="table-index" cellpadding="0" cellspacing="0">
				<tr class="fondo2 color5">
								
								<th><?= $this->Form->checkbox('select-all', ['hiddenField' => false, 'id' => 'select-all', 'class' => 'check', ]); ?></th>
						
						<?php $titles = [ 'id' => $extras['id'],
										  'name' => $extras['crane_author'], 
										  'author' => $extras['author'], 
										  'type' => $extras['avalible'], 
										  'value' => $extras['value'], 
										  'counteroffer' => $extras['counteroffer'], 
										  'created' => $extras['offer_date'], 
										  'status' => $extras['status'], 
									  ]; 

							foreach ($titles as $key => $title) { ?>
								<th style="text-align: left;"><?= $this->Paginator->sort($key, __($title)); ?></th>
						<?php } ?>

				</tr>
					
					<?php foreach ($offers as $a => $offer) {

						if($offer->type == 'sell') {

							$value = $this->Number->currency($offer->value, $info['currency']); 
							$counteroffer = $this->Number->currency($offer->counteroffer, $info['currency']); 
						
						} else {

							$value = 'N/A'; 
							$counteroffer = 'N/A';

						} 

					?>

					<tr>

							<td><?= $this->Form->checkbox('checkbox', ['name' => 'checkbox[]', 'value' => $offer->id, 'hiddenField' => false, 'id' => 'checkbox-'.$a, 'class' => 'check']);  ?></td>
							<td><?= $offer->id; ?></td>
							<td><?= $this->Html->link($this->Get->get_company_name($offer->user_id), ['action' => 'view',$offer->id], ['class' => 'color1 colorh2']); ?></td>
							<td><?= $this->Html->link($this->Get->get_company_name($offer->author_id), 'mailto:'.$this->Get->get_company_email($offer->author_id), ['class' => 'color1 colorh2']); ?></td>
							<td><?= $extras[$offer->type]; ?></td>
							<td><?= $value; ?></td>
							<td><?= $counteroffer; ?></td>
							<td><?= $offer->created; ?></td>
							<td><?= $offer->status; ?></td>
					</tr>

					<?php } ?>						


			</table>
			<!--fin tabla de $catss -->
			
			<!-- paginador del index -->
			<?php echo $this->element('admin/index-paginator'); // seccion superior vistas index solamente aparecerá en vistas trash e index ?>
			<!-- fin paginador del index -->


		</section>
	</section>
