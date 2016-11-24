
<div id="homepage">
<?php if($this->view=='edit') { $text1 = 'Editar'; } else { $text1 = 'Generar'; } 
      echo "<h2>".__($text1. ' integrante en el colegio: ') . $datosSchool['School']['name']."</h2>";
      echo $this->Form->create('Member', array('name' => 'miembros')); 
	  echo $this->Form->input('name', array('label' => __('Primer nombre')));
	  echo $this->Form->input('identification', array('label' => __('Número identificación')));
	  echo "<label>".__('Genero')."</label>"; 
      echo $this->Form->input('gender',array('type'=>'radio','options'=>$genero, 'legend' => false )); ?>
      <div id="desdeotro">
      <?php echo $this->Form->input('other_gener', array('label' => __('Cual?'))); ?>
      </div>
<?php echo $this->Form->input('age', array('label' => __('Edad')));
	  echo "<h2>".__('Datos de contacto')."</h2>";
      echo $this->Form->input('type',array('type'=>'select','options'=>$tipo, 'empty' => '- Selecciona una opción -', 'label' => __('Tipo de miembro')));       
	  echo $this->Form->input('email', array('label' => __('E-mail')));
	  echo $this->Form->input('cel', array('label' => __('Celular')));
	  echo $this->Form->input('Facebook', array('label' => __('Facebook')));
	  echo $this->Form->input('course', array('label' => __('Grado')));
      if($this->view=='edit') { $idColegio = false; $value = false; } else { $idColegio = $idColegio; $value = 'value'; }
	  echo $this->Form->input('school_id',array('type'=>'hidden', $value => $idColegio)); 
  	  echo "<h2>".__('Talleres a los que asistió')."</h2>";

	  echo $this->Form->end(__($text1.' integrante', array('name' => 'crear'))); ?>
</div>

<script type="text/javascript">

$(document).ready(function() {
$('#MemberGenderOtro').click(function(evento) {
$('#desdeotro').fadeIn(500);
});

$('#MemberGenderFemenino, #MemberGenderMasculino').click(function(evento) {
$('#desdeotro').fadeOut(800);
 $(miembros.otro).reset();
});

});


</script>
