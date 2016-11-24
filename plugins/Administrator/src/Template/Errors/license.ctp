<center>

<div id='logo'><?php echo $this->Html->image($informacion['logo'], array("width" => "60%", "alt" => "Logo")) ;?>

</div></center>

<div id="login">
<center>


<?php echo $this->Form->create('License'); ?>
	
	<label for="usuario"><?php echo __('Licencia'); ?></label>
	<div id='user'>
	<i class="fa fa-key fa-2x pull-left fa-border" style="padding: 9px 0px 0px 16px;"></i>
	<?php echo $this->Form->input('key', array('label' => false, 'placeholder' => '', 'class' => 'form-control', 'required' => 'required')); ?>	
	</div>
	
	
	<p><button type="submit"><?php echo __('Cambiar'); ?></button></p>
	<?php echo $this->Form->end(); ?>
	


</center>
</div>



