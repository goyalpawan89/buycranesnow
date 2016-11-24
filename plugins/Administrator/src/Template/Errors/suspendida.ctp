<center>

<div id='logo'><?php echo $this->Html->image($informacion['logo'], array("width" => "60%", "alt" => "Logo")) ;?>

</div></center>

<div id="login">
<center>
<?php echo __('<h2>Licencia '.$informacion['titulo'].'</h2>'); ?>
<p><?php echo __('<b>Error '.$informacion['tipo'].'</b>'); ?></p>
<br />
<?php echo $informacion['msj'];?>
<ul style="text-align:left; padding:0px 0px 0px 23px; margin:15px 0px">
<?php foreach($informacion['item'] as $item){?>
<li><?php echo $item;?></li>
<?php } ?>
</ul>
<br />


<?php 
$myText=$informacion['msj2'].' '.$informacion['contacto'].'';

echo $this->Text->autoLinkEmails($myText);?>
<br /><br />
<?php echo $this->Html->link($informacion['msj3'], array('controller' => 'errors', 'action' => 'license'));?>


</center>
</div>
