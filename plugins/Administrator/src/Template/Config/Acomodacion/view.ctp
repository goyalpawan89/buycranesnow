<?php 
if($this->view=='Config_view' or $this->view=='Config_index') { 
      $botonPapelera = 'Enviar a papelera'; 
	  $btnAccion='clear';
	  $accion='Enviar a papelera';
	  } else {
      $botonPapelera = 'Restaurar acomodación';
	  $btnAccion='active';
	  $accion='Activar'; 	  
	  } 

   /* echo $this->view;
    echo $this->name;
    echo pr($this->request->params);*/
?>

<h1 id="principal"><?php echo __('Acomodación'); ?></h1>

<?php echo $this->Form->create('Acomodacion', array()); ?>

<aside class="left"><?php echo $this->Form->input(__($botonPapelera), array('type' => 'submit', 'label' => false, 'class' => 'trash')); ?></aside>

<aside class="right">
    <aside class="right" style="margin:3px 0;"><?php echo __('Todas las acomodaciones: '.$todos); ?></aside><br />
    <aside class="right">
	<?php echo $this->Html->link('Acomodaciones activas: '.$activos, array('action' => 'index'), array('class' => 'color colorgrish')); ?> | 
	<?php echo $this->Html->link('Acomodaciones inactivas: '.$inactivos, array('action' => 'trash'), array('class' => 'color colorgrish')); ?>
    </aside>
</aside>

<table>
<tr class="fondo">
<th width="20" align="center">
<?php echo $this->Form->checkbox('select-all', array('hiddenField' => false, 'id' => 'select-all', 'class' => 'check')); ?>
</th>
<th><?php echo $this->paginator->sort('name', __('Nombre')); ?></th>
<th><?php echo $this->paginator->sort('description', __('Descripción')); ?></th>
<th><?php echo $this->paginator->sort('modified', __('Fecha modificación')); ?></th>
<th><?php echo $this->paginator->sort('created', __('Fecha creación')); ?></th>
<th><?php echo $this->paginator->sort(__('Acciones')); ?></th>
</tr>
<?php $a=1; foreach($datos as $dato) { ?>
<tr>
<td width="20" align="center">
<?php echo $this->Form->checkbox('checkbox', array('name' => 'checkbox[]', 'value' => $dato->id, 'hiddenField' => false, 'id' => 'checkbox-'.$a, 'class' => 'check'));  ?>
</td>
<td>
<?php echo $this->Html->link($dato->name, array('action' => 'edit', $dato->id)); ?></td>
<td><?php 

echo $this->Text->truncate(
    $dato->description,
    90,
    [
        'ellipsis' => '...',
        'exact' => false,
        'html' => false
    ]
);

?></td>
<td><?php echo $dato->modified; ?></td>
<td><?php echo $dato->created; ?></td>
<td>
<?php if($this->view=='trash') { 
      echo $this->Form->button(__('Restaurar'), array('class' => 'boton-sin', 'formaction' => Router::url(array('controller' => 'Acomodacion','action' => 'restore',$dato['Acomodacion']['id']))))." | ";
	  echo $this->Form->button(__('Eliminar'), array('class' => 'boton-sin', 'formaction' => Router::url(array('controller' => 'Acomodacion','action' => 'delete',$dato['Acomodacion']['id']))));
      } else {
	  echo $this->Html->link(__('Editar'), array('action' => 'edit',$dato->id), array('class' => 'editar'))." | "; 
	  echo $this->Form->button(__($accion), array('class' => 'boton-sin', 
      'formaction' => $this->Url->build(["action" => "clear", $dato->id]))); 
	  } ?>
</td> 
</tr>
<?php $a++; } ?>
</table>

<?php echo $this->Form->end(); ?>

<p><?php echo $this->Paginator->counter(['format' => ''.__("Página").' {{page}} '.__("de").' {{pages}}, '.__("mostrando").' {{current}} '.__("registro de").' {{count}}']);?></p>

<div id="paging">
<?php echo $this->Paginator->prev('<< '.__(" Anterior").' | '); ?>
<?php echo $this->Paginator->numbers(['separator' => ' - ']); ?>
<?php echo $this->Paginator->next('| '.__("Siguiente ").' >>'); ?>
</div>