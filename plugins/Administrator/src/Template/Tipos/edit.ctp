<?php if($this->view=='Config_edit') {
	         $titulo = 'Editar'; $descrip = 'Edita los datos en caso de ser necesario.';  
			 $botonTipos1 = 'Actualizar tipo';
			 $botonTipos2 = 'Cambiar contraseña'; 
      } else { 
	         $titulo = 'Crear'; $descrip = 'Completa los campos para crear un nuevo tipo.'; 
			 $botonTipos1 = 'Generar tipo';
			 $botonTipos2 = $botonTipos1;		 
	  }  
	  ?>

<h1 id="principal" class="sinmargenabajo"><?php echo __($titulo.' tipo de documento'); ?></h1>
<p id="descripcion"><?php echo __($descrip); ?></p>


<div id="bloques">
<?php echo $this->Form->create('Tipo', array()); 
echo $this->Form->input('nuevo', array('type' => 'hidden', 'value' => 1)); ?>
<table id="losdatos">
<tr> 
<td width="300px" class="fondo colorblanco"><label for="Nombre"><?php echo __('Nombre'); ?></label></td>
<td>
<?php echo $this->Form->input('name', array('label' => false)); ?>
</td>
</tr>

<tr> 
<td width="300px" class="fondo colorblanco"><label for="Descripción"><?php echo __('Código'); ?></label></td>
<td>
<?php echo $this->Form->input('code', array('label' => false)); ?>
</td>
</tr>

<?php if($this->view=='Config_edit') { ?>
<tr>
<td class="fondo colorblanco"><label for=""><?php echo __('Estado'); ?></label></td>
<td><?php echo $this->Form->input('status',array('type'=>'select', 'options'=>$status, 'empty' => '- Selecciona una opción -', 'label' => false)); ?></td>
</tr>
<tr>
<td colspan="2"><?php echo $this->Form->end(__($botonTipos1, array('name' => 'actualizar'))); ?></td>
</tr>
<?php } else { ?>
<tr>
<td colspan="2"><?php echo $this->Form->end(__($botonTipos1, array('name' => 'actualizar'))); ?></td>
</tr>
<?php } ?>
</table>


</div>
