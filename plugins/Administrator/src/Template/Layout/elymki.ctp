<?php
/**
 *
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = __($blogName); ?>
<!DOCTYPE html>
<html>
<head>
  <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $cakeDescription; ?>:
        <?= $this->fetch('title') ?>
    </title>

  <?php
    echo $this->Html->meta('icon', $favicon);

    echo $this->Html->css('menu/jquery.multilevelpushmenu'); // menu principal del soft
    echo $this->Html->css(['administrador/elymki', 'administrador/alerts']); // css principal y alertas

    echo $this->Html->script('jquery'); // JQUERY PRINCIPAL 

    //echo $this->Html->css('fecha/bootstrap-datetimepicker.min.css');

     if($this->request->params['action'] =='profile' || $this->request->params['action'] == 'edit' || $this->request->params['action'] == 'add') { // editor visual 

       //funciones de editor visual
       echo $this->Html->css('visual_editor/redactor'); // editor visual.
       echo $this->Html->script(['visual_editor/combined.min', 'visual_editor/redactor', 'visual_editor/table', 'visual_editor/video', 'visual_editor/imagemanager', 'visual_editor/filemanager', 'visual_editor/es']); // editor visual

      ?>
        
       <script type="text/javascript">
        $(function()
        {
          $('.table-visual-editor textarea').redactor({
            lang: 'es',
            //placeholder: '<?php echo $extras["placeholder_description"]; ?>',
            buttonSource: true,
            imageUpload: '/webUpload/redactor/uploadImage/',
            fileUpload: '/webUpload/redactor/fileUpload/',
            plugins: ['table', 'video', 'imagemanager', 'filemanager'],

          });
        });
       </script>

       <?php } // fin funciones de editor visual

         //menu principal
       echo $this->Html->script(['menu/jquery.multilevelpushmenu', 'menu/basichtml']); // menu principal .min
       
    ?>
  
<style>
    /**** Color Administrable array $colores desde appcontoller ****/

