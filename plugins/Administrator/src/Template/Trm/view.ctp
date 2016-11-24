<?php

if ($this -> view == 'view') {
	$botonPapelera = 'Enviar a papelera';
	$btnAccion = 'clear';
	$accion = 'Enviar a papelera';
} else {
	$botonPapelera = 'Restaurar monedas';
	$btnAccion = 'active';
	$accion = 'Activar';
}

?>

<h1 id="principal"><?php echo __('Monedas'); ?></h1>

<?php echo $this->Form->create('Currency', array()); ?>

<aside class="left"><?php echo $this->Form->input(__($botonPapelera), array('type' => 'submit', 'label' => false, 'class' => 'trash')); ?></aside>

<aside class="right">
    <aside class="right" style="margin:3px 0;"><?php echo __('Todas las Monedas: ' . $todos); ?></aside><br />
    <aside class="right">
	<?php echo $this->Html-> link('Monedas activas: ' . $activos, array('action' => 'View'), array('class' => 'color colorgrish')); ?> | 
	<?php echo $this->Html-> link('Monedas inactivas: ' . $inactivos, array('action' => 'Trash'), array('class' => 'color colorgrish')); ?>
    </aside>
</aside>

<table>
<tr class="fondo">
<th width="20" align="center">
<?php echo $this->Form->checkbox('select-all', array('hiddenField' => false, 'id' => 'select-all', 'class' => 'check')); ?>
</th>
<th><?php echo $this->paginator->sort('code', __('Codigo')); ?></th>
<th><?php echo $this->paginator->sort('name', __('Nombre')); ?></th>
<th><?php echo $this->paginator->sort('usd', __('Conversión a USD')); ?></th>
<th><?php echo $this->paginator->sort('trm', __('Valor Actual TRM')); ?></th>
<th><?php echo $this->paginator->sort( __('Valor Incremento')); ?></th>
<th><?php echo $this->paginator->sort('modified', __('Fecha modificación')); ?></th>
<th><?php echo $this->paginator->sort('created', __('Fecha creación')); ?></th>
<th><?php echo $this->paginator->sort(__('Acciones')); ?></th>
</tr>
<?php $a=1; foreach($datos as $dato) { 	?>
<tr>
<td width="20" align="center">
<?php echo $this -> Form -> checkbox('checkbox', array('name' => 'checkbox][]', 'value' => $dato->id, 'hiddenField' => false, 'id' => 'checkbox-' . $a, 'class' => 'check')); ?>
</td>
<td>
<?php echo $this -> Html -> link($dato->code, array('action' => 'currency', $dato->code)); ?></td>
<td><?php echo $dato->name; ?></td>
<td><?php echo $dato->usd; ?></td>
<td><?php
	if (isset($dato->trm)) {echo $dato->trm;
	}
?></td>
<td><?php
	if (isset($dato->value)) {echo $dato->value;
	}
?></td>
<td><?php echo $dato->modified; ?></td>
<td><?php echo $dato->created; ?></td>
<td>
<?php
	if ($this->view == 'trash') {
		echo $this->Form->button(__('Restaurar'), array('class' => 'boton-sin', 'formaction' => Router::url(array('action' => 'restore', $dato->id))));

	} else {
		echo $this->Html->link(__('Editar'), array('action' => 'edit', $dato->id), array('class' => 'editar')) . " | ";
		echo $this->Form->button(__($accion), array('class' => 'boton-sin', 'formaction' => $this->Url->build(['action' => $btnAccion, $dato->id])));


	}
 ?>
</td> 
</tr>
<?php $a++;
	}
 ?>
</table>

<?php echo $this -> Form -> end(); ?>

<p><?php echo $this->Paginator->counter(['format' => ''.__("Página").' {{page}} '.__("de").' {{pages}}, '.__("mostrando").' {{current}} '.__("registro de").' {{count}}']);?></p>

<div id="paging">
<?php echo $this->Paginator->prev('<< '.__(" Anterior").' | '); ?>
<?php echo $this->Paginator->numbers(['separator' => ' - ']); ?>
<?php echo $this->Paginator->next('| '.__("Siguiente ").' >>'); ?>
</div>