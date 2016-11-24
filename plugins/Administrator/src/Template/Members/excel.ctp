<?php  

$titulo = "Listado integrantes ".date('F j, Y, g:i a');
header('Content-Type: application/vnd.ms-excel; charset=UTF-8'); // This should work for IE & Opera
header("Content-type: application/x-msexcel; charset=UTF-8"); // This should work for the rest
header('Content-Disposition: attachment;filename="'.$titulo.'.xls"');
header('Cache-Control: max-age=0');

?>
<meta http-equiv="content-type" content="application/xhtml+xml; charset=UTF-8" />

<?php $tipo = $_POST['data']['Member']['integrante']; 
      if($tipo=='Estudiante') { $nombre = 'Estudiante'; } elseif($tipo=='Padre') { $nombre = 'Padre'; } elseif($tipo=='Orientador') { $nombre = 'Orientador'; } else { $nombre = 'Todos'; } ?>

<table>
<tr>
<th><?php echo __('Nombre '.$nombre); ?></th>
<th><?php echo __('Colegio'); ?></th>
<?php if($tipo=='Estudiante') { ?>
<th><?php echo __('Grado'); ?></th>
<th><?php echo __('Edad'); ?></th>
<?php } ?>
<th><?php echo __('Tipo integrante'); ?></th>
<th><?php echo __('Talleres / Asistió'); ?></th>
</tr>
<?php foreach($estudiantes as $estudiante) {
	  if($tipo==$estudiante['Member']['type']) { //filtrar por tipo de integrante ?>
<tr>
<td><?php echo $estudiante['Member']['name']; ?></td>
<td><?php echo $estudiante['School']['name']; ?></td>
<?php if($tipo=='Estudiante') { ?>
<td><?php echo $estudiante['Member']['course']; ?></td>
<td><?php echo $estudiante['Member']['age']; echo __(' Años'); ?></td>
<td><?php echo $estudiante['Member']['type']; ?></td>
<?php } ?>
<td>
   <?php $a=1; foreach($estudiante['Relation'] as $relacion) { $datosTaller = $this->requestAction('App/autoCompDatosTaller/'.$relacion['workshop_id']);
      if($relacion['member_id']==$estudiante['Member']['id']) { ?>
   <span title="<?php echo $datosTaller['Workshop']['name']; ?>" style="cursor:pointer;"><?php echo __('Taller '); echo $a; ?> | </span>
   <?php } $a++; } ?>
</td>
</tr>
<?php } elseif($tipo=='Todos') { ?>

<tr>
<td><?php echo $estudiante['Member']['name']; ?></td>
<td><?php echo $estudiante['School']['name']; ?></td>
<?php if($tipo=='Estudiante') { ?>
<td><?php echo $estudiante['Member']['course']; ?></td>
<td><?php echo $estudiante['Member']['age']; echo __(' Años'); ?></td>
<td><?php echo $estudiante['Member']['type']; ?></td>
<?php } ?>
<td>
   <?php $a=1; foreach($estudiante['Relation'] as $relacion) { $datosTaller = $this->requestAction('App/autoCompDatosTaller/'.$relacion['workshop_id']);
      if($relacion['member_id']==$estudiante['Member']['id']) { ?>
   <span title="<?php echo $datosTaller['Workshop']['name']; ?>" style="cursor:pointer;"><?php echo __('Taller '); echo $a; ?> | </span>
   <?php } $a++; } ?>
</td>
</tr>

<?php } } ?>
</table>
