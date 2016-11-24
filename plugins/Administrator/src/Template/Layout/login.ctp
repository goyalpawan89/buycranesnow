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

$cakeDescription = __('Elymki'); ?>

<!DOCTYPE html>
<html>

<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $cakeDescription ?>: <?= $this->fetch('title') ?></title>

    <?php 
    echo $this->Html->meta('icon', 'Administrator.img/favicon.png'); // favicon de la página
	
    echo $this->Html->css('administrador/login'); // css login principal
    echo $this->Html->css('administrador/alerts'); //css alertas
    echo $this->Html->css(['popup/simplemodal', 'fuentes/font-awesome.min', 'fuentes/fuentes']); // css popup y fontawesome

    echo $this->Html->script(['bootstrap/bootstrap.min', 'popup/mootools-core-1.3.1', 'popup/mootools-more-1.3.1.1', 'popup/simple-modal']); // scripts efectos (deben estar arriba para funcionar)
	
	echo $this->fetch('meta');
    echo $this->fetch('css'); 
    echo $this->fetch('script'); ?>

</head>

<body id="body-<?php echo $this->request->params['action']; ?>" class="body-<?php echo $this->request->params['action']; ?>">

	<!--container-->
	<div id="container"  class="table">
				
				<?php if($this->request->session()->read('Flash.auth')) {?>
						<div class="alert alert-danger alert-dismissable">
						  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						  <?= $this->Flash->render('auth') ?>
						</div>
				<?php } ?>

				<div class="alert-table table-row"><?php echo $this->Flash->render(); ?></div>

		<div class="table-row">	
				<div id="content" class="table-cell">
					<?php echo $this->fetch('content'); ?>
				</div>
		</div>

		<!--footer-->
		<footer id="footer" class="table-footer footer-<?php echo $this->request->params['action']; ?>">
			<div class="wrap">
				<aside class="text1"><?php echo __('Derechos Reservados'); ?> &copy; 2010 - <?php echo date('Y'); ?></aside>
				<aside class="text2"><?= __('Plataforma Elymki - Desarrollado por: '); ?> <a href="http://interactiva.net.co" class="color2 copacityh"><?= __('T6T Interactiva S.A.S.'); ?></a></aside>
			</div>
		</footer>
		<!--fin footer-->

	</div>
    <!--fin container -->


<style type="text/css">
	body { color:#<?php if($colores) { echo $colores[0]; } ?>;  } 

/*** colores blancos ******/

<?php foreach($colores as $key => $color) { ?>
    .color<?php echo $key+1; ?>, .colorh<?php echo $key+1; ?>:hover { color:#<?php echo $color;?>; } 
    .fondo<?php echo $key+1; ?>, .fondoh<?php echo $key+1; ?>:hover { background-color:#<?php echo $color;?>; }
    .border<?php echo $key+1; ?>, .borderh<?php echo $key+1; ?>:hover { border-color:#<?php echo $color;?> !important; } 
<?php } ?>

/**** Color Administrable ****/

</style>


<script type="text/javascript">
    //esconder alertas javascript jquery genera conflictos.
	var btn = document.querySelector('.close');
	var el = document.querySelector('.alert');
	btn.addEventListener('click', function(){
	  el.classList.add('remove');
	});
</script>

</body>
</html>
