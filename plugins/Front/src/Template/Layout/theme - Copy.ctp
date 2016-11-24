
<!DOCTYPE html>
<html>
<head>
	<?= $this->Html->charset() ?>
  <?php if($this->request->params['controller'] =='Posts' && $this->request->params['action'] == 'index')  { $scale = 3; } else { $scale = 1; } ?>

    <meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=<?= $scale; ?>' /> 

    <meta property="fb:app_id" content="498389210308893" />
    
    <?php if($this->request->params['controller'] == 'Posts' && $this->request->params['action'] == 'index') { 
             $description = $this->Get->get_excerpt($content->id, 125); $title = $content->name; $image = $this->Image->url($content->archive_id, 'full'); $url = $this->Get->get_url(); 
          } else { 
            $description = $blogDescription; $title = $blogName; $image = $this->Url->build('/', true).$logo; $url = $this->Url->build('/', true); 
          } ?>
    
    <meta name="description" content='<?= $description; ?>'>
    <meta property='og:url' content='<?= $url; ?>' />
    <meta property="og:type" content="website" />
    <meta property="og:site_name" content="<?= $blogName; ?>" />  
    <meta property='og:title' content='<?= $title; ?>' />
    <meta property='og:description' content='<?= $description; ?>' />
    <meta property='og:image' content='<?= $image; ?>' />
    <meta name="google-site-verification" content="RmdEtesQjUJ-fsOee_mvF4nyJiY2TlXB8xV7kPXtU2Q" />

    <title><?= $blogName; ?> <?= $this->fetch('title') ?></title>

  <?php

  //echo pr($datos);
		echo $this->Html->meta('icon', $favicon);
 
     //css principal
    echo $this->Html->css('Front.front/elymki', ['media' => 'screen']);
    echo $this->Html->css('Front.front/navbar_techandall');

  
    echo $this->Html->script('front/number_format');  // formato de números debe ir en la parte de arriba.
  
    //jquery min
    echo $this->Html->script('front/jquery-1.7.2.min');   

    //script destacados
    echo $this->Html->script('Front.front/jquery.bxslider.min');

	?>
	
