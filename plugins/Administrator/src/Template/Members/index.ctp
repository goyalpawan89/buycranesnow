<?php  if($this->view== 'index') { $nombre = 'Estudiante'; } elseif($this->view== 'fathers')  { $nombre = 'Padre'; } else { $nombre = 'Orientador'; } ?> 
      
<table>
<tr>
<th><?php echo $this->paginator->sort('name', __('Nombre ' . $nombre)); ?></th>
<th><?php echo $this->paginator->sort('shcool_id', __('Colegio')); ?></th>
<?php if($this->view== 'index') { ?>
<th><?php echo $this->paginator->sort('course', __('Grado')); ?></th>
<th><?php echo $this->paginator->sort('age', __('Edad')); ?></th>
<?php } ?>
<th><?php echo $this->paginator->sort('worshop_id', __('Talleres / Asistió')); ?></th>
<th><?php echo $this->paginator->sort(__('Acciones')); ?></th>
</tr>
<?php foreach($estudiantes as $estudiante) { ?>
<tr>
<td><?php echo $this->Html->link($estudiante['Member']['name'], array('action' => 'edit',$estudiante['Member']['id'])); ?></td>
<td><?php echo $estudiante['School']['name']; ?></td>
<?php if($this->view== 'index') { ?>
<td><?php echo $estudiante['Member']['course']; ?></td>
<td><?php echo $estudiante['Member']['age']; echo __(' Años'); ?></td>
<?php } ?>
<td>
   
   <?php $a=1; foreach($estudiante['Relation'] as $relacion) { $datosTaller = $this->requestAction('App/autoCompDatosTaller/'.$relacion['workshop_id']);
      if($relacion['member_id']==$estudiante['Member']['id']) { ?>
   <span title="<?php echo $datosTaller['Workshop']['name']; ?>" style="cursor:pointer;"><?php echo __('Taller '); echo $a; ?> | </span>
   <?php } $a++; } ?>
   
</td>
<td><?php echo $this->Html->link(__('Editar'), array('action' => 'edit',$estudiante['Member']['id'])); ?> | 
<?php if($this->view== 'index') { echo $this->Html->link(__('Sondeo'), array('action' => 'sondeo',$estudiante['Member']['id'])). " | "; } ?> 
<?php echo $this->form->postLink(__('Borrar'), array('action' => 'delete',$estudiante['Member']['id']), array('confirm' => __('Desea eliminar a '.$estudiante['Member']['name'] .'?') )); ?>
</td> 
</tr>
<?php } ?>
</table>

<p><?php echo $this->Paginator->counter(array('format' => ''.__("Página").' {:page} '.__("de").' {:pages}, '.__("mostrando").' {:current} '.__("registro de").' {:count}')); ?></p>

<div id="paging">
<?php echo $this->Paginator->prev('< '.__("Anterior").'', array(), null, array('class' => 'prev disabled')); ?>
<?php echo $this->Paginator->numbers(array('separator' => ' - ')); ?>
<?php echo $this->Paginator->next(' '.__("Siguiente").' >', array(), null, array('class' => 'next disabled')); ?>
</div>

<br />
<article style="float:left; ">
<?php echo $this->Form->create('Member', array('action' => 'excel/'.$idColegio));
      echo $this->Form->input('integrante', array('type' => 'hidden', 'value' => $nombre));  
      echo $this->Form->end(__('Generar excel '.$nombre, array('name' => 'crear'))); ?>
	  </article>
      
      <article style="float:left; ">
      <?php echo $this->Form->create('Member', array('action' => 'excel/'.$idColegio));
      echo $this->Form->input('integrante', array('type' => 'hidden', 'value' => 'Todos'));  
      echo $this->Form->end(__('Generar excel Todos los integrantes', array('name' => 'crear'))); ?>
	  </article>