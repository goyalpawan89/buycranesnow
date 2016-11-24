
<?php 

//echo pr($this->request->params);
if($this->view=='index') { 
	  $titulo='Listado de logs';
	  $msj='Total de usuario: ';
	  }

if($this->request->params['action']=='logs'){
 	$titulo='Logs del usuario: '.$usuario->name;
 	$msj='Total Logs de usuario: ';
}

//echo pr($categorias);
?>

<h1 id="principal"><?php echo __($titulo); ?></h1>

<?php echo $this->Form->create('User', array()); ?>

<aside class="right">
    <aside class="right" style="margin:3px 0;"><?php echo __($msj.' '.$todos); ?></aside><br />
   
</aside>

<table>
<tr class="fondo">
<th width="20" align="center"><?php echo $this->Form->checkbox('select-all', array('hiddenField' => false, 'id' => 'select-all', 'class' => 'check')); ?></th>
<th width="15%"><?php echo $this->paginator->sort('name', __('Usuario')); ?></th>

<?php if($this->request->params['action']!='logs'){?>
	<th><?php echo $this->paginator->sort('rank', __('Posición')); ?></th>
	<th><?php echo $this->paginator->sort('rank', __('Puntaje')); ?></th>
<?php } ?>

<th><?php echo $this->paginator->sort('', __('Acción')); ?></th>
<th><?php echo $this->paginator->sort('created', __('Fecha de creación')); ?></th>
<th><?php echo $this->paginator->sort('Acciones'); ?></th>
</tr>

<?php $a=1; foreach($categorias as $k => $cats) { 

//echo pr($cats); ?>
<tr>
<td width="20" align="center">
<?php echo $this->Form->checkbox('checkbox', array('name' => 'checkbox[]', 'value' => $cats->id, 'hiddenField' => false, 'id' => 'checkbox-'.$a, 'class' => 'check'));  ?>
</td>
<?php if($this->request->params['action']!='logs'){?>
	<td><?php echo $cats->name; ?></td>
<?php }else{ ?>
	<td><?php echo $cats->player->name; ?></td>
<?php } ?>

<?php if($this->request->params['action']!='logs'){?>
	<td><?php echo $a; ?></td>
	<td><?php echo $cats->rank; ?></td>
<?php } ?>
<?php if($this->request->params['action']!='logs'){?>
	<td><?php 
	$logs=count($cats->logs);
	echo $cats->logs[$logs-1]->action; ?></td>
	<td><?php echo $cats->logs[$logs-1]->created; ?></td>
<?php }else{?>
	<td><?php 
	echo $cats->action; ?></td>
	<td><?php echo $cats->created; ?></td>

<?php } ?>

<td width='15%'>
<?php 

if($this->request->params['action']!='logs'){

	$id=$cats->id;
	  echo $this->Form->button('<i class="fa fa-search"></i>', array('class' => 'active icono', 'title'=>'Ver todos los logs',
	  	'formaction' => $this->Url->build(["action" => "logs", $cats->id])));
	}else{
		$id=$usuario->id;
	}
	  echo $this->Form->button('<i class="fa fa-code"></i>', array('class' => 'active icono', 'title'=>'Codigos Ingresados',
	  	'formaction' => $this->Url->build(["action" => "codes", $id])));
	  echo $this->Form->button('<i class="fa fa-trophy"></i>', array('class' => 'active icono', 'title'=>'Retos Cumplidos',
	  	'formaction' => $this->Url->build(["action" => "retos", $id]))); 
	 
	   ?>
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