<?php foreach($colors as $key => $color) { ?>
  <style type="text/css">
        .color<?=  $key; ?>, .colorh<?=  $key; ?>:hover { color:#<?=  $color; ?>; }
        .fondo<?=  $key; ?>, .fondoh<?=  $key; ?>:hover { background-color:#<?=  $color; ?>; }
        .border<?=  $key; ?>, .borderh<?=  $key; ?>:hover { border-color:#<?=  $color; ?> !important; }       
  </style>
<?php } ?>

<?php if ($authUser && !empty($authUser)) {  ?>
  <style type="text/css">
       .not_login { display:none !important; }      
  </style>
<?php } ?>
  
  <style type="text/css">

    .background { background-color: <?=  $background; ?>; } /* background-principal */
    /* colores personalizados */

    .nav li a:hover, .pagin-count nav a:hover, .list-post_image_video:before { color:#<?=  $colors[1]; ?>; } 
    .buscador .submit:before, .bx-wrapper .bx-pager.bx-default-pager a:hover, .bx-wrapper .bx-pager.bx-default-pager a.active, .footer_title:before, .slide_info h3:before, .order-table .input-sort:hover, .order-table a:hover, .is-checked, .pagin-count nav a, #example-one ul li a.current 
    { background-color:#<?=  $colors[1]; ?>; } 
    
    .order-table .input-sort, .order-table a, .pagin-count nav a, .users_table-item th a, #example-one ul li.post-tab a.current, #infoMaps span a, .content-side_description_text font a, a[href^="mailto"], .page_description a { color:#<?=  $colors[2]; ?>; }

    .buscador .submit:hover :before, .bx-wrapper .bx-pager.bx-default-pager a, .pagin-count nav a:hover { background-color:#<?=  $colors[2]; ?>; }
   

  </style>

  <?php if($this->request->params['controller'] != 'Front') { ?>
    <style type="text/css">
      header { background-color:rgba(0,0,0, 0.7); } 
      .content { padding-top: 100px; } 
    </style>
  <?php } ?>


</head>

<body class="<?= $this->request->params['controller']; ?> <?= $this->request->params['action']; ?> <?php if(isset($authUser) && !empty($authUser)) { echo 'login'; } else { echo "not-login"; } ?>">
      
      <!-- login sign up -->
      <?= $this->element('Front.login');?>
      <!-- end login sign up -->
      <?= $this->element('Front.buscador'); ?>

      <?php if((isset($userRole) && $userRole > 1) && (isset($authUser['type']) && $authUser['type'] == 'Basic')) { $classHeader = 'not-premium'; ?>

          <aside class="change_premium color1"><span><?= $extras['change_premium_message']; ?> <?= $blogName; ?></span> <?= $this->Html->Link($extras['change_premium'], $this->Get->get_link(89, 'Pages'), ['class' => 'btn-link btn fondo1 fondoh0 color2']); ?></aside>
            
      <?php } else { $classHeader = ""; } ?>

       <!--cabezote -->
        <header id="header" class="<?= $classHeader; ?>">
            <section id='wrap'>
              <aside id='logo'><?= $this->element('Front.logo');?></aside>
              <nav id='menu'><?= $this->element('Front.menu');?></nav>
            </section>
          </header>
      <!--fin cabezote -->

		<content id="content">		
                   <?= $this->Flash->render(); ?>
                   <div id="homepage">
                    <?= $this->fetch('content'); ?>
                   </div>
		</content>
    

    <!-- footer -->
    <?=  $this->element('Front.footer'); ?>


<!-- paises y ciudades -->
<?php echo $this->Html->css('front/jquery-ui'); // css jquery UI.
      echo $this->Html->script('front/jquery-ui.min'); // jquery UI ?>

<script type="text/javascript">
 $(document).ready(function() {

                             // fechas con Jquery
                            $('.datepick').each(function(i) {
                                this.id = 'datepicker' + i;
                            }).datepicker();                 

                            
                            $('#datepicker0').change(function() {
                              var datMin = $(this).val();
                              $('#datepicker1').datepicker('option', 'minDate', new Date(datMin));
                            });

                            if (!localStorage.ciudad) {
                                
                               $.getJSON('http://ip-api.com/json', function(data) {
                                      localStorage.ciudad = data.city;
                                      localStorage.pais = data.country;
                                      
                                      localStorage.latitud = data.lat;
                                      localStorage.longitud = data.lon;
                                });
                            
                            } 



  });
</script>
<!-- paises y ciudades -->


<?php  
    
    echo $this->Html->script('Administrator.locations');  // formato de números debe ir en la parte de arriba.

    //banner promociones
        echo $this->Html->css('Front.front/jquery.bxslider');    

        echo $this->Html->css('Front.fuentes/font-awesome.min');
        echo $this->Html->css('Front.fuentes/fuentes');

        echo $this->Html->css('https://fonts.googleapis.com/css?family=Raleway:400,500,700,800&subset=latin,latin-ext');

        //fancybox css        
        echo $this->Html->css('Front.fancybox/jquery.fancybox');
        echo $this->Html->css('Front.fancybox/jquery.fancybox-buttons');
        echo $this->Html->css('Front.fancybox/jquery.fancybox-thumbs');

        //fancybox scripts        
        echo $this->Html->script('Front.fancybox/jquery.fancybox.pack');
        echo $this->Html->script('Front.fancybox/jquery.fancybox-buttons');
        echo $this->Html->script('Front.fancybox/jquery.fancybox-media');
        echo $this->Html->script('Front.fancybox/jquery.fancybox-thumbs');
        echo $this->Html->script('Front.fancybox/fancy');

    echo $this->Html->script('Front.front/customs');

      if($this->request->params['controller'] == 'Front') {
        // scripts del banner
        echo $this->Html->css('Front.front/jquery.maximage'); 
        echo $this->Html->script('Front.front/jquery.maximage.min');
        echo $this->Html->script('Front.front/jquery.cycle.all');
        echo $this->Html->script('Front.front/activeBanner');

      }
      
    if(isset($authUser) && !isset($authUser['role_id']) || $authUser['role_id'] == 3) { echo $this->Html->script('Front.permissions/3'); }
   
    echo $this->fetch('meta');
    echo $this->fetch('css');
    echo $this->fetch('script');

?>


    <script type="text/javascript">
 
        //link directorio telefonico
        var linkEmpresa = $('.item-15 a');
            linkEmpresa.attr('href', '<?= $this->Get->get_url_translate('Users', 'index') ?>');
            linkEmpresa.parent('li').addClass('dropdown');

        <?php if($authUser) { ?>
              
              //enlace mis favoritos para ususarios logueados
              $('<li><?= $this->Html->Link(__($extras["my_favorites"]), $this->Get->get_url_translate('Posts', 'my_favorites'), ['class' => 'principal-main color1 colorh0']  ); ?></li>').insertBefore('.item-menu:last-child');

              $('a[href="#login"]').css('display', 'none');
              $('a[href="#register_company"]').css('display', 'none');


        <?php } else { ?>

              //todos los hreflogin abrir login
              $('a[href="#login"]').addClass('fancybox');
              $('a[href="#register_company"]').addClass('fancybox');

              $('.need_login').attr('href', '#login').addClass('fancybox');

        <?php } ?>

        $('.item-1 > a').removeAttr('href');

    </script>

<!-- cookies -->
<script type="text/javascript">
/*
$(document).ready(function(){
    //servicio localStorage
    if(localStorage.cookies == undefined) {
        $('body').prepend('<aside class="cookies_acept color2 fondo1"><div class="wrap"><h3><?= $extras["cookies"]; ?></h3><span><?= $extras["cookies_acept_description"]; ?><br><font class="user_cookies_acept colorh0"><?= $extras["cookies_acept"]; ?></font></span></div></aside>');
    } 

});
*/
//End cookies


  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-24975180-5', 'auto');
  ga('send', 'pageview');

<?php if(($this->request->params['controller'] == 'Users' || $this->request->params['controller'] == 'Posts') && ($this->request->params['action'] == 'index')) { ?>

      //TRANSICIÓN DE IMAGENES DE PUBLICIDAD
      function cycleImages(){
            var $active = $('#cycler .active');
            var $next = ($active.next().length > 0) ? $active.next() : $('#cycler a:first');
                $next.css('z-index',2);//move the next image up the pile
                $active.fadeOut(1500,function(){//fade out the top image
                $active.css('z-index',1).show().removeClass('active');//reset the z-index and unhide the image
                $next.css('z-index',3).addClass('active');//make the next image the top one
            });
      }

      // run every 7s
      setInterval('cycleImages()', 7000);
      
<?php } ?>

</script>



</body>
</html>