
<?php if($this->request->session()->read('Player.id')){?>
<script>
	$(document).ready(function(){
		$('#jet').goalProgress({
			goalAmount: 100,
			currentAmount: 20,
		});
	})
</script>

<?php } ?>


<h2><?php echo $page->name;?></h2>

<?php 
$file = $this->requestAction('Administrator.File/getThumbUrl', ['id'=>$page->file_id]); ?>

<?php if(isset($file)){?>
<center>
<div id='mapa'>

<?php if($this->request->session()->read('Player.id') and $posicion>=4){?>
<div id="jet" class="tooltip-bottom" data-tooltip="<?php echo 'Posición: '.$posicion; ?>"></div>
<?php }?>

 	<img class='destacada' style='margin:0px 0px 35px 0px;' src="<?php echo $this->Url->build('/', true).$file;?>" />
     	
      <div id="avion">
          <aside class="relative">
              <img src="<?php echo $this->Url->build('/', true);?>img/avion.png">

              <?php if(isset($genero0) and isset($custom0)){?>
              <div class='primero' data-tooltip="<?php echo $posiciones[0]['name']; ?> - <?php echo 'Posición: '.$posiciones[0]['posicion']; ?>" >
                  <div class='piel'>
                    <img src="<?php echo $this->Url->build('/', true);?>img/profile/<?php echo $genero0;?>/cabeza/<?php echo $custom0->piel;?>" style='width:40%; margin:10px 0px;'>
                  </div>
                  <div class='cabello'>
                    <img src="<?php echo $this->Url->build('/', true);?>img/profile/<?php echo $genero0;?>/<?php echo $custom0->cabello;?>" width="100%">
                  </div>
                  <div class='ojos'>
                    <img src="<?php echo $this->Url->build('/', true);?>img/profile/<?php echo $genero0;?>/<?php echo $custom0->ojos;?>" width="100%">
                  </div>

                  <?php if($genero0=='Hombre' and !empty($custom0->accesorio)){?>
                  	<div class='barba'>
              	      <img src="<?php echo $this->Url->build('/', true);?>img/profile/<?php echo $genero0;?>/<?php echo $custom0->accesorio;?>" width="100%">
              	    </div>
              	<?php }?>
              </div>
              <?php } ?>

              <?php if(isset($genero1) and isset($custom1)){?>
              <div class='segundo' data-tooltip="<?php echo $posiciones[1]['name']; ?> - <?php echo 'Posición: '.$posiciones[1]['posicion']; ?>" >
                  <div class='piel'>
                    <img src="<?php echo $this->Url->build('/', true);?>img/profile/<?php echo $genero1;?>/cabeza/<?php echo $custom1->piel;?>" style='width:40%; margin:10px 0px;'>
                  </div>
                  <div class='cabello'>
                    <img src="<?php echo $this->Url->build('/', true);?>img/profile/<?php echo $genero1;?>/<?php echo $custom1->cabello;?>" width="100%">
                  </div>
                  <div class='ojos'>
                    <img src="<?php echo $this->Url->build('/', true);?>img/profile/<?php echo $genero1;?>/<?php echo $custom1->ojos;?>" width="100%">
                  </div>
                  <?php if($genero1=='Hombre' and isset($custom1->accesorio)){?>
                  <div class='barba'>
                    <img src="<?php echo $this->Url->build('/', true);?>img/profile/<?php echo $genero1;?>/<?php echo $custom1->accesorio;?>" width="100%">
                  </div>
                  <?php } ?>
              </div>
              <?php } ?>


              <?php if(isset($genero2) and isset($custom2)){?>
              <div class='tercero' data-tooltip="<?php echo $posiciones[2]['name']; ?> - <?php echo 'Posición: '.$posiciones[2]['posicion']; ?>" >
                  <div class='piel'>
                    <img src="<?php echo $this->Url->build('/', true);?>img/profile/<?php echo $genero2;?>/cabeza/<?php echo $custom2->piel;?>" style='width:40%; margin:10px 0px;'>
                  </div>
                  <div class='cabello'>
                    <img src="<?php echo $this->Url->build('/', true);?>img/profile/<?php echo $genero2;?>/<?php echo $custom2->cabello;?>" width="100%">
                  </div>
                  <div class='ojos'>
                    <img src="<?php echo $this->Url->build('/', true);?>img/profile/<?php echo $genero2;?>/<?php echo $custom2->ojos;?>" width="100%">
                  </div>
                  <?php if($genero3=='Hombre' and isset($custom3->accesorio)){?>
                  <div class='barba'>
                    <img src="<?php echo $this->Url->build('/', true);?>img/profile/<?php echo $genero2;?>/<?php echo $custom2->accesorio;?>" width="100%">
                  </div>
                 <?php } ?>
              </div>
              <?php } ?>


              <?php if(isset($genero3) and isset($custom3)){?>
              <div class='cuarto' data-tooltip="<?php echo $posiciones[3]['name']; ?> - <?php echo 'Posición: '.$posiciones[3]['posicion']; ?>" >
                  <div class='piel'>
                    <img src="<?php echo $this->Url->build('/', true);?>img/profile/<?php echo $genero3;?>/cabeza/<?php echo $custom3->piel;?>" style='width:40%; margin:10px 0px;'>
                  </div>
                  <div class='cabello'>
                    <img src="<?php echo $this->Url->build('/', true);?>img/profile/<?php echo $genero3;?>/<?php echo $custom3->cabello;?>" width="100%">
                  </div>
                  <div class='ojos'>
                    <img src="<?php echo $this->Url->build('/', true);?>img/profile/<?php echo $genero3;?>/<?php echo $custom3->ojos;?>" width="100%">
                  </div>
                  <?php if($genero4='Hombre' and isset($custom4->accesorio)){?>
                  <div class='barba'>
                    <img src="<?php echo $this->Url->build('/', true);?>img/profile/<?php echo $genero3;?>/<?php echo $custom3->accesorio;?>" width="100%">
                  </div>
                 <?php } ?>
              </div>
              <?php } ?>
          </aside>
      </div>

 	<div id="bogota" ><img src="<?php echo $this->Url->build('/', true);?>img/bogota.png"></div>
	<div id="rio"><img src="<?php echo $this->Url->build('/', true);?>img/rio.png"></div>
</div>

 </center>
<?php } ?>


