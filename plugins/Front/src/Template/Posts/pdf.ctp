
<!DOCTYPE html>
<html class="html_map">
<head>

	<?= $this->Html->charset() ?>
    <meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' /> 
    <meta http-equiv="Content-Type" content="charset=utf-8" />
    
    <?php $description = $blogDescription; $title = $blogName; $image = $this->Url->build('/', true).$logo; $url = $this->Url->build('/', true); 
           ?>
    
    <meta name="description" content='<?= $description; ?>'>


    <title><?= $blogName; ?> - COT</title>

  <?php

	  echo $this->Html->meta('icon', $favicon);
    echo $this->Html->script('front/jquery-1.7.2.min');   
    echo $this->Html->css('Front.front/elymki', ['media' => 'screen']);

	
	$id = $content->id;
	$address = $this->Get->get_field_by_post_id($id, 'location'); 
	$city = $this->Get->get_field_by_post_id($id, 'city');

?>

<style type="text/css">

@page {
  margin: 1cm 2cm 1cm 2cm;
}

body {
  font-family: sans-serif;
  margin: 0.5cm 0cm 1.3cm 0cm;
  padding:115px 0px 12px 0px;
  text-align: justify;
    background:url(http://interactiva.loc/elymki/img/pdf/cotizacion_bg.jpg) no-repeat;
    font-size:11pt;
}

#header,
#footer {
  position: fixed;
  left: 0;
  right: 0;

}

#header {
  top: 0;
  float:left;
  height:115px;
  background:url(http://interactiva.loc/elymki/img/pdf/cotizacion_h.jpg) no-repeat;
}

#footer {
  bottom: 0;
  height:43px;

  background:url(http://interactiva.loc/elymki/img/pdf/cotizacion_f.jpg) no-repeat;
}


#prueba { column-count: 7; column-width: 200px; }


</style>


</head>

    <body>

    <div id="header">

    </div>

    <div id="footer">
      
    </div>
<table border="0" width="100%">
  <tr>
    <td>
      <?php if (!empty($authUser['city']) or $authUser['city']!=null){
      echo $authUser['city']; 
      } ?> 
      <?php echo $fecha_cot;?>
    </td>
    <td align="right">Cot <?php echo $id_cotizacion;?></td>
  </tr>
</table><br>


<?php
echo "Señor(a)<br>";
echo "<b style='text-transform:uppercase;'>".$authUser['name'].' '.$authUser['last_name'].'</b><br></b>';
echo 'Ciudad<br><br><br>';
echo 'Estimado Cliente<br><br><br>';
echo 'Texto de bienvenida. <br /><br />
Su grua a continuación.<br />
<br />
<br />
';
?>


    </body>


<form action="" method="post">
<input name="item" title="Generar PDF" type="image"  src='https://cdn0.iconfinder.com/data/icons/fatcow/32x32/file_extension_pdf.png' value="Descargar PDF" />
<input type="hidden" name="url" value="http://interactiva.loc/Elymki/pdf/12" />
<input type="hidden" name="id_cotizacion" value="<? echo $id_cotizacion; ?>" />
<input type="hidden" name="titulo" value="Cotización grua" />
</form>




</html>