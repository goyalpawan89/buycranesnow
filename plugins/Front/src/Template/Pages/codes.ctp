<div class="page-codes">
	<h2 style='width:75%;'><?php echo $page->excerpt;?></h2>

	<?php echo $file = $this->requestAction('Administrator.File/getThumbUrl', ['id'=>$page->file_id, 'size'=>'thumbnail']); ?>

	<?php echo $this->Form->create('codigos', ['class'=>'codigos']);  ?> 
		<b><?php echo $this->Form->input('code',['required'=>'required', 'class'=>'form', 'autocomplete'=>'off', 'type'=>'text', 'label'=>false]); ?></b>
		<?= $this->Form->button(__('Registrar'), ['class'=>'entrar']); ?>
	<?php echo $this->Form->end(); ?>

</div>
 