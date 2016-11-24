<?php  

$titulo = "Reporte Usuarios ".date('F j, Y, g:i a');
header('Content-Type: application/vnd.ms-excel; charset=UTF-8'); // This should work for IE & Opera
header("Content-type: application/x-msexcel; charset=UTF-8"); // This should work for the rest
header('Content-Disposition: attachment;filename="'.$titulo.'.xls"');
header('Cache-Control: max-age=0');

?>
<meta http-equiv="content-type" content="application/xhtml+xml; charset=UTF-8" />

<table>
<tr>
<th><?php echo __d('administrator', 'Nombres'); ?></th>
<th><?php echo __d('administrator', 'Documento'); ?></th>
<th><?php echo __d('administrator', 'Tipo de usuario'); ?></th>
<th><?php echo __d('administrator', 'Equipo de trabajo'); ?></th>
<th><?php echo __d('administrator', 'Estado'); ?></th>
<th><?php echo __d('administrator', 'Fecha modificación'); ?></th>
<th><?php echo __d('administrator', 'Fecha creación'); ?></th>
</tr>
<?php foreach($usuarios as $usuario) { ?>
<tr>
<td><?php echo $usuario['User']['first_name']; ?></td>
<td><?php echo $usuario['User']['identification']; ?></td>
<td><?php echo chr(255).chr(254).iconv("UTF-8", "UTF-16LE//IGNORE", $usuario['Role']['name']);  ?></td>
<td><?php echo $usuario['Team']['name']; ?></td>
<td><?php echo $usuario['User']['status']; ?></td>
<td><?php echo $usuario['User']['modified']; ?></td>
<td><?php echo $usuario['User']['created']; ?></td>
</tr>
<?php } ?>
</table>


