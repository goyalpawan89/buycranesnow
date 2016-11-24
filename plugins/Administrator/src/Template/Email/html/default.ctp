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


<!-- html principal en el layout -->

<table border='0' cellspacing='0' style="width:700px; margin-top:15px;">
    <?php 

    //correo de creacion de usuarios
    if(isset($password)) { 
    
    $datos = ['Name' => $name, 'E-mail / Username' => $email, 'Password' => $password];

    } 


    //correo de correción de usuarios
    elseif(isset($tokenUrl)) { 
    
    $datos = ['Get your new password' => '<a href="'.$tokenUrl.'">'.$tokenUrl.'</a>', 'E-mail' => $email];

    } 


      //correo de correción de usuarios
    elseif(isset($alert)) { 
    
    $datos = ['Crane' => $product, 'Crane Code' => $crane_code,  'New Listing Added' => $listen, 'url' => $url, ];

    } 


      foreach ($datos as $name => $dato) { 
      if(!empty($dato)) { ?>
      <tr>
        <td style='width:90px;'><strong style='font-family:Arial, Helvetica, sans-serif;float:left; color:#7C7B7B;'><?= __($name); ?></strong></td>
        <td style='width:220px;'><font style='color:#333'><?= $dato; ?></font></td>
      </tr>
    <?php } } ?>
  </table>

<!-- html principal en el layout -->
