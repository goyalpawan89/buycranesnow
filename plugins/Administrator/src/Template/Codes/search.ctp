<!-- $controllerText (palabras especificas), $extras (palabras generales), $imagesText (palabras para la seccion imagenes) llamado desde component TextsComponent -> appcontroller textos del .ctp -->
     
<?php if(isset($codigos)){?>
<article>
  <pre>
<?php echo print_r($codigos); ?>
</pre>
</article>
<?php } ?>

<h1 id="principal" class="sinmargenabajo"><?php echo __($controllerText['title']); ?></h1>
<p id="descripcion"><?php echo __($controllerText['description']); ?></p>

<?php echo $this->Form->create('search', array( 'id'=>'upload')); ?>

<div class="flexbox">

	        <?php echo $this->Form->input('search', array('label' => false, 'placeholder' => $controllerText['title_placeholder'], 'required'));  ?>
 	                                 
		            	  
		<table id="adicional">
            <tr>
            	<td><?php echo $this->Form->input(__($controllerText['submit']), array('type' => 'submit', 'label' => false)); ?> </td>
            </tr>
        </table>
		            	


</div>

<?php echo $this->Form->end(); ?>



<?php if(isset($categorias)){?>
<?php echo $this->Form->create('User', array()); ?>
<table>
<tr class="fondo">
<th width="20" align="center"><?php echo $this->Form->checkbox('select-all', array('hiddenField' => false, 'id' => 'select-all', 'class' => 'check')); ?></th>
<th width="35%"><?php echo $this->paginator->sort('value', __('Código')); ?></th>
<th><?php echo $this->paginator->sort('type', __('Tipo')); ?></th>
<th><?php echo $this->paginator->sort('metodo', __('Metodo')); ?></th>
<th><?php echo $this->paginator->sort('status', __('Estado')); ?></th>
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
<td><?php echo $cats->status; ?></td>
<td><?php foreach($cats->posts as $key => $value){

echo $this->Html->link($value->name, ['controller'=>'Posts', 'action' => 'edit',$value->id]);
}
 ?></td>
<td>
<?php 
    echo $this->Form->button('<i class="fa fa-trash"></i>', array('class' => 'active', 'title'=>'Enviar a Papelera',
      'formaction' => $this->Url->build(["action" => "clear", $cats->id]))
      );
   
     ?>
</td>
</tr>
<?php $a++; } ?>
</table>
<?php echo $this->Form->end(); ?>

<?php } ?>




