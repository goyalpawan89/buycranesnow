<!-- $controllerText (palabras especificas), $extras (palabras generales), $imagesText (palabras para la seccion imagenes) llamado desde component TextsComponent -> appcontroller textos del .ctp -->

<?php //echo pr($post);?>

<h1 id="principal"><?php echo __($controllerText['title']); ?></h1>
<p id="descripcion"><?php echo __($controllerText['description']); ?></p>

<?php echo $this->Form->create($files, array('id' => 'upload22', 'enctype' => 'multipart/form-data')); ?>
<?php echo $this->element('upload_fields/upload_thumbnail');?>
<?php echo $this->Form->input(__($imagesText['button']), array('type' => 'submit', 'label' => false)); ?>
<?php echo $this->Form->end(); ?>






