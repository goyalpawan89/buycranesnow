<!--- textos desde la variable $imagesText en AppController -->

<style>
/**trasition**/
.k-effect li:hover span.mask {
    transition: all 0.3s ease-in-out 0.25s;
    -moz-transition: all 0.3s ease-in-out 0.25s;
    -webkit-transition: all 0.3s ease-in-out 0.25s;
    -o-transition: all 0.3s ease-in-out 0.25s;
}

span.mask, ul.k-effect li, ul.k-effect img {
    transition: all 0.2s ease-in-out 0s;
    -moz-transition: all 0.2s ease-in-out 0s;
    -o-transition: all 0.2s ease-in-out 0s;
    -webkit-transition: all 0.2s ease-in-out 0s;
}
/*reset*/
ul.k-effect {list-style: none outside none;margin: 0;padding: 0; display:flex;}
ul.k-effect li {list-style: none outside none;}
ul.k-effect img {border: 0 none;opacity: 1;}
ul.k-effect li:hover img {opacity: 0.7;}

ul.k-effect li {
    background: #fff;
    border: 1px solid rgba(0, 0, 0, 0.25);
    box-shadow: 0 5px 5px -5px rgba(0, 0, 0, 0.9);
    display: inline-block;
    margin: 10px 8px;
    padding: 5px;
    position: relative;
    top: 0;
    overflow: hidden;
    width: 200px;
    height: 200px;
    display: flex;
}
ul.k-effect li > a {
    display: block;
    overflow: hidden;
    position: relative;
}
ul.k-effect span.mask {
    background-color: rgba(0, 0, 0, 0.8);
    /*background-image: url("http://lh4.googleusercontent.com/-WQnshglkK3M/UKJ5d_syX8I/AAAAAAAADuE/0fXdBOvpYmg/s1600/full.png");*/
    background-position: center center;
    color:white;
    background-repeat: no-repeat;
    position: absolute;
    left: 0;
    top: 0;
}

/**Efecto Top**/
ul.k-effect.top li:hover {box-shadow: 0 21px 8px -15px rgba(0, 0, 0, 0.5);top: -5px;}
ul.k-effect.top span.mask {height: 70px;top: -80px;width: 280px;}
ul.k-effect.top li:hover span.mask {top: 0;}

/**Efecto bottom**/
ul.k-effect.bottom li:hover {box-shadow: 0 5px 5px -5px rgba(0, 0, 0, 0);top: 5px;}
ul.k-effect.bottom span.mask {height: 100%;width: 100%;opacity: 0; top: 0;}
ul.k-effect.bottom li:hover span.mask {opacity: 1;}

/**Efecto left**/
ul.k-effect.left li {left: 0;}
ul.k-effect.left li:hover {left: 5px;}
ul.k-effect.left span.mask {height: 160px;top: 0;width: 0;}
ul.k-effect.left li:hover span.mask {width: 80px;}

/**Efecto circle**/
ul.k-effect.circle span.mask {border-radius: 100%;bottom: 0;height: 60px;margin: auto;right: 0;top: -40px;width: 60px;opacity: 0;}
ul.k-effect.circle li:hover span.mask {top: 0;opacity: 1;}
ul.k-effect.circle li:hover img {transform: scale(1.1);-moz-transform: scale(1.1);-ms-transform: scale(1.1);-webkit-transform: scale(1.1);-o-transform: scale(1.1);}

/**Efecto rotate**/
ul.k-effect.rotate span.mask {height: 60px;left: 0;right: 0;width: 60px;margin: auto;bottom: 0;border-radius: 100%;transform: rotate(-120deg);-moz-transform: rotate(-120deg);-ms-transform: rotate(-120deg);-o-transform: rotate(-120deg);-webkit-transform: rotate(-120deg);top: 40px;opacity: 0;}
ul.k-effect.rotate li:hover span.mask {top: 0;left: 0;opacity: 1;transform: rotate(0deg);-moz-transform: rotate(0deg);-ms-transform: rotate(0deg);-o-transform: rotate(0deg);-webkit-transform: rotate(0deg);}
ul.k-effect.rotate li img {transform: scale(1.1);-moz-transform: scale(1.1);-ms-transform: scale(1.1);-o-transform: scale(1.1);-webkit-transform: scale(1.1);}
ul.k-effect.rotate li:hover img {transform: scale(1);-moz-transform: scale(1);-ms-transform: scale(1);-o-transform: scale(1);-webkit-transform: scale(1);}

/****Configurar****/
/**tamaño a cortar de la imagen*/
ul.k-effect li > a {
    height: 160px; /*ancho*/
    width: 280px; /*alto*/
}

/**tamaño maximo de la imagen [Naturalmente es recomendable que este sea al menos 20 pixeles mas grande que el corte]**/
ul.k-effect img {
  /*max-width: 300px;*/
width: 100%;
height: auto;

}


/**trasition Imagenes Hover**/

.thumb {
    /*height: 200px;*/
    width: 100%;
    border: 1px solid #000;
    margin: 10px 5px 0 0;
}

