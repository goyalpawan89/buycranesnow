<?php 
if($this->view=='Config_view' or $this->view=='Config_index') { 
      $botonPapelera = 'Enviar a papelera'; 
	  $btnAccion='clear';
	  $accion='Enviar a papelera';
	  } else {
      $botonPapelera = 'Restaurar';
	  $btnAccion='active';
	  $accion='Activar'; 	  
	  } 
?>

<h1 id="principal"><?php echo __('Moneda'); ?></h1>

<?php echo $this->Form->create('Moneda', array()); ?>

<aside class="left"><?php echo $this->Form->input(__($botonPapelera), array('type' => 'submit', 'label' => false, 'class' => 'trash')); ?></aside>

<aside class="right">
    <aside class="right" style="margin:3px 0;"><?php echo __('Todas las Monedas: '.$todos); ?></aside><br />
    <aside class="right">
	<?php echo $this->Html->link('Monedas activas: '.$conteo, array('action' => 'index'), array('class' => 'color colorgrish')); ?> | 
	<?php echo $this->Html->link('Monedas inactivas: '.$inactivos, array('action' => 'trash'), array('class' => 'color colorgrish')); ?>
    </aside>
</aside>

<table>
<tr class="fondo">
<th width="20" align="center">
<?php echo $this->Form->checkbox('select-all', array('hiddenField' => false, 'id' => 'select-all', 'class' => 'check')); ?>
</th>
<th><?php echo $this->paginator->sort('name', __('Nombre')); ?></th>
<th><?php echo $this->paginator->sort('code', __('Codigo')); ?></th>
<th><?php echo $this->paginator->sort('modified', __('Fecha modificación')); ?></th>
<th><?php echo $this->paginator->sort('created', __('Fecha creación')); ?></th>
<th><?php echo $this->paginator->sort(__('Acciones')); ?></th>
</tr>
<?php $a=1; foreach($datos as $dato) { ?>
<tr>
<td width="20" align="center">
<?php echo $this->Form->checkbox('checkbox', array('name' => 'data[Moneda][checkbox][]', 'value' => $dato['Moneda']['id'], 'hiddenField' => false, 'id' => 'checkbox-'.$a, 'class' => 'check'));  ?>
</td>
<td>
<?php echo $this->Html->link($dato['Moneda']['name'], array('action' => 'edit', $dato['Moneda']['id'])); ?></td>
<td><?php echo $dato['Moneda']['code']; ?></td>
<td><?php echo $dato['Moneda']['modified']; ?></td>
<td><?php echo $dato['Moneda']['created']; ?></td>
<td>
<?php if($this->view=='trash') { 
      echo $this->Form->button(__('Restaurar'), array('class' => 'boton-sin', 'formaction' => Router::url(array('controller' => 'Moneda','action' => 'restore',$dato['Moneda']['id']))))." | ";
	  echo $this->Form->button(__('Eliminar'), array('class' => 'boton-sin', 'formaction' => Router::url(array('controller' => 'Moneda','action' => 'delete',$dato['Moneda']['id']))));
      } else {
	  echo $this->Html->link(__('Editar'), array('action' => 'edit',$dato['Moneda']['id']), array('class' => 'editar'))." | "; 
	  echo $this->Form->button(__($accion), array('class' => 'boton-sin', 'formaction' => Router::url(array('action' => $btnAccion,$dato['Moneda']['id'])))); 
	  } ?>
</td> 
</tr>
<?php $a++; } ?>
</table>

<?php echo $this->Form->end(); ?>

<p><?php echo $this->Paginator->counter(array('format' => ''.__("Página").' {:page} '.__("de").' {:pages}, '.__("mostrando").' {:current} '.__("registro de").' {:count}')); ?></p>

<div id="paging">
<?php echo $this->Paginator->prev('<'.__(" Anterior").' | ', array(), null, array('class' => 'prev disabled', 'escape' => false)); ?>
<?php echo $this->Paginator->numbers(array('separator' => ' - ')); ?>
<?php echo $this->Paginator->next('| '.__("Siguiente ").'>', array(), null, array('class' => 'next disabled', 'escape' => false)); ?>



</div>