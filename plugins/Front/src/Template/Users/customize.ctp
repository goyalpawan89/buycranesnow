
<h2 style='width:80%;'>Personaliza tu avatar</h2>

<div id='profile'>

  <div class='avatar'>

    <?php if(isset($custom)){?>
    
    <div class='piel'>
      <img src="<?php echo $this->Url->build('/', true);?>img/profile/<?php echo $genero;?>/<?php echo $custom->piel;?>" width="100%">
    </div>
    <div class='cabello'>
      <img src="<?php echo $this->Url->build('/', true);?>img/profile/<?php echo $genero;?>/<?php echo $custom->cabello;?>" width="100%">
    </div>
    <div class='ojos'>
      <img src="<?php echo $this->Url->build('/', true);?>img/profile/<?php echo $genero;?>/<?php echo $custom->ojos;?>" width="100%">
    </div>
    <div class='barba'>
      <img src="<?php echo $this->Url->build('/', true);?>img/profile/<?php echo $genero;?>/<?php echo $custom->accesorio;?>" width="100%">
    </div>
    <div class='camisa'>
      <img src="<?php echo $this->Url->build('/', true);?>img/profile/<?php echo $genero;?>/<?php echo $custom->camisa;?>" width="100%">
    </div>
    <div class='pantalon'>
      <img src="<?php echo $this->Url->build('/', true);?>img/profile/<?php echo $genero;?>/<?php echo $custom->pantalon;?>" width="100%">
    </div>
    <div class='tenis'>
      <img src="<?php echo $this->Url->build('/', true);?>img/profile/<?php echo $genero;?>/<?php echo $custom->tenis;?>" width="100%">
    </div>

    <?php }else{?>
    <div class='piel'></div>
    <div class='cabello'></div>
    <div class='ojos'></div>
    <div class='barba'></div>
    <div class='camisa'></div>
    <div class='pantalon'></div>
    <div class='tenis'></div>
    <?php } ?>
    <img src="<?php echo $this->Url->build('/', true);?>img/profile/<?php echo $genero;?>/GenericoNull.png" width='100%'>

  </div>


 
 <div class='infoProfile' style='background-color:rgba(0, 0, 0, 0.4);'>
 

 <div class='cuadros'>
   

   <div class='cuadro' data-tipo='piel'>
    <img style="margin:0px" src="<?php echo $this->Url->build('/', true);?>img/profile/<?php echo $genero;?>/Piel01.png" width="45px">
   </div>


    <div class='cuadro' data-tipo='cabello'>
      <img src="<?php echo $this->Url->build('/', true);?>img/profile/<?php echo $genero;?>/miniatura/Cabello01.png" width="45px">
   </div>


    <div class='cuadro' data-tipo='ojos'>
      <img src="<?php echo $this->Url->build('/', true);?>img/profile/<?php echo $genero;?>/miniatura/Ojos01.png" width="45px">
   </div>

   <div class='cuadro' data-tipo='barba'>
      <img src="<?php echo $this->Url->build('/', true);?>img/profile/<?php echo $genero;?>/miniatura/Barba01.png" width="45px">
   </div>

   <div class='cuadro' data-tipo='camisa'>
      <img src="<?php echo $this->Url->build('/', true);?>img/profile/<?php echo $genero;?>/miniatura/Camisa01.png" width="45px">
   </div>

   <div class='cuadro' data-tipo='pantalon'>
      <img src="<?php echo $this->Url->build('/', true);?>img/profile/<?php echo $genero;?>/miniatura/Pantalon01.png" width="45px">
   </div>

   <div class='cuadro' data-tipo='tenis'>
      <img src="<?php echo $this->Url->build('/', true);?>img/profile/<?php echo $genero;?>/miniatura/Tenis01.png" width="45px">
   </div>

</div>

