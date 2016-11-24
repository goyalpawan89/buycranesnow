<?php        
	$titulo = 'Sincronizar'; 
	$descrip = 'Selecciona lo que deseas sincronizar.'; 
	$botonTrms1 = 'Actualizar';
	$botonTrms2 = $botonTrms1;		 
 ?>

<h1 id="principal" class="sinmargenabajo"><?php echo __($titulo.' TRM'); ?></h1>
<p id="descripcion"><?php echo __($descrip); ?></p>


<div class='item'>
	<article class='item1'>
	<aside class='border'>
	    <aside><h2 style='text-align:center;'><?php echo __('Todas las rutas'); ?></h2></aside>
	    
	    <aside style='text-align:center;'>
	    <i class="fa fa-cog fa-4x fa-spin"></i>
	    <div id="counter-up">0</div>
		</aside>


		<aside class='separador'>
		<?php foreach($totales as $key=>$conteo){?>
	    
	    	<h3><?php echo ' <b>Ciclo '.$key.': </b>'.$conteo; ?> </h3>
		<?php }?>
		</aside>
		


	</aside>
	</article>

	<article class='item1'>
	 <div id="container" class='border' style="height: 400px; margin: 0 auto"></div>
	</article>
	<article class='item2'>
	 <div id="container" class='border' style="height: 400px; margin: 0 auto"></div>
	</article>
</div>






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