body, input, textarea, select, .gallery-div { color:#<?php if($colores) { echo $colores[0]; } ?>; background-color:<?php if($FondoBackEnd) { echo $FondoBackEnd; } ?>  } 

/*** colores blancos ******/

<?php foreach($colores as $key => $color) { ?>
    .color<?php echo $key+1; ?>, .colorh<?php echo $key+1; ?>:hover { color:#<?php echo $color;?>; } 
    .fondo<?php echo $key+1; ?>, .fondoh<?php echo $key+1; ?>:hover { background-color:#<?php echo $color;?>; }
    .border<?php echo $key+1; ?>, .borderh<?php echo $key+1; ?>:hover { border-color:#<?php echo $color;?> !important; } 
<?php } ?>

.top-bar li a::before, .table-index_user a, .table-index_email a:hover, .desplegable .categories-checkbox div.input label { color:#<?php echo $colores[0];?>; } 
.levelHolderClass, .redactor-box textarea#redactor, .ac-principal_label { background-color:#<?php echo $colores[0];?>; }

.table-index_user a:hover, .table-index_email a { color:#<?php echo $colores[1];?>; }
#bar-publication .ui-progressbar-value, #bar-page .ui-progressbar-value, .redactor-toolbar li a:hover, .td-image_aside:before, .state-hover, .pagin-count li.active a, .pagin-count li a:hover, .ac-container input:checked + label, .ac-container input:checked + label:hover, #example-one .nav li a.current  
{ background-color:#<?php echo $colores[1];?>; }

.multilevelpushmenu_wrapper .cursorPointer { color:#<?php echo $colores[2];?>; }
.multilevelpushmenu_wrapper a:hover, .multilevelpushmenu_wrapper .multilevelpushmenu_inactive, .pagin-count a, .ajax-file-upload, .ac-principal_label:hover { background-color:#<?php echo $colores[2];?>; }

.multilevelpushmenu_wrapper a, .multilevelpushmenu_wrapper h2, .multilevelpushmenu_wrapper .cursorPointer:hover, .table-index th a, .pagin-count a, .ac-principal_label { color:#<?php echo $colores[4];?>; }


/**** Color Administrable ****/
</style>


<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-24975180-2', 'auto');
  ga('send', 'pageview');

</script>

</head>
<body>

<!-- contenedor principal -->
<div id="pushobj">

        <!-- menu principal -->
        <?php echo $this->element('admin/top_bar');?>
        <!--fin menu principal -->

        <?php echo $this->Flash->render(); ?>
        <div id="homepage" class="homepage">
            
            <?php if($this->request->params['action'] == 'index' || $this->request->params['action'] == 'trash') { echo $this->Form->create($this->name, []); }
            
                  echo $this->element('admin/index-up_section'); // seccion superior vistas index solamente aparecerá en vistas trash e index
                  echo $this->fetch('content'); // contenido de las vistas

                  if($this->request->params['action'] == 'index' || $this->request->params['action'] == 'trash') { echo $this->Form->end(); } ?>           

    </div>

</div>
<!-- fin contenedor principal -->

<!-- menu principal -->
<?php echo $this->element('admin/menu');?>
<!--fin menu principal -->


<?php $vistas=array('index','trash','view', 'newsletter'); if(in_array($this->request->params['action'], $vistas)) { ?>
    
    <script type="text/javascript">
    // Listen for click on toggle checkbox
    $('#select-all').click(function(event) {   
        if(this.checked) { $(':checkbox').each(function() { this.checked = true; }); // Iterate each checkbox
        } else { $(':checkbox').each(function() { this.checked = false; }); }
    });
    </script>

<?php } 

      //if($this->request->params['controller'] =='Generals' || $this->request->params['action'] =='profile' || $this->request->params['action'] == 'edit'  || $this->request->params['action'] == 'add') { // subir imagenes y archivos
        // upload images and files
        echo $this->Html->css('upload_files/uploadfile'); // upload images.
        echo $this->Html->script(['upload_files/jquery.uploadfile.min']); // upload images ?>
        
        <script>
        $(document).ready(function() {
           
           <?php /*
              $("#fileuploader").uploadFile({
              url:"<?php echo $this->Url->build('/', true);?>admin/config/upload",
              fileName:"upload",
              multiple:true,  
              uploadStr: "<?php echo $imagesText['button']; ?>",
              dragDropStr: "<span><strong><?php echo $imagesText['upload_text']; ?></strong></span>",
              //returnType:"json",
              <?php if($this->request->params['action'] == 'edit') { ?>
              formData: { post_id: <?php echo $id; ?> },
              <?php } ?>
              //showError: true,

              returnType:"json",

            });

            */ ?>

        
        $("#fileuploader").uploadFile({
              url:"<?php echo $this->Url->build('/', true);?>admin/config/upload",
              multiple:true,
              fileName:"upload",
              returnType:"json",
              uploadStr: "<?php echo $imagesText['button']; ?>",
              dragDropStr: "<span><strong><?php echo $imagesText['upload_text']; ?></strong></span>",
              //maxFileSize:20000*1024,
              
              <?php if($this->request->params['action'] == 'edit') { ?>
              formData: { post_id: <?php echo $id; ?> },
              <?php } ?>

              onSuccess:function(files,data,xhr,pd)
              {
                //datos = JSON.parse(data);
                
                //Generación de numeros de acuerdo a campos creados
                numero=$('.ppp').length;
               // console.log(numero);
                $( "#eventsmessage" ).append( "<input type='hidden' class='ppp' name='archives[0-"+ numero +"][id]' value='"+data.File.result+"'>" );
                
                
              },
           
              }); 

        });
        </script>

<?php //} // fin funciones de editor visual

       echo $this->Html->css('jquery-ui'); // css Jquery UI de la web (tooltips progressbar etc...)
       echo $this->Html->css('fuentes/font-awesome.min'); // fontAwesome

       echo $this->Html->script('locations');  // formato de números debe ir en la parte de arriba.

              
       // funciones sueltas o principales
       echo $this->Html->script('custom'); // script personalizado (efectos de la web sueltos).

       //jquery ui tooltips
       echo $this->Html->script('jquery-ui'); //js  Jquery UI de la web (tooltips progressbar etc...)

       echo $this->Html->script('modernizr.min'); // modernizr.min    

      if((isset($user_Role) && $user_Role > 1) && (isset($user_Type) && $user_Type == 'Basic')) { echo $this->Html->script('permissions/3'); echo "okoko"; }


      echo $this->fetch('css'); 
      echo $this->fetch('script'); 
 ?>


          
</body>
</html>

