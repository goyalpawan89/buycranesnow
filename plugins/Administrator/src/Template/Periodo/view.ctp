<?php 
if($this->view=='Config_view' or $this->view=='Config_index') { 
      $botonPapelera = 'Enviar a papelera'; 
	  $btnAccion='clear';
	  $accion='Enviar a papelera';
	  } else {
      $botonPapelera = 'Restaurar periodo';
	  $btnAccion='active';
	  $accion='Activar'; 	  
	  } 
?>

<h1 id="principal"><?php echo __('Periodo'); ?></h1>

<?php echo $this->Form->create('Periodo', array()); ?>

<aside class="left"><?php echo $this->Form->input(__($botonPapelera), array('type' => 'submit', 'label' => false, 'class' => 'trash')); ?></aside>

<aside class="right">
    <aside class="right" style="margin:3px 0;"><?php echo __('Todos los Periodos: '.$todos); ?></aside><br />
    <aside class="right">
	<?php echo $this->Html->link('Periodos activos: '.$conteo, array('action' => 'index'), array('class' => 'color colorgrish')); ?> | 
	<?php echo $this->Html->link('Periodos inactivos: '.$inactivos, array('action' => 'trash'), array('class' => 'color colorgrish')); ?>
    </aside>
</aside>

<table>
<tr class="fondo">
<th width="20" align="center">
<?php echo $this->Form->checkbox('select-all', array('hiddenField' => false, 'id' => 'select-all', 'class' => 'check')); ?>
</th>
<th><?php echo $this->paginator->sort('name', __('Nombre')); ?></th>
<th><?php echo $this->paginator->sort('modified', __('Fecha modificación')); ?></th>
<th><?php echo $this->paginator->sort('created', __('Fecha creación')); ?></th>
<th><?php echo $this->paginator->sort(__('Acciones')); ?></th>
</tr>
<?php $a=1; foreach($datos as $dato) { ?>
<tr>
<td width="20" align="center">
<?php echo $this->Form->checkbox('checkbox', array('name' => 'data[Periodo][checkbox][]', 'value' => $dato['Periodo']['id'], 'hiddenField' => false, 'id' => 'checkbox-'.$a, 'class' => 'check'));  ?>
</td>
<td>
<?php echo $this->Html->link($dato['Periodo']['name'], array('action' => 'edit', $dato['Periodo']['id'])); ?></td>
<td><?php echo $dato['Periodo']['modified']; ?></td>
<td><?php echo $dato['Periodo']['created']; ?></td>
<td>
<?php if($this->view=='trash') { 
      echo $this->Form->button(__('Restaurar'), array('class' => 'boton-sin', 'formaction' => Router::url(array('controller' => 'Periodo','action' => 'restore',$dato['Periodo']['id']))))." | ";
	  echo $this->Form->button(__('Eliminar'), array('class' => 'boton-sin', 'formaction' => Router::url(array('controller' => 'Periodo','action' => 'delete',$dato['Periodo']['id']))));
      } else {
	  echo $this->Html->link(__('Editar'), array('action' => 'edit',$dato['Periodo']['id']), array('class' => 'editar'))." | "; 
	  echo $this->Form->button(__($accion), array('class' => 'boton-sin', 'formaction' => Router::url(array('action' => $btnAccion,$dato['Periodo']['id'])))); 
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