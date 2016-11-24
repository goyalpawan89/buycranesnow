
<?php 

	  $titulo='Códigos logs: '.$usuario->name;
	  $msj='Total de usuario: ';


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


<th><?php echo $this->paginator->sort('action', __('Código')); ?></th>
<th><?php echo $this->paginator->sort('created', __('Fecha de creación')); ?></th>
<th><?php echo $this->paginator->sort('Acciones'); ?></th>
</tr>

<?php $a=1; foreach($categorias as $k => $cats) { 

//echo pr($cats); ?>
<tr>
<td width="20" align="center">
<?php echo $this->Form->checkbox('checkbox', array('name' => 'checkbox[]', 'value' => $cats->id, 'hiddenField' => false, 'id' => 'checkbox-'.$a, 'class' => 'check'));  ?>
</td>

	<td><?php echo $usuario->name; ?></td>
	
	<td><?php 
	$codigo=explode('código ', $cats->action);
	echo $codigo[1]; ?></td>
	<td><?php echo $cats->created; ?></td>

<td width='15%'>
<?php 

	

	$id=$cats->id;
	  echo $this->Form->button('<i class="fa fa-search"></i>', array('class' => 'active icono', 'title'=>'Ver todos los logs',
	  	'formaction' => $this->Url->build(["action" => "logs", $cats->id])));
	
	$id=$usuario->id;
	
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
