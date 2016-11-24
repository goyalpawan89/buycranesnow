<?php echo __('Eliminar usuarios'); ?>

<?php echo $this->Form->create('User', array('action' => 'edit')); 
      echo $this->Form->input('names'); 
	  echo $this->Form->input('last_names'); 
	  echo $this->Form->input('id', array('type' => 'hidden')); 
	  echo $this->Form->end('Guardar cambios'); 

?>