<div class='item' style='display:none'>



  <?php 
  
  if($genero=='Hombre'){
    $conteo=9;
  }elseif($genero=='Mujer'){
    $conteo=8;
  }
  for($a=1;$a<=$conteo;$a++){?>
  <div class='cabelloItem' style='display:none' data-image="<?php echo $this->Url->build('/', true);?>img/profile/<?php echo $genero;?>/Cabello0<?php echo $a;?>.png" data-name="Cabello0<?php echo $a;?>.png">
    <img src="<?php echo $this->Url->build('/', true);?>img/profile/<?php echo $genero;?>/miniatura/Cabello0<?php echo $a;?>.png" width="45px">
  </div>
  <?php } ?>

  <div class='cabelloItem' style='display:none' data-image="<?php echo $this->Url->build('/', true);?>img/profile/<?php echo $genero;?>/white.png" data-name="white.png">
    <img src="<?php echo $this->Url->build('/', true);?>img/profile/<?php echo $genero;?>/nada.png" width="45px">
  </div>



    <?php 
  for($b=1;$b<=4;$b++){?>
  <div class='pielItem' style='display:none' data-image="<?php echo $this->Url->build('/', true);?>img/profile/<?php echo $genero;?>/Piel0<?php echo $b;?>.png" data-name="Piel0<?php echo $b;?>.png">
    <img style="margin:0px" src="<?php echo $this->Url->build('/', true);?>img/profile/<?php echo $genero;?>/Piel0<?php echo $b;?>.png" width="45px">
  </div>
  <?php } ?>



   <?php for($c=1;$c<=6;$c++){?>
  <div class='ojosItem' style='display:none' data-image="<?php echo $this->Url->build('/', true);?>img/profile/<?php echo $genero;?>/Ojos0<?php echo $c;?>.png" data-name="Ojos0<?php echo $c;?>.png">
    <img src="<?php echo $this->Url->build('/', true);?>img/profile/<?php echo $genero;?>/miniatura/Ojos0<?php echo $c;?>.png" width="45px">
  </div>
  <?php } ?>


     <?php 
  if($genero=='Hombre'){
    $conteo=2;
  }elseif($genero=='Mujer'){
    $conteo=1;
  }
   for($d=1;$d<=$conteo;$d++){?>
  <div class='barbaItem' style='display:none' data-image="<?php echo $this->Url->build('/', true);?>img/profile/<?php echo $genero;?>/Barba0<?php echo $d;?>.png" data-name="Barba0<?php echo $d;?>.png">
    <img src="<?php echo $this->Url->build('/', true);?>img/profile/<?php echo $genero;?>/miniatura/Barba0<?php echo $d;?>.png" width="45px">
  </div>
  <?php } ?>

    <div class='barbaItem' style='display:none' data-image="<?php echo $this->Url->build('/', true);?>img/profile/<?php echo $genero;?>/white.png" data-name="white.png">
    <img src="<?php echo $this->Url->build('/', true);?>img/profile/<?php echo $genero;?>/nada.png" width="45px">
  </div>



   <?php for($e=1;$e<=8;$e++){?>
  <div class='camisaItem' style='display:none' data-image="<?php echo $this->Url->build('/', true);?>img/profile/<?php echo $genero;?>/Camisa0<?php echo $e;?>.png" data-name="Camisa0<?php echo $e;?>.png">
    <img src="<?php echo $this->Url->build('/', true);?>img/profile/<?php echo $genero;?>/miniatura/Camisa0<?php echo $e;?>.png" width="50px">
  </div>
  <?php } ?>

  <div class='camisaItem' style='display:none' data-image="<?php echo $this->Url->build('/', true);?>img/profile/<?php echo $genero;?>/white.png" data-name="white.png">
    <img src="<?php echo $this->Url->build('/', true);?>img/profile/<?php echo $genero;?>/nada.png" width="45px">
  </div>



   <?php 
   for($f=1;$f<=8;$f++){?>
  <div class='pantalonItem' style='display:none' data-image="<?php echo $this->Url->build('/', true);?>img/profile/<?php echo $genero;?>/Pantalon0<?php echo $f;?>.png" data-name="Pantalon0<?php echo $f;?>.png">
    <img src="<?php echo $this->Url->build('/', true);?>img/profile/<?php echo $genero;?>/miniatura/Pantalon0<?php echo $f;?>.png" width="45px">
  </div>
  <?php } ?>


   <?php for($g=1;$g<=8;$g++){?>
  <div class='tenisItem' style='display:none' data-image="<?php echo $this->Url->build('/', true);?>img/profile/<?php echo $genero;?>/Tenis0<?php echo $g;?>.png" data-name="Tenis0<?php echo $g;?>.png">
    <img src="<?php echo $this->Url->build('/', true);?>img/profile/<?php echo $genero;?>/miniatura/Tenis0<?php echo $g;?>.png" width="48px">
  </div>
  <?php } ?>


  <div class='tenisItem' style='display:none' data-image="<?php echo $this->Url->build('/', true);?>img/profile/<?php echo $genero;?>/white.png" data-name="white.png">
    <img src="<?php echo $this->Url->build('/', true);?>img/profile/<?php echo $genero;?>/nada.png" width="45px">
  </div>



