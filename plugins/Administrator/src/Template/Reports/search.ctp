<?php 
    $titulo = 'Buscar'; $descrip = 'Ingresa los datos necesarios para tu informe.';  
	$botonAcomodacion1 = 'Buscar';?>

  <link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
  <script>
  $(function() {
    var availableTags = [
  	
  	<?php 

  	foreach($listado as $city){
		echo '"'.$city.'",';
		
	}?>
	
    ];
    $( "#tags" ).autocomplete({
      source: availableTags
    });
  });
  
  $(function() {
    var availableTags2 = [
    
    <?php 

    foreach($usuarios as $user){
    echo '"'.$user.'",';
    
  }?>
  
    ];
    $( "#tags2" ).autocomplete({
      source: availableTags2
    });
  });
  </script>

<h1 id="principal" class="sinmargenabajo"><?php echo __($titulo) ?></h1>
<p id="descripcion"><?php echo __($descrip); ?></p>


<div id="bloques">
<?php echo $this->Form->create(null,['url' => ['controller' => 'Rutas', 'action' => 'search']]);  ?>
<table id="losdatos">

<?php $input=array('Ciclo', 'Ciudad', 'Ruta','Usuario', 'Inicial','Final');
foreach($input as $key=> $dato){ 
	if($dato=='Ciudad'){
		$var='tags';
	}elseif($dato=='Usuario'){
    $var='tags2';
  }elseif($dato=='Inicial'){
		$var='datepicker';
	}elseif($dato=='Final'){
		$var='datepicker1';
	}else{
		$var='';
	}
	

  if($dato=='Ruta' or $dato=='Inicial' or $dato=='Final' or $dato=='Usuario'){
    $required='';
  }else{
    $required='required';
  }

	?>
	<tr> 
	<td width="300px" class="fondo colorblanco"><label for="Nombre"><?php echo __($dato); ?></label></td>
	<td>
	<?php echo $this->Form->input($dato, array('label' => false, 'type'=>'text', 'id'=>$var, $required)); ?>
	</td>
	</tr>
<?php 
 } ?>

<tr>
<td colspan="2"><?= $this->Form->button(__($botonAcomodacion1), ['id'=>'button']); ?></td>
</tr>
</table>
<?php echo $this->Form->end(); ?>

</div>




<script>
  $(function() {

    var fechaIn;

    $( "#date" ).datepicker({
    dateFormat: "yy-mm-dd",
    monthNames: [ "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre" ],
    dayNamesMin: [ "Do", "Lu", "Ma", "Mie", "Ju", "Vi", "Sa" ],
    showWeek: true,
    maxDate: "+1y",
    minDate: "+3d",
  });

  $( "#date" ).change(function() {
    // Check input( $( this ).val() ) for validity here
    fechaIn = $(this).val();
    $( "#fechaOut" ).val(fechaIn);


    $( "#fechaOut" ).datepicker({
      dateFormat: "yy-mm-dd",
      monthNames: [ "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre" ],
      dayNamesMin: [ "Do", "Lu", "Ma", "Mie", "Ju", "Vi", "Sa" ],
      maxDate: "+1y",
      minDate: fechaIn,
       
    });

    console.log(fechaIn);
  }); 

   
  });
  </script>