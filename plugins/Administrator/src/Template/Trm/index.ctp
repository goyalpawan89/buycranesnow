<?php        
	$titulo = 'Actualizar'; 
	$descrip = 'Actualiza los datos si deseas cambiar los valores de la TRM.'; 
	$botonTrms1 = 'Actualizar';
	$botonTrms2 = $botonTrms1;		 
 ?>

<h1 id="principal" class="sinmargenabajo"><?php echo __($titulo.' valor TRM'); ?></h1>
<p id="descripcion"><?php echo __($descrip); ?></p>


<div id="bloques">
<?php echo $this->Form->create('Trm', array()); 
echo $this->Form->input('nuevo', array('type' => 'hidden', 'value' => 1)); ?>
<table id="losdatos">
<tr> 
<td width="300px" class="fondo colorblanco"><label for="Nombre"><?php echo __('Porcentaje %'); ?></label></td>
<td>
<?php echo $this->Form->input('name', array('label' => false)); ?>
</td>
</tr>

<tr> 
<td width="300px" class="fondo colorblanco"><label for="Descripción"><?php echo __('Valor'); ?></label></td>
<td>
<?php echo $this->Form->input('code', array('label' => false)); ?>
</td>
</tr>


<tr>
<td colspan="2"><?php echo $this->Form->end(__($botonTrms1, array('name' => 'actualizar'))); ?></td>
</tr>

</table>


</div>
