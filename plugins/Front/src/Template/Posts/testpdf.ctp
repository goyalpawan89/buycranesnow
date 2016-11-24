
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>PDF</title>
  <?php
  
  //$crane->id = $crane->id;
  /*$address = $this->Get->get_field_by_post_id($crane->id, 'location'); 
  $city = $this->Get->get_field_by_post_id($crane->id, 'city');*/

?>

<style type="text/css">

@page {
  margin: 1cm 2cm 1cm 2cm;
}

body {
  font-family: sans-serif;
  margin: 0.5cm 0cm 1.3cm 0.1cm;
  padding:85px 0px 12px 0px;
  text-align: justify;
    background:url(http://nextcrane.com/img/pdf/cotizacion_bg.jpg) no-repeat;
    font-size:10pt;
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
  height:86px;
  background:url(http://nextcrane.com/img/pdf/cotizacion_h.jpg) no-repeat;
}

#footer {
  bottom: 0;
  height:43px;

  background:url(http://nextcrane.com/img/pdf/cotizacion_f.jpg) no-repeat;
}


#img {
  max-width: 99%;
  float: left;
  display:block;
}

.content-side_description_title { display: block; padding: 10px; box-sizing: border-box; text-transform: uppercase; font-size: 15px; margin-top:0px; }
.content-side_description_text { border: 1px solid rgb(221, 221, 221); border-top:0; box-sizing: border-box; padding:6px 10px; }
.content-side_description_text:nth-child(2n+1) { background-color: #dfdfdf; }
.content-side_description_text > strong { margin-bottom: 10px; display: block; }

.content-side_description_text b {
    width: 30%;
    display: inline-block;
    text-transform: uppercase;
}


.all_fields, .all_fields2{
  margin-bottom: 1cm;
}
.all_fields2 div:first-child{
border-top: 1px solid rgb(221, 221, 221); 
}
.all_fields2 div{
  border: 1px solid rgb(221, 221, 221); border-top:0; box-sizing: border-box; padding:6px 11px; 
}


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
      <?php /*if (!empty($authUser['city']) or $authUser['city']!=null){
      echo $authUser['city']; 
      }*/ ?> 
      <?php echo $fecha_cot; ?>
    </td>
    <tr>
    <?php /* <td><b>Cot</b> <?php echo $crane->id_cotizacion;?></td> */ ?>
  </tr>
  </tr>
</table><br>
<br>
<?php //echo $this->Cookie->read('name');?>
<?php echo $extras['quote_title']; ?><br><br><br> 
<?php echo $extras['sr']; ?><br> 
<b style='text-transform:uppercase;'><?= $nombre; ?></b><br></b>
<?php if(isset($company)){?>
  <b style='text-transform:uppercase;'><?= $company; ?></b><br></b>
  <?php } ?>

<br />

<b><?php echo __d('front', 'Crane');?> <?= $crane->name;?> | <?= $extras['code']; ?> <?= $crane->id;?><br />
<br />
<br />
<?= $crane->description;?>
<br />



<table>
<aside class="all_fields">
    <h1 class="fondo2 color0 content-side_description_title details"><?= __($extras['details']); ?></h1>

    <?php 

        if(isset($crane->fields) && !empty($crane->fields)) {
            foreach ($crane->fields as $field) {
                  if(!empty($field->option_key)) {
                      if($field->option_key == 'price' || $field->option_key == 'price_before') {
                        $val = $this->Number->currency($this->Get->get_field_by_post_id($crane->id, $field->option_key), $info['currency']);
                    } else { 
                        $val = $field->_joinData->value; 
                    } ?>
            
                  <?php if(!empty($val)) { ?>
                    <div class="content-side_description_text fields">
                      <b><?= __($extras[$field->option_key]); ?>: </b> <font><?= $val; ?></font>
                    </div>
                  <?php } ?>

    <?php } } } ?>
</aside>





</table>

    <?php if(isset($techinical) && !empty($techinical)) { ?>
    <aside class="all_fields2">

    <h1 class="fondo2 color0 content-side_description_title details"><?= __($extras['technical_specifications']); ?></h1>
    <?php  foreach ($techinical as $field) {
          $value = $this->Get->get_field_by_post_id($crane->id, $field['option_key']);   ?>
            <?php if(!empty($value)) { ?>
            <div><b><?= __d('front', $field['option_label']); ?>:</b> <?= $value;?> </div>
            <?php } ?>
    <?php }  ?>
    </aside>
    <?php } ?>

    <?php if(isset($structure) && !empty($structure)) {?>
    <aside class="all_fields2">

    <h1 class="fondo2 color0 content-side_description_title details"><?= __($extras['crane_structure']); ?></h1>
    <?php  foreach ($structure as $field) {
          $value = $this->Get->get_field_by_post_id($crane->id, $field['option_key']);   ?>
            <?php if(!empty($value)) { ?>
            <div><b><?= __d('front', $field['option_label']); ?>:</b> <?= $value;?> </div>
          <?php } ?>
    <?php } ?>
    </aside>
    <?php } ?>

    <?php if(isset($truck_structure) && !empty($truck_structure)) {?>
    <aside class="all_fields2">

    <h1 class="fondo2 color0 content-side_description_title details"><?= __($extras['truck_structure']); ?></h1>
    <?php  foreach ($truck_structure as $field) {
          $value = $this->Get->get_field_by_post_id($crane->id, $field['option_key']);   ?>
          <?php if(!empty($value)) { ?>
            <div><b><?= __d('front', $field['option_label']); ?>:</b> <?= $value;?> </div>
          <?php } ?>
    <?php }  ?>
    </aside>
    <?php } ?>

    <?php if(isset($prices) && !empty($prices)) {?>
    <aside class="all_fields2">

    <h1 class="fondo2 color0 content-side_description_title details"><?= __($extras['prices']); ?></h1>
    <?php  foreach ($prices as $field) {
          $value = $this->Get->get_field_by_post_id($crane->id, $field['option_key']);   ?>
          <?php if(!empty($value)) { ?>
            <div><b><?= __d('front', $field['option_label']); ?>:</b> <?= $value;?> </div>
          <?php } ?>
    <?php }  ?>
    </aside>
    <?php } ?>
 
 <?php if(isset($others) && !empty($others)) {?>
    <aside class="all_fields2">

    <h1 class="fondo2 color0 content-side_description_title details"><?= __($extras['others']); ?></h1>
   <?php  foreach ($others as $field) {
          $value = $this->Get->get_field_by_post_id($crane->id, $field['option_key']);   ?>
          <?php if(!empty($value)) { ?>
            <div><b><?= __d('front', $field['option_label']); ?>:</b> <?= $value;?> </div>
          <?php } ?>
    <?php } ?>
    </aside>
<?php } ?>



<br />

<div style="padding:15px; box-sizing:border-box; width:100%; display:block;">
  
 <?php  if(isset($crane->archives) && !empty($crane->archives)) {
        
        foreach ($crane->archives as $a => $archive) {

          if($archive->mimetype == 'image/png' || $archive->mimetype == 'image/png' || $archive->mimetype == 'image/jpeg' || $archive->mimetype == 'image/gif' || $archive->mimetype == 'image/gif') { ?>
                  
                  <img src="<?= $this->Image->url($archive->id, 'medium'); ?>"><br><br>

                  <?php if($a == 3) { break; } ?>

  <?php } } } ?>

  

</div>



    </body>



</html>