
<h1 id="principal"><?php echo __($name.': '.$CODE); ?></h1>

<?php //echo  pr($datos->toArray());?>
<table>
	<tr class="fondo">
		<th><?php echo $this->paginator->sort( __('Conversión a USD')); ?></th>
		<th><?php echo $this->paginator->sort( __('Valor TRM')); ?></th>
		<th><?php echo $this->paginator->sort( __('Valor Cotización')); ?></th>
	</tr>
	<tr>
		<td><?php echo $usd; ?></td>
		<td><?php echo $trm; ?></td>
		<td><?php echo $cotizacion; ?></td>
	</tr>
</table>

<aside class="right">
    <aside class="right" style="margin:3px 0;"><?php echo __('<b>Fecha de '.$CODE.' modificación:</b> '.$fecha); ?></aside><br />
</aside>
<h1 id="principal"><?php echo __('Historial '.$CODE.''); ?></h1>
<table>
<tr class="fondo">

<th><?php echo $this->paginator->sort('currency', __('Moneda')); ?></th>
<th><?php echo $this->paginator->sort('default', __('Conversión a USD')); ?></th>
<th><?php echo $this->paginator->sort('default', __('Valor TRM')); ?></th>
<th><?php echo $this->paginator->sort('value', __('Valor Cotización')); ?></th>
<th><?php echo $this->paginator->sort('fecha', __('Fecha Sincronización')); ?></th>
<th><?php echo $this->paginator->sort('created', __('Fecha creación')); ?></th>
<th><?php echo $this->paginator->sort('created', __('Fecha de modificación')); ?></th>
</tr>
<?php $a=1; foreach($datos as $dato) { ?>
<tr>

<td>
<?php echo $this->Html->link($name, array('action' => 'edit', $dato->currency_id)); ?></td>
<td><?php echo $dato->usd; ?></td>
<td><?php echo $dato->default_trm; ?></td>
<td><?php echo $dato->value_trm; ?></td>
<td><?php echo $dato->date; ?></td>
<td><?php echo $dato->created; ?></td>
<td><?php echo $dato->modified; ?></td>

</tr>
<?php $a++; } ?>
</table>
<p><?php echo $this->Paginator->counter(['format' => ''.__("Página").' {{page}} '.__("de").' {{pages}}, '.__("mostrando").' {{current}} '.__("registro de").' {{count}}']);?></p>

<div id="paging">
<?php echo $this->Paginator->prev('<< '.__(" Anterior").' | '); ?>
<?php echo $this->Paginator->numbers(['separator' => ' - ']); ?>
<?php echo $this->Paginator->next('| '.__("Siguiente ").' >>'); ?>
</div>