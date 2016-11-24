<?php  

	//echo $this->fetch('content');
$titulo = "Reporte ".date("F j, Y, g:i a")."";


header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$titulo.'.xls"');
header('Cache-Control: max-age=0');

//echo pr($usuarios);


?>


<table cellpadding="0" cellspacing="0" border="0"  class="display" id="example">
	<thead>
		<tr>
			<th>UID</th>
			<th>Ciclo</th>
			<th>Ciudad</th>
			<th>Usuario</th>
			<th>Nombre</th>
			<th>Propietario</th>
			<th>Dirección</th>
			<th>Telefono</th>
			<th>Celular</th>
			<th>Email</th>
			<th>Cuenta Con</th>
			<th>Empleados</th>
			<th>Observaciones</th>


			<?php /*foreach($productos as $key=>$dato){ ?>
			<th><?php echo $dato->name;?></th>			
			<?php } */?>
		</tr>
	</thead>
	<tbody>
		
		<?php 
		
		$conteo=1;
		foreach($usuarios as $dato){?>
		
		<tr>
			<td><?php echo $dato->uid;?></td>
			<td><?php echo $dato->ciclo;?></td>
			<td><?php echo $dato->ciudad;?></td>
			<td><?php echo $dato->usuario;?></td>
			<td><?php echo $dato->nombre;?></td>
			<td><?php echo $dato->propietario;?></td>
			<td><?php echo $dato->direccion;?></td>
			<td><?php echo $dato->telefono;?></td>
			<td><?php echo $dato->telCelular;?></td>
			<td><?php echo $dato->email;?></td>
			<td><?php 
				if($dato->cuentaCon=='1'){
					$cuentaCon='Colgate total 12 encías saludables';
					}elseif($dato->cuentaCon=='1,2'){
					$cuentaCon='Colgate total 12 encías saludables y Parodontax';
					}elseif($dato->cuentaCon=='2'){
					$cuentaCon='Parodontax';
					}else{
					$cuentaCon='No tiene productos';
					}
					 echo $cuentaCon;?>
			</td>
			<td><?php echo $dato->numeroEmpleados;?></td>
			<td><?php echo $dato->Observaciones;?></td>
			<?php 

			//$existen=explode(',',$dato['data'][0]['productos']);
			//echo pr($existen);
			/*foreach($productos as $key=>$producto){ 
				 

		if(in_array($producto->id,$existen)){
					$producto='Existe';
				}else{
					$producto='No Existe';
				}

				 	?>
			<td><?php echo $producto;?></td>			
			<?php }*/
			?>
		</tr>
		
		<?php $conteo++;}?>
		
	</tbody>
	<tfoot>
		<tr>
			<th>UID</th>
			<th>Ciclo</th>
			<th>Ciudad</th>
			<th>Usuario</th>
			<th>Nombre</th>
			<th>Propietario</th>
			<th>Dirección</th>
			<th>Telefono</th>
			<th>Celular</th>
			<th>Email</th>
			<th>Cuenta Con</th>
			<th>Empleados</th>
			<th>Observaciones</th>
			<?php /*foreach($productos as $key=>$dato){ ?>
			<th><?php echo $dato->name;?></th>			
			<?php } */?>

		</tr>
	</tfoot>
</table>
