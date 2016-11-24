
<?php if($this->view=='index') { 
      $botonPapelera = 'Mandar a papelera'; 
	  $titulo='Códigos activos';
	  } else {
      $botonPapelera = 'Restaurar codigos'; 	  
      $titulo='Códigos inactivos';
	  } 
//echo pr($categorias);
?>

<h1 id="principal"><?php echo __($titulo); ?></h1>

<?php echo $this->Form->create('User', array()); ?>

<aside class="left"><?php echo $this->Form->input($botonPapelera, array('type' => 'submit', 'label' => false, 'class' => 'trash')); ?></aside>

<aside class="right">
    <aside class="right" style="margin:3px 0;"><?php echo __('Todos los códigos: '.$todos); ?></aside><br />
    <aside class="right">
	<?php echo $this->Html->link('Códigos activos: '.$conteo, array('action' => 'index'), array('class' => 'color colorgrish')); ?> | 
	<?php echo $this->Html->link('Códigos inactivos: '.$inactivos, array('action' => 'trash'), array('class' => 'color colorgrish')); ?>
    </aside>
</aside>

<table>
<tr class="fondo">
<th width="20" align="center"><?php echo $this->Form->checkbox('select-all', array('hiddenField' => false, 'id' => 'select-all', 'class' => 'check')); ?></th>
<th width="35%"><?php echo $this->paginator->sort('value', __('Código')); ?></th>
<th><?php echo $this->paginator->sort('type', __('Tipo')); ?></th>
<th><?php echo $this->paginator->sort('metodo', __('Metodo')); ?></th>
<th><?php echo $this->paginator->sort(__('Retos')); ?></th>
<th><?php echo $this->paginator->sort('Acciones'); ?></th>
</tr>

<?php $a=1; foreach($categorias as $k => $cats) {  ?>
<tr>
<td width="20" align="center">
<?php echo $this->Form->checkbox('checkbox', array('name' => 'checkbox[]', 'value' => $cats->id, 'hiddenField' => false, 'id' => 'checkbox-'.$a, 'class' => 'check'));  ?>
</td>
<td><?php echo $cats->value; ?> </td>
<td><?php echo $cats->type; ?></td>
<td><?php echo $cats->metodo; ?></td>
<td><?php foreach($cats->posts as $key => $value){

echo $this->Html->link($value->name, ['controller'=>'Posts', 'action' => 'edit',$value->id]);
}
 ?></td>
<td>
<?php if($this->view=='trash') { 
      echo $this->Form->button('<i class="fa fa-check"></i>', array('class' => 'active', 'title'=>'Restaurar', 'formaction' => $this->Url->build(array('action' => 'restore',$cats->id))));

      } else {
	  echo $this->Form->button('<i class="fa fa-trash"></i>', array('class' => 'active', 'title'=>'Enviar a Papelera',
	  	'formaction' => $this->Url->build(["action" => "clear", $cats->id]))
	  	);
	 
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