.k-effect{
    cursor: pointer;
}


/* Campos TYPE Upload */
.fileUpload {
    position: relative;
    overflow: hidden;
    text-transform: uppercase;
    padding: 20px 50px;
}
.fileUpload input#files {
    position: absolute;
    top: 0;
    right: 0;
    margin: 0;
    padding: 0;
    font-size: 20px;
    cursor: pointer;
    opacity: 0;
    width: 100%;
    filter: alpha(opacity=0);
    height: 100%;
}

.fileUpload span{
  padding: 10px;
  font-weight: normal;
  
}
/* Campos TYPE Upload */


</style>



<script>
 $(document).ready(function() {
//overlays para las ventanas de imagenes tanto galeria como imagen destacada
  $( ".close_gallery, .allGalerry" ).click(function() {
    $( ".overGallery" ).fadeToggle( function() {
    });
  });
  
  $( ".close_thumbnails, .selectThumbnail" ).click(function() {
    $( ".overThumbnails" ).fadeToggle( function() {
    });
  });

})

</script>



<?php /*
<h2 id="principal" class="titulo2"><?php echo __($imagesText['title']); ?></h2>
*/?>
 
<!-- selecciona las imagenes -->
  <table id="adicional" class="bloquete">
      <tr><td class="fondo colorblanco"><label><?php echo __($imagesText['label']); ?></label></td></tr>
      <tr>
        <td>
<!-- subir archivos -->

      <div id="drop" class="fileUpload btn btn-primary fondogris fongrisosh">

          <?php //Validamos si hay imagen destacada
          if($this->view=='edit' and !empty($form->file_id)){?>
            <center>
              <div id="imgDestacada">
                
                <p>
                 <?php $file = $this->requestAction('Administrator.File/getThumbUrl', ['id'=>$form->file_id, 'size'=>'thumbnail']); ?>
                 <img src='<?php echo $this->Url->build('/', true).$file;?>' style='max-width:180px; max-height:300px;'>
                 <?php echo $this->Form->input('file_id', ['type'=>'hidden', 'id'=>'file_id', 'value'=>$form->file_id]); ?>
                </p>

                <p class='destacada' style="display:none"><canvas id="canvas"></canvas></p>

                <p class='remove'><i class="fa fa-times" style='color:red'></i> <?php echo __($imagesText['remove_image']); ?></p>
              </div>
            </center>

            <script>
            $(document).ready(function() {
              
              $(".remove").click(function() {
                  
                  $('#file_id').val('');
                  $('.imagenes').css('display', 'block');

              });

            });
            </script>


          <?php $display='none';
          }else{
            $display='block';
          } ?>


        <div class='imagenes' style='display:<?php echo $display;?>'>
            <div id='uploadImg'>

                <?php echo __($imagesText['upload_text']); ?>
                <span class="fondo mas color3"><?php echo __($imagesText['select_images']); ?></span>            
                <?php echo $this->Form->file('file', ['name' => 'File[]', 'id'=>'files', 'label' => false, 'div' => false]); ?>
               
            </div>
            <center>
              <div id="imgDestacada" style='display:none;'>
                <p></p>
                <ul id="list" class="k-effect bottom"></ul>
                <p class='destacada'><canvas id="canvas"></canvas></p>
                <p class='remove'><i class="fa fa-times" style='color:red'></i> <?php echo __($imagesText['remove_image']); ?></p>
              </div>
            </center>  
        </div>


          




      </div>
    

    <ul class="list_fields fondo"><!-- listado subido--></ul>
             
<!-- subir archivos -->
   <div id="fileupload"></div>
    <p class="mini_descrip">
        <?php echo __($imagesText['description']); ?> 
        <?php if($this->name!='Galleries'){?>
        <span class="txt-right selectThumbnail colorh1"><?php echo __($imagesText['featured_picture']); ?></span>
        <?php } ?>
    </p>
         </td>
      </tr>
  </table>



