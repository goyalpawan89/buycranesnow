<?php if($this->view=='Edit' or $this->view=='edit') {
	         $titulo = 'Editar'; $descrip = 'Edita los datos en caso de ser necesario.';  
			 $botonMoneda1 = 'Actualizar moneda';
			 $botonMoneda2 = 'Cambiar contraseña'; 
      } else { 
	         $titulo = 'Agregar'; $descrip = 'Completa los campos para crear una nueva moneda.'; 
			 $botonMoneda1 = 'Crear Moneda';
			 $botonMoneda2 = $botonMoneda1;		 
	  }  
	  ?>

<h1 id="principal" class="sinmargenabajo"><?php echo __($titulo.' moneda'); ?></h1>
<p id="descripcion"><?php echo __($descrip); ?></p>


<div id="bloques">
<?php echo $this->Form->create($data, array()); 
//echo $this->Form->input('nuevo', array('type' => 'hidden', 'value' => 1)); ?>
<table id="losdatos">
<tr> 
<td width="300px" class="fondo colorblanco"><label for="name"><?php echo __('Nombre'); ?></label></td>
<td>
<?php echo $this->Form->input('name', array('label' => false)); ?>
</td>
</tr>
<tr> 
<td width="300px" class="fondo colorblanco"><label for="code"><?php echo __('Codigo'); ?></label></td>
<td>
<?php echo $this->Form->input('code', array('label' => false, 'onkeyup'=>'javascript:this.value=this.value.toUpperCase();', 'style'=>'text-transform:uppercase;')); ?> 
</td>
</tr>

<tr> 
<td width="300px" class="fondo colorblanco"><label for="usd"><?php echo __('Tasa de cambio a USD'); ?></label></td>
<td>
<?php echo $this->Form->input('usd', array('label' => false)); ?>
</td>
</tr>

<tr> 
<td width="300px" class="fondo colorblanco"><label for="default_trm"><?php echo __('TRM'); ?></label></td>
<td>
<?php echo $this->Form->input('default_trm', array('label' => false)); ?>
</td>
</tr>


<?php if($this->view=='Edit' or $this->view=='edit') { ?>
	<tr> 
	<td width="300px" class="fondo colorblanco"><label for="value_trm"><?php echo __('Valor Final Incremento'); ?></label></td>
	<td>
	<?php echo $this->Form->input('value_trm', array('label' => false, 'disabled')); ?>
	</td>
	</tr>

	<tr>
	<td class="fondo colorblanco"><label for=""><?php echo __('Estado'); ?></label></td>
	<td><?php echo $this->Form->input('status',array('type'=>'select', 'options'=>$status,  'empty' => '- Selecciona una opción -', 'label' => false)); ?></td>
	</tr>
<?php }?>
	
	<tr>
		<td colspan="2">
		<?= $this->Form->button(__($botonMoneda1), ['id'=>'button']); ?>
		</td>
	</tr>

</table>

<?php echo $this->Form->end(); ?>
</div>