</div>


 </div>

 
</div>



 
<script>
$( ".cuadro" ).click(function() {

  $(".item").show('fast');
  tipo=$(this).data("tipo");  
  
tipos=['piel', 'cabello', 'ojos', 'barba', 'camisa', 'pantalon', 'tenis'];
//console.log(tipos[0]);
for(a=0;a<tipos.length;a++){

 if(tipos[a]!=tipo)
  {
    
    $("."+ tipos[a] +"Item").hide('fast');
    
  }else{
    
    $("."+ tipos[a] +"Item").show('fast');
    
  }

}
  


  
});





$( ".cabelloItem" ).click(function() {
  //$( ".cabello" ).fadeToggle( "slow", "linear" );
  img = $(this).data("image");
  $( ".cabello" ).html('<img src="'+ img +'" width="100%">');
  $( "#cabello" ).remove();
  $( "#form" ).append( "<input type='hidden' id='cabello' name='cabello' value='" + $(this).data("name") + "'>" );

});


$( ".pielItem" ).click(function() {
  //$( ".cabello" ).fadeToggle( "slow", "linear" );
  img = $(this).data("image");
  $( ".piel" ).html('<img src="'+ img +'" width="100%">');
  $( "#piel" ).remove();
  $( "#form" ).append( "<input type='hidden' id='piel' name='piel' value='" + $(this).data("name") + "'>" );

});


$( ".ojosItem" ).click(function() {
  //$( ".cabello" ).fadeToggle( "slow", "linear" );
  img = $(this).data("image");
  $( ".ojos" ).html('<img src="'+ img +'" width="100%">');
  $( "#ojos" ).remove();
  $( "#form" ).append( "<input type='hidden' id='ojos' name='ojos' value='" + $(this).data("name") + "'>" );

});


$( ".barbaItem" ).click(function() {
  //$( ".cabello" ).fadeToggle( "slow", "linear" );
  img = $(this).data("image");
  $( ".barba" ).html('<img src="'+ img +'" width="100%">');
  $( "#barba" ).remove();
  $( "#form" ).append( "<input type='hidden' id='barba' name='accesorio' value='" + $(this).data("name") + "'>" );

});


$( ".camisaItem" ).click(function() {
  //$( ".cabello" ).fadeToggle( "slow", "linear" );
  img = $(this).data("image");
  $( ".camisa" ).html('<img src="'+ img +'" width="100%">');
  $( "#camisa" ).remove();
  $( "#form" ).append( "<input type='hidden' id='camisa' name='camisa' value='" + $(this).data("name") + "'>" );

});

$( ".pantalonItem" ).click(function() {
  //$( ".cabello" ).fadeToggle( "slow", "linear" );
  img = $(this).data("image");
  $( ".pantalon" ).html('<img src="'+ img +'" width="100%">');
  $( "#pantalon" ).remove();
  $( "#form" ).append( "<input type='hidden' id='pantalon' name='pantalon' value='" + $(this).data("name") + "'>" );

});

$( ".tenisItem" ).click(function() {
  //$( ".cabello" ).fadeToggle( "slow", "linear" );
  img = $(this).data("image");
  $( ".tenis" ).html('<img src="'+ img +'" width="100%">');
  $( "#tenis" ).remove();
  $( "#form" ).append( "<input type='hidden' id='tenis' name='tenis' value='" + $(this).data("name") + "'>" );

});


</script>





<?php echo $this->Form->create(null, ['id'=>'form', 'enctype'=>"multipart/form-data"]); ?>
  <input type='hidden' name='genero' value='<?php echo $genero;?>'>

<?php if(isset($custom)){?>
<input type='hidden' id='cabello' name='cabello' value='<?php echo $custom->cabello;?>'>
<input type='hidden' id='piel' name='piel' value='<?php echo $custom->piel;?>'>
<input type='hidden' id='ojos' name='ojos' value='<?php echo $custom->ojos;?>'>
<input type='hidden' id='barba' name='accesorio'value='<?php echo $custom->accesorio;?>'>
<input type='hidden' id='camisa' name='camisa' value='<?php echo $custom->camisa;?>'>
<input type='hidden' id='pantalon' name='pantalon' value='<?php echo $custom->pantalon;?>'>
<input type='hidden' id='tenis' name='tenis' value='<?php echo $custom->tenis;?>'>
<?php } ?>


  <p><button type="submit" style='width:100px; float:right; margin:10px; display:in'><?php echo __('Continuar'); ?></button></p>
  <?php echo $this->Form->end(); ?>
  