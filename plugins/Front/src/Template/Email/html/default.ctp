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


    if(isset($type) && $type == 'rent' && $relationships == 1) {

    $datos = ['Name' => $name, 'E-mail' => $email, 'Phone' => $tel, 'Country' => $country, 'State' => $state, 'City' => $city, 'Description' => $industry_type, 'Equipment buy status' => $equipment_buy_status, 'Date Start' => $date_start, 'date end' => $date_end, 'Searching crane avalible to' => 'Rent',  
              'Capacity' => $tons, 'Year' => $year, 'Crane type' => $crane_type,
             ];

    }

    //oferta de un prodcto Type alquiler
    elseif(isset($type) && $type == 'rent' && $relationships == 0) {

    $datos = ['Company name' => $company_name, 'Company position' => $company_position, 'Name' => $name, 'E-mail' => $email, 'Phone' => $tel, 'Crane' => $post_name, 'Crane code' => $code, 'Country' => $country, 'State' => $state, 'City' => $city, 'Description' => $industry_type, 
              'Equipment buy status' => $equipment_buy_status, 'Date Start' => $date_start, 'date end' => $date_end, 'Searching crane avalible to' => 'Rent',  'Capacity' => $tons, 'Year' => $year, 'Crane type' => $crane_type,
             ];

    }



    //oferta de un prodcto Type alquiler
    elseif(isset($type) && $type == 'sell') {

    $datos = ['Company name' => $company_name, 'Company position' => $company_position, 'Name' => $name, 'E-mail' => $email, 'Phone' => $tel, 'Crane' => $post_name, 'Type' => $type, 'Value Offer' => $value1, 'Value crane USD' => $post_price];
    
    }


    //contraofertas
    elseif(isset($counteroffer) && !empty($counteroffer)) {

    $datos = ['Company name' => $name, 'E-mail' => $email, 'Crane' => $product, 'Offer type' => $offer_type, 'Value' => $value, 'Value counteroffer' => $counteroffer];
    
    }


    //registro en el newsletter
    elseif(isset($news) && !empty($news)) {
    
    $datos = ['E-mail' => $email];

    }

    //correo de creacion de usuarios
    elseif(isset($password)) { 
    
    $datos = ['Name' => $name, 'E-mail' => $email, 'Password' => $password];

    } 


    //correo de correción de usuarios
    elseif(isset($tokenUrl)) { 
    
    $datos = ['Get your new password' => '<a href="'.$tokenUrl.'">'.$tokenUrl.'</a>', 'E-mail' => $email];

    } 

    
    //correo de pagina web contacto
    elseif(isset($comments)) { 
    
    $datos = ['Name' => $name, 'E-mail' => $email, 'Indicative area' => $code_phone,  'area code' => $area_phone, 'Phone' => $tel, 'Indicative celphone' => $code_cel, 'Celphone' => $cel, 'Area celphone' => $area_cel,
              'Country' => $country, 'City' => $city, 'State' => $state, 'Address' => $city, 'Crane code' => $zip_code, 'Company' => $company_name, 'Ocupation' => $company_position, 'Messagge' => $comments,  'Reference post visited' => $crane];
    }


        //correo de pagina web contacto
    elseif(isset($offer_date)) { 
            
            if($offer_type == 'rent') {
                    $datos = ['Company name' => $name, 'E-mail' => $email, 'Crane' => $product, 'Crane code' => $code, 'Offer Status' => $status, 'Offer date' => $offer_date, 'Offer Type' => $offer_type ];
            } else {
                    $datos = ['Company name' => $name, 'E-mail' => $email, 'Crane' => $product, 'Crane code' => $code, 'Offer Status' => $status, 'Value Offer' => $value, 'Offer Type' => $offer_type];
            }
    
    }


      foreach ($datos as $name => $dato) { 
      if(isset($dato) && !empty($dato)) { ?>
      <tr>
        <td style='width:90px;'><strong style='font-family:Arial, Helvetica, sans-serif;float:left; color:#7C7B7B;'><?= __($name); ?></strong></td>
        <td style='width:220px;'><font style='color:#333'><?= $dato; ?></font></td>
      </tr>
    <?php } } ?>
  </table>

<!-- html principal en el layout -->