<?php 
$retos=[];
$var=[];
foreach ($reto as $key => $value) {

	if(!empty($value['categories'])){
		$name=$value['name'];
		$id=$value['id'];

		array_push($retos, $name);

		array_push($var, $id);	
	}
 }?>

<?php 
$retos=array_combine($var, $retos);

?>

<div class="ranking-table">
<table>
	<tr>
		<td style='padding:10px;'></td>
		<td></td>
		<?php foreach ($retos as $key => $value) {?>
			<td style='height:200px'><div class='text-vertical' ><?php echo $value;?></div></td>
		<?php } ?>
	</tr>

	<?php $conteo=1;
	foreach ($usuarios as $key => $value) {

	if($value['id']==$perfil['id']){
		$class='red';
	}else{
		$class=null;
	}?>

	<tr class='topRanking <?php echo $class;?>' >
		<td><?php echo $conteo;?></td>
		<td width='320px'><b title="<?php echo $value['name'];?>"><span class="ranking-name"><?php echo $value['name'];?></span></b></td>

		<?php foreach ($retos as $id=>$reto) {?>
		<td>
		<?php foreach($value['ranking'] as $key){?>

			<?php if($id==$key['post_id']){?>
			<i class="fa fa-check"></i>
			<?php }?>

		<?php }?>
		</td>

		<?php }?>

	</tr>


	<?php $conteo++; }?>
	
</table>
</div>



<div class="table-responsive">
  <table width="100%">
    <tr>
      <th><?php echo __('Puesto'); ?></th>
      <th><?php echo __('Participante'); ?></th>
      <th><?php echo __('Millas'); ?></th>
    </tr>

      <?php $conteo=1;
  foreach ($usuarios as $key => $value) {?>
    <tr>
      <td><?php echo $conteo;?></td>
      <td><b title="<?php echo $value['name'];?>"><span class="ranking-name"><?php echo $value['name'];?></span></b></td>
      <td><b title="<?php echo $value['name'];?>"><span class="ranking-name"><?php echo $value['rank'];?></span></b></td>
    </tr>

    <?php $conteo++;}?>
  </table>
</div>