<?php if($this->view=='edit'){?>
<!-- Imagenes Creadas Type File-->

<div id='imagenActual'>
 
  <ul id="list" class="k-effect bottom">
      
  </ul>
</div>

<?php if(isset($imagenes) && !empty($imagenes)){?>
<div id='imagenActual'>
  <h2>Imagenes</h2>
  <ul id="list" class="k-effect bottom">
    <?php foreach ($imagenes as $imagen) {
      $img=$imagen['folder'].$imagen['thumbnail'].'-'.$imagen['filename'];
      ?>
      <li class='thum'><img src='<?php echo $this->Url->build('/', true).$img;?>'/><span class='mask'></span></li>
<?php } ?>
  
  </ul>
</div>
<?php } ?>

<?php }else{?>



<?php } ?>
<script>
          $("#list li.thum").click(function() {
                /*$('#list').empty();
                $('#imagenActual h2').empty();*/
                $(this.parent).empty();
           });


  function handleFileSelect(evt) {
      var files = evt.target.files; // FileList object
      var imagen=[];
      var conteo =0;
      // Loop through the FileList and render image files as thumbnails.
      for (var i = 0, f; f = files[i]; i++) {
      //console.log(files[i]);  
        // Only process image files.
        if (!f.type.match('image.*')) {
          continue;
        }

        var reader = new FileReader();
        // Closure to capture the file information.
        reader.onload = (function(theFile) {
       
          return function(e) {
            // Render thumbnail.
            $( "#list" ).append( "<li class='thum' data-name='"+ escape(theFile.name)  +"' data-number='"+conteo +"'><img src='" + e.target.result+ "'  title='" + escape(theFile.name) + "'/><span class='mask'></span><input type='hidden' name='Imagenes["+conteo+"]' value='"+conteo+"'></li>" );
            
            $(".thum").click(function() {
                imagen = imagen.splice($(this).data('number'), $(this).data('number'));
                $(this).remove();


           });

           
            imagen.push(escape(theFile.name));
          
            $('#imagenes').val(imagen);

            conteo++;
          };
        })(f);

        // Read in the image file as a data URL.
        reader.readAsDataURL(f);
         
      }
    }

    document.getElementById('files').addEventListener('change', handleFileSelect, false);

  $( ".k-effect" ).hover(function() {
      $(".mask").html('<center style="padding-top:40%;"><b><i class="fa fa-times" style="color: red"></i> Eliminar</b></center>');
    });

  $("#uploadImg").change(function() {
    //console.log('check');
    $( "#list" ).empty();
  });
</script>
<!-- Imagenes Creadas Type File-->



<!-- selecciona las imagenes -->



<!-- inicio overlay galería de imagenes -->

<?php /*
<section class="overlight overGallery">
        <aside class="gallery">
    		<i class="fa fa-times-circle close_gallery color3 colorh1"></i>
			      <h1 id="principal" class="sinmargenabajo"><?php echo __($imagesText['gallery_title']); ?></h1>
            <p id="descripcion"><?php echo __($imagesText['gallery_description']); ?></p>

            <fieldset>
                <ul class="checklist">
                     <?php // allFiles = getGallery /controller/filescontroller.php obtiene las imagenes que hacen parte del post a editar (funcion importada desde PostsController).
                   if(isset($allFiles)) { 

          				    foreach($allFiles as $file) { 
                      	 $image = $this->requestAction('File/getThumbUrl', ['id' => $file['id'], 'size' => 'thumbnail']);  ?>
                          

                          <li class="<?php if($file['selected']!="") { echo $file['selected']." fondo1 fondoh"; } else { echo "fondo fondoh1"; } ?>">
                                  <label for="choice_<?php echo $file['id']; ?>>" style="background-image:url(<?php echo $this->Url->build('/', true).$image; ?>);" data-icon="<?php echo $file['type'] ?>"></label>
                                      <a class="checkbox-select color colorh1" href="#"></a>
                                      <a class="checkbox-deselect color1 colorh" href="#"></a>
                                      <?php echo $this->Form->input('File', array('name' => 'data[Files'.$Modelo.'][]', //se llama la variable modelo desde appcontroller 
                                                                    'value' => $file['id'], 
                                                                    'id' => 'choice_'.$file['id'], 
                                                                    'label' => false, 
                                                                    'hiddenField' => false,
                                                                    'type' => 'checkbox',
                                                                    'checked' => $file['check'], 
                                                                    'div' => false)); ?>
          				        </li>
                      <?php } } ?>
          			</ul>
    			      <div style="clear: both;"></div>
            </fieldset>
            
        </aside>
</section>
<!-- fin overlay galería de imagenes -->
*/?>



<!-- inicio overlay galería de imagenes -->
<section class="overlight overThumbnails">
        <aside class="gallery">
          <i class="fa fa-times-circle close_thumbnails color3 colorh1"></i>

          <h1 id="principal" class="sinmargenabajo"><?php echo __($imagesText['gallery_title']); ?></h1>
         <p id="descripcion"><?php echo __($imagesText['gallery_featured_description']); ?></p>
          <div id='ajax'></div>
    		
        </aside>
</section>
<!-- fin overlay galería de imagenes -->

<?php echo $this->Html->script('selectImages/selects'); ?>


<script>
$( ".selectThumbnail" ).on( "click", function() {

    $('#ajax').html('<center><img id="loader-img" alt="" src="https://d13yacurqjgara.cloudfront.net/users/12755/screenshots/1037374/hex-loader2.gif" width="400" height="300" align="center" /></center>');
     $.get( "<?php echo $this->Url->build('/', true);?>administrator/File/getThumbUrl/" , function( data ) {
        $( "#ajax" ).html( data );
       
      });

   });
</script>
<?php /*echo $this->Html->script('uploadImage/jquery.knob'); // subir imagenes
      echo $this->Html->script('uploadImage/jquery.ui.widget'); 
      echo $this->Html->script('uploadImage/jquery.fileupload'); 
      echo $this->Html->script('uploadImage/jquery.iframe-transport'); 
      echo $this->Html->script('uploadImage/script');   
      echo $this->fetch('script');*/
?>

