<style>td { background:#fff; } .mce-tinymce { width:99% !important; }</style>


<div id="talleres">
<?php echo "<h2>".__('Sondeo por estudiante')."</h2>"; ?>
<?php echo $this->Form->create('Substance', array('name' => 'miembros'));
echo $this->Form->input('member_id', array('type' => 'hidden', 'value' => $datosMiembro['Member']['id']));
echo $this->Form->input('school_id', array('type' => 'hidden', 'value' => $datosSchool['School']['id']));  ?>

<table id="losdatos" class="completo">
<tr> 
<td width="300px" class="fondo colorblanco"><span><?php echo __('Nombre colegio'); ?></span></td>
<td><span><?php echo $datosSchool['School']['name']; ?></span></td>
</tr>
<tr>
<td class="fondo colorblanco"><span><?php echo __('Genero'); ?></span></td>
<td><span><?php echo $datosMiembro['Member']['gender']; ?></span></td>
</tr>
<tr>
<td class="fondo colorblanco"><span><?php echo __('Edad'); ?></span></td>
<td><span><?php echo $datosMiembro['Member']['age']; ?></span></td>
</tr>
<td class="fondo colorblanco"><span><?php echo __('Barrio de residencia'); ?></span></td>
<td><span><?php echo $this->Form->input('barrio', array('label' => false)); ?></span></td>
</tr>
</tr>
<td class="fondo colorblanco"><span><?php echo __('Tipo de Sondeo'); ?></span></td>
<td><span><?php if($datosSubtance==0) { $sondeo = 'Primer sondeo'; } else { $sondeo = 'Segundo sondeo'; } 
                echo $this->Form->input('tipo_sondeo', array('label' => false, 'value' => $sondeo, 'disabled' => true));
				echo $this->Form->input('tipo_sondeo', array('value' => $sondeo, 'type' => 'hidden')); //no manda campo deshabilitado ?></span></td>
</tr>
</table>

<?php echo "<h2>".__('Sobre consumo')."</h2>"; ?>

<table id="losdatos" class="completo">
<tr> 
<td width="300px" class="fondo colorblanco"><span><?php echo __('¿Ha consumido alcohol en los últimos 3 meses?'); ?></span></td>
<td><span><?php echo $this->Form->input('consumo_alcohol',array('type'=>'select','options'=>$siNo, 'empty' => '- Selecciona una opción -', 'label' => false)); ?></span></td>
</tr>
<tr>
<td class="fondo colorblanco"><span><?php echo __('¿A los cuántos años inició?'); ?></span></td>
<td><span><?php echo $this->Form->input('alcohol_edad', array('label' => false)); ?></span></td>
</tr>
<tr>
<td class="fondo colorblanco"><span><?php echo __('¿Ha consumido cigarrillo en los últimos tres meses?'); ?></span></td>
<td><span><?php echo $this->Form->input('consumo_cigarro',array('type'=>'select','options'=>$siNo, 'empty' => '- Selecciona una opción -', 'label' => false)); ?></span></td>
</tr>
<tr>
<td class="fondo colorblanco"><span><?php echo __('¿A los cuántos años inició?'); ?></span></td>
<td><span><?php echo $this->Form->input('cigarro_edad', array('label' => false)); ?></span></td>
</tr>
<tr>
<td class="fondo colorblanco"><span><?php echo __('¿Ha consumido alguna sustancia psicoactiva (SPA) y/o Droga?'); ?></span></td>
<td><span><?php echo $this->Form->input('consumo_spa',array('type'=>'select','options'=>$siNo, 'empty' => '- Selecciona una opción -', 'label' => false)); ?></span></td>
</tr>
<tr>
<td class="fondo colorblanco"><span><?php echo __('¿A los cuántos años inició?'); ?></span></td>
<td><span><?php echo $this->Form->input('spa_edad', array('label' => false)); ?></span></td>
</tr>
<tr>
<td class="fondo colorblanco"><span><?php echo __('¿Cuáles sustancias ha consumido en los últimos 3 meses?'); ?></span></td>
<td><span><?php echo $this->Form->input('sustancias_3_meses', array('label' => false)); ?></span></td>
</tr>
<tr>
<td class="fondo colorblanco"><span><?php echo __('Ha mezclado más de 3 drogas al mismo tiempo en los últimos 3 meses, ¿cuáles? '); ?></span></td>
<td><span><?php echo $this->Form->input('mezcla_drogas', array('label' => false)); ?></span></td>
</tr>
<tr>
<td class="fondo colorblanco"><span><?php echo __('¿Si consume drogas, usted lo hace por?'); ?></span></td>
<td><span><?php echo $this->Form->input('consume_por',array('type'=>'radio','options'=>$porque, 'label' => false, 'legend' => false)); ?></span>
      <div id="desdeotro" class="desdeotro1" style="width:99%;"><?php echo $this->Form->input('consume_otra', array('label' => __('Cual?'))); ?></div>
</td>
</tr>
</table>

<?php echo "<h2>".__('Sobre riesgos')."</h2>"; ?>

<table id="losdatos" class="completo">
<tr> 
<td width="300px" class="fondo colorblanco"><span><?php echo __('¿Conoce las diferencias entre sustancias psicoactivas legales, ilegales y legales de uso indebido?'); ?></span></td>
<td><span><?php echo $this->Form->input('diferencias_sustancias',array('type'=>'select','options'=>$siNo, 'empty' => '- Selecciona una opción -', 'label' => false)); ?></span></td>
</tr>
<tr>
<td class="fondo colorblanco"><span><?php echo __('¿Conoce la calidad de las sustancias que consume?'); ?></span></td>
<td><span><?php echo $this->Form->input('calidad',array('type'=>'select','options'=>$siNoMas, 'empty' => '- Selecciona una opción -', 'label' => false)); ?></span></td>
</tr>
<tr>
<td class="fondo colorblanco"><span><?php echo __('¿Sabe cuál es la diferencia entre consumo, uso y abuso de drogas?'); ?></span></td>
<td><span><?php echo $this->Form->input('dif_consumo',array('type'=>'select','options'=>$siNo, 'empty' => '- Selecciona una opción -', 'label' => false)); ?></span></td>
</tr>
<tr>
<td class="fondo colorblanco"><span><?php echo __('¿Sabe cuáles son los principales adulterantes de las drogas?'); ?></span></td>
<td><span><?php echo $this->Form->input('adulterantes',array('type'=>'select','options'=>$siNo, 'empty' => '- Selecciona una opción -', 'label' => false)); ?></span></td>
</tr>
<tr>
<td class="fondo colorblanco"><span><?php echo __('¿Sabe cuáles son los riesgos y daños de mezclar drogas y de mezclar estas con alcohol? '); ?></span></td>
<td><span><?php echo $this->Form->input('mezcla_spa_alcohol',array('type'=>'select','options'=>$siNo, 'empty' => '- Selecciona una opción -', 'label' => false)); ?></span></td>
</tr>
<tr>
<td class="fondo colorblanco"><span><?php echo __('¿A través de qué medio se informa usted sobre el tema de drogas?  '); ?></span></td>
<td><span><?php echo $this->Form->input('medio_informacion',array('type'=>'radio','options'=>$medios, 'label' => false, 'legend' => false)); ?></span>
      <div id="desdeotro" class="desdeotro2" style="width:99%;"><?php echo $this->Form->input('medio_informacion_otra', array('label' => __('Cual?'))); ?></div>
</td>
</tr>
</table>

<?php echo "<h2>".__('Sobre drogas')."</h2>"; ?>

<table id="losdatos" class="completo">
<tr> 
<td width="300px" class="fondo colorblanco"><span><?php echo __('¿Sabe cuál es la diferencia entre droga, fármaco, estupefaciente y sustancia psicoactiva?'); ?></span></td>
<td><span><?php echo $this->Form->input('dif_farmaco_psicoactiva',array('type'=>'select','options'=>$siNo, 'empty' => '- Selecciona una opción -', 'label' => false)); ?></span></td>
</tr>
<tr>
<td class="fondo colorblanco"><span><?php echo __('¿Sabe cuál es la diferencia entre sustancias depresoras, estimulantes y alucinógenos?'); ?></span></td>
<td><span><?php echo $this->Form->input('dif_depresoras_alucinogenos',array('type'=>'select','options'=>$siNoMas, 'empty' => '- Selecciona una opción -', 'label' => false)); ?></span></td>
</tr>
<tr>
<td class="fondo colorblanco"><span><?php echo __('¿Sabe la diferencia entre prevención, reducción de riesgo y daños, y superación del consumo?'); ?></span></td>
<td><span><?php echo $this->Form->input('dif_prevencion_superacion',array('type'=>'select','options'=>$siNo, 'empty' => '- Selecciona una opción -', 'label' => false)); ?></span></td>
</tr>
<tr>
<td class="fondo colorblanco"><span><?php echo __('¿Conoce la diferencia entre los efectos de cocaína, marihuana, Dick, lid, éxtasis, 2CB?'); ?></span></td>
<td><span><?php echo $this->Form->input('dif_efectos',array('type'=>'select','options'=>$siNo, 'empty' => '- Selecciona una opción -', 'label' => false)); ?></span></td>
</tr>
<tr>
<td class="fondo colorblanco"><span><?php echo __('¿Sabe usted qué es la cocaína rosada?'); ?></span></td>
<td><span><?php echo $this->Form->input('cocaina_rosada',array('type'=>'radio','options'=>$siNo, 'legend' => false, 'label' => false)); ?></span>
<div id="desdeotro" class="desdeotro3" style="width:99%;"><?php echo $this->Form->input('cocaina_rosada_si', array('label' => __('Qué es?'))); ?></div>
</td>
</tr>
</table>

<?php echo "<h2>".__('Sobre estigma y derechos')."</h2>"; ?>

<table id="losdatos" class="completo">
<tr> 
<td width="300px" class="fondo colorblanco"><span><?php echo __('¿Sabe cuál es la diferencia entre chirri, drogadicto, vicioso, consumidor o usuario?'); ?></span></td>
<td><span><?php echo $this->Form->input('dif_consumidor',array('type'=>'select','options'=>$siNo, 'empty' => '- Selecciona una opción -', 'label' => false)); ?></span></td>
</tr>
<tr>
<td class="fondo colorblanco"><span><?php echo __('¿Sabe cuál es la diferencia entre consumidor experimental, recreativo, habitual y  dependiente? Sí '); ?></span></td>
<td><span><?php echo $this->Form->input('dif_tipo_consumidor',array('type'=>'select','options'=>$siNo, 'empty' => '- Selecciona una opción -', 'label' => false)); ?></span></td>
</tr>
<tr>
<td class="fondo colorblanco"><span><?php echo __('¿Conoce sus derechos como consumidor de sustancias psicoactivas?'); ?></span></td>
<td><span><?php echo $this->Form->input('derechos',array('type'=>'select','options'=>$siNo, 'empty' => '- Selecciona una opción -', 'label' => false)); ?></span></td>
</tr>
</table>


<?php echo $this->Form->end(__('Generar sondeo', array('name' => 'crear'))); ?>
</div>


<script type="text/javascript">

$(document).ready(function() {

//otra consumo
$('#SubstanceConsumePorOtra').click(function(evento) { $('.desdeotro1').fadeIn(500); });
$('#SubstanceConsumePorPlacer, #SubstanceConsumePorExperimentacion, #SubstanceConsumePorCuriosidad, #SubstanceConsumePorSalirDeLosProblemas').click(function(evento) { $('.desdeotro1').fadeOut(800); });
//otra medios informacion
$('#SubstanceMedioInformacionOtra').click(function(evento) { $('.desdeotro2').fadeIn(500); });
$('#SubstanceMedioInformacionInternet, #SubstanceMedioInformacionAmigos, #SubstanceMedioInformacionFamilia, #SubstanceMedioInformacionMediosDeComunicacion, #SubstanceMedioInformacionDesalarJibaro').click(function(evento) { 
$('.desdeotro2').fadeOut(800); });
//otra medios informacion
$('#SubstanceCocainaRosadaSi').click(function(evento) { $('.desdeotro3').fadeIn(500); });
$('#SubstanceCocainaRosadaNo').click(function(evento) { $('.desdeotro3').fadeOut(800); });


});

</script>
