<?php 


//echo pr($datos);
echo 'Ciudades de '.$datos[0]->Name;

echo '<br>';
echo '<br>';
foreach ($datos as $key => $value) {
  # code...
  echo $value->city->Name;
  echo '<br>';
}


?>