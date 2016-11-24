<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN">
<html>
<head>
    <title><?= $this->fetch('title') ?></title>
    <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
</head>

<body style='font-family:Arial, Helvetica, sans-serif;'>
<center>
<table width='800' border='1' cellpadding='0' cellspacing='0'>
    <tr>
    <td colspan='2' style='background:#E8A60C; color:#333; padding:7px 2px;'><center><img src="<?= $this->Url->build('/', true).$logo;?>" alt='Logo' title='Elymki <?= $blogName; ?>'></center></td>
    </tr>
  <tr>
    <td style="padding:10px 50px;">
   
		  <table border='0' cellspacing='0' style="width:700px;">
		  <tr>
		    <td>
		      <h2 style="color:#E8A60C; font-family:Arial, Helvetica, sans-serif;"><?php if(isset($subject) && !empty($subject)) { echo __($subject); } ?></h2>
		      <p style="color:#333; font-family:Arial, Helvetica, sans-serif;"><?php if(isset($description) && !empty($description)) { echo  __($description); ?>: <?= date('Y-m-d'); } ?></p>
		    </td>
		  </tr>
		  </table>

		  <table border='0' cellspacing='0' style="width:700px;">
		    <tr>
		      <td colspan='2' style='background:#333; color:#fff; padding:7px 2px;'><strong style='font-family:Arial, Helvetica, sans-serif; padding-left:10px;  height:20px;'><?= __d('front', 'Contenido del mensaje:'); ?></strong></td>
		    </tr>
		  </table>
  
 		  <?= $this->fetch('content') ?>

		  <table border='0' cellspacing='0' style=" width:700px; margin-top:15px;">
			  	<tr>
			 		 <td>
			 		 	<h5 style="color:#E8A60C; font-family:Arial, Helvetica, sans-serif;"><?= __d('front', 'Cordialmente:'); ?> <?= __($blogName); ?></h5>
			  			<p style="color:#333; font-size:7px; font-family:Arial, Helvetica, sans-serif;"><?= __d('front', 'El contenido de este mensaje puede ser información privilegiada y confidencial. Si usted no es el destinatario real del mismo, por favor informe de ello a quien lo envía y destrúyalo en forma inmediata. Está prohibida su retención, grabación, utilización o divulgación con cualquier propósito. Este mensaje ha sido verificado con software antivirus, en consecuencia, el remitente de este no se hace responsable por la presencia en él o en sus anexos de algún virus que pueda generar daños en los equipos o programas del destinatario.'); ?>
			  			</p>
			  		</td>
			  	</tr>
		  </table>

    </td>
    </tr>
</table>

<div style='margin:10px auto; padding-top:10px; margin-top:20px; color:#7C7B7B; width:700px;'>:: <?= __($blogName); ?> <?= date('Y'); ?> <?= __d('front', 'Todos los derechos reservados'); ?> ::<br />  <?= __d('front', 'Desarollado por T&T Interactiva S.A.S.'); ?> </div>
</center>

</body>
</html>
