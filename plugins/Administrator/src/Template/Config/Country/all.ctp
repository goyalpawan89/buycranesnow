<h1>Total Paises: <?php echo $total;?></h1>

<?php 


//echo pr($datos);
echo 'Paises';

echo '<br>';
echo '<br>';
foreach ($datos as $key => $value) {
  # code...
  echo $value->Name;
  echo '<br>';
  echo $value->Code;
  echo '<br>';
  echo '<br>';
}


?>