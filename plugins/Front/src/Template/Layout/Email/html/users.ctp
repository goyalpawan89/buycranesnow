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
 * @package       app.View.Emails.html
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
?>

<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml'>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
</head>
<body style='font-family:Arial, Helvetica, sans-serif;'>
<center>
<table width='800' border='1' cellpadding='0' cellspacing='0'>
    <tr>
    <td colspan='2' style='background:#0983bb; color:#fff; padding:7px 2px;'><strong style='font-family:Arial, Helvetica, sans-serif; padding-left:10px;  height:20px;'>:: CSA TRAVELS ESTUDIOS EN EL EXTERIOR ::</strong></td>
    </tr>
  <tr>
    <td style="padding:10px 50px;">
   
   <table border='0' cellspacing='0' style="width:700px;">
  <tr>
  <td><h2 style="color:#0983bb; font-family:Arial, Helvetica, sans-serif;">Bienvenido a CSA TRAVELS</h2>
  <p style="color:#4c4c4c; font-family:Arial, Helvetica, sans-serif;">Gracias por confiar en CSA Travels, estaremos acompañandote en éste proceso de estudios en el exterior, para lo cual podrás acceder con un usuario y una contraseña para revisar tu hoja de vida con nosotros, además de muchas otras ventajas.</p></td>
  </tr>
  </table>

    <table border='0' cellspacing='0' style="width:700px;">
  <tr>
  <td colspan='2' style='background:#4c4c4c; color:#fff; padding:7px 2px;'><strong style='font-family:Arial, Helvetica, sans-serif; padding-left:10px;  height:20px;'>Datos de acceso:</strong></td>
  </tr>
  </table>
  
   <table border='0' cellspacing='0' style="width:700px; margin-top:15px;">
  <tr>
    <td style='width:90px;'><strong style='font-family:Arial, Helvetica, sans-serif;float:left; color:#7C7B7B;'>Ingreso (Email)</strong></td>
    <td style='width:220px;'><font style='color:#0983bb'><?php echo $email; ?></font></td>
  </tr>
    <tr>
      <td style='width:90px;'><strong style='font-family:Arial, Helvetica, sans-serif;float:left; color:#7C7B7B;'>Contraseña</strong></td>
      <td style='width:220px;'><font style='color:#0983bb'><?php echo $identification; ?></font></td>
    </tr>
    <tr>
      <td style='width:90px;'><strong style='font-family:Arial, Helvetica, sans-serif;float:left; color:#7C7B7B;'>Link de acceso</strong></td>
      <td style='width:220px;'><font style='color:#0983bb'><?php echo $url; ?></font></td>
    </tr>
</table>

<table border='0' cellspacing='0' style=" width:700px; margin-top:15px;">
  <tr>
  <td><h5 style="color:#0983bb; font-family:Arial, Helvetica, sans-serif;">Cordialmente: CSA TRAVELS</h5>
  <p style="color:#4c4c4c; font-size:7px; font-family:Arial, Helvetica, sans-serif;">El contenido de este mensaje puede ser información privilegiada y confidencial. Si usted no es el destinatario real del mismo, por favor informe de ello a quien lo envía y destrúyalo en forma inmediata. Está prohibida su retención, grabación, utilización o divulgación con cualquier propósito. Este mensaje ha sido verificado con software antivirus, en consecuencia, el remitente de este no se hace responsable por la presencia en él o en sus anexos de algún virus que pueda generar daños en los equipos o programas del destinatario.</p> </td>
  </tr>
  </table>
  
    </td>
    </tr>
</table>

<div style='margin:10px auto; padding-top:10px; margin-top:20px; color:#7C7B7B; width:700px;'>:: CSA TRAVELS <?php echo date('Y'); ?> Todos los derechos reservados ::<br />  Desarollado por T&T Interactiva S.A.S.</div>
</center>

</body>
</html>