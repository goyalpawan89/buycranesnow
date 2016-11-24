
<?php

$Description = __('Elymki');
?>
<style>
a{
	color:#000;
	font-weight:bold;
}
</style>
<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $Description ?>
	</title>
	<?php
		echo $this->Html->meta('icon');

		  echo $this->Html->css('administrador/login');
		    echo $this->Html->css('administrador/alerts');
		    	
		    echo $this->Html->css(['fuentes/font-awesome.min', 'fuentes/fuentes']);
			echo $this->Html->script(['jquery']);

		
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
</head>

<body>

<div style="position:relative; margin:0px auto 0px; top:-7px;">
<?php echo $this->Flash->render(); ?>
</div>
<?php 
if($this->Session->read('Flash.auth')) {?>
<div style="position:relative; margin:0px auto 0px; top:-7px;">
	<div class="alert alert-danger alert-dismissable">
	  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	  <?= $this->Flash->render('auth') ?>
	  
	</div>
</div>
<?php }?>


	<div id="container" style="float:left; width:100%;">

		<div id="content">
			
			


<?php echo $this->fetch('content'); ?>


            
		</div>
		<div id="footer">
<div class="text1"><?php echo __('Derechos Reservados'); ?> &copy; 2010 - <?php echo date('Y'); ?></div>
<?php /*<div class="text2"><a href="http://interactiva.net.co">www.interactiva.net.co</a></div>*/?>

		</div>
	</div>

</body>
</html>

