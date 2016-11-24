
<!DOCTYPE html>
<html style="width:350px;">
<head>

  <title><?= $blogName; ?></title>

  <?php

	echo $this->Html->meta('icon', $favicon);


    //echo $this->Html->script('//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.js');   
    echo $this->Html->script('front/jquery-1.7.2.min');   
    echo $this->Html->css('Front.front/elymki', ['media' => 'screen']);

    echo $this->Html->script('front/number_format');  // formato de números debe ir en la parte de arriba.

	
	$id = $content->id;
  $avalible = $this->Get->get_field_by_post_id($content->id, 'avalible');
  $precio = $this->Get->get_field_by_post_id($content->id, 'price');
  $tons = $this->Get->get_field_by_post_id($content->id, 'tons');
  $brand = $this->Get->get_field_by_post_id($content->id, 'brand');
  $year = $this->Get->get_field_by_post_id($content->id, 'year');

  $min = $precio/2;

  $price = $this->Number->currency($precio, $info['currency']);
  $minPrice = $this->Number->currency($min, $info['currency']);


?>


<?php foreach($colors as $key => $color) { ?>
  <style type="text/css">
        .color<?=  $key; ?>, .colorh<?=  $key; ?>:hover { color:#<?=  $color; ?>; }
        .fondo<?=  $key; ?>, .fondoh<?=  $key; ?>:hover { background-color:#<?=  $color; ?>; }
        .border<?=  $key; ?>, .borderh<?=  $key; ?>:hover { border-color:#<?=  $color; ?> !important; }       
  </style>
<?php } ?>
  
  <style type="text/css">
    .background { background-color: <?=  $background; ?>; } /* background-principal */
    /* colores personalizados */

    .nav li a:hover, .pagin-count nav a:hover { color:#<?=  $colors[1]; ?>; } 
    .buscador .submit:before, .bx-wrapper .bx-pager.bx-default-pager a:hover, .bx-wrapper .bx-pager.bx-default-pager a.active, .footer_title:before, .slide_info h3:before, .order-table .input-sort:hover, .order-table a:hover, .is-checked, .pagin-count nav a, #example-one ul li a.current 
    { background-color:#<?=  $colors[1]; ?>; } 
    
    .order-table .input-sort, .order-table a, .pagin-count nav a, .users_table-item th a, #example-one ul li.post-tab a.current, #infoMaps span a, .content-side_description_text font a, a[href^="mailto"] { color:#<?=  $colors[2]; ?>; }

    .buscador .submit:hover :before, .bx-wrapper .bx-pager.bx-default-pager a, .pagin-count nav a:hover, .formulario div  { background-color:#<?=  $colors[2]; ?>; }

    a.btn { text-align: center; margin:5px 0; }

    

  </style>

</head>

<body style="width:350px;">
    
<!-- comprar vender fanbyxox -->
<section id="bloque_popup" class="loginbox" style="display: block; width: 350px;">


    <?php if(!$this->request->data) { ?>

                <h2><?= __($extras[$avalible]); ?></h2>
      
                <p><?= __($extras[$avalible.'_crane_description']); ?></p>
                
                <?php 

                                                        //array con fechas
                if($avalible == 'rent') {
                                                        $inputs = ['company_name' => ['label' => false, 'placeholder' => $extras['name'], 'value' => $this->Get->get_company_name($authUser['id']), 'readonly' => true, 'title' => __($extras['company_name']), 'class' => 'tooltip'],
                                                                   'company_position' => ['type' => 'hidden', 'placeholder' => $extras['company_position'], 'value' => $authUser['company_position'], 'readonly' => true, 'title' => __($extras['company_position']), 'class' => 'tooltip'],
                                                                   'post_name' => ['label' => false, 'value' => $content->name.' | '. __($extras['code']) .' '. $content->id, 'readonly' => true],
                                                                   'country' => ['label' => false, 'required' => true, 'type' => 'select', 'empty' => __($extras['country']), 'class' => 'country'],                                                         
                                                                   'state' => ['label' => false, 'required' => true, 'type' => 'select', 'empty' => __($extras['state']), 'class' => 'state'],
                                                                   'city' => ['label' => false, 'type' => 'select', 'empty' => __($extras['city']), 'class' => 'city'],
                                                                   'postal_code' => ['label' => false, 'placeholder' => $extras['proyect_zip_code']],
                                                                   'description' => ['label' => false, 'placeholder' => $extras['your_offer'], 'required' => true, 'type' => 'textarea'],
                                                                   'industry_type' => ['type' => 'hidden', 'value' => __($extras[$authUser['industry_type']]), 'readonly' => true, 'title' => __($extras['industry_type']), 'placeholder' => __($extras['industry_type']), 'class' => 'tooltip'],
                                                                   'equipment_buy_status' => ['type' => 'hidden', 'value' => __($extras[$authUser['equipment_buy_status']]), 'readonly' => true, 'title' => __($extras['equipment_buy_status']), 'placeholder' => __($extras['equipment_buy_status']), 'class' => 'tooltip'],
                                                                   'operator' => ['label' => false, 'type' => 'select', 'options' => $requireOperator, 'empty' => __($extras['require_operator']) ],
                                                                   'date_start' => ['label' => false, 'placeholder' => __($extras['date_start']), 'type' => 'text', 'required' => true, 'class' => 'datepick'],
                                                                   'date_end' => ['label' => false, 'placeholder' => __($extras['date_end']), 'type' => 'text', 'required' => true, 'class' => 'datepick'],
                                                                   'type' => ['value' => $avalible, 'type' => 'hidden'],
                                                                   'tons' => ['value' => $tons, 'type' => 'hidden'],
                                                                   'crane_type' => ['value' => $this->Get->get_categories_by_post($id), 'type' => 'hidden'],
                                                                   'year' => ['value' => $year, 'type' => 'hidden'],
                                                                   'user_id' => ['value' => $authUser['id'], 'type' => 'hidden'],
                                                                   'post_id' => ['value' => $content->id, 'type' => 'hidden'],
                                                                   'author_id' => ['value' => $content->user_id, 'type' => 'hidden'],
                                                                   'relationships' => ['label' => __($extras['send_to_all_companies']), 'type' => 'checkbox', 'value' => 1],                                                           
                                                                   $extras['send'] => ['label' => false, 'type' => 'submit', 'class' => 'btn btn-link fondo1 fondoh2 color0', 'name' => $key],
                                                                  ]; 
                  } else { 

                                                       $inputs = ['company_name' => ['label' => false, 'placeholder' => $extras['name'], 'value' => $this->Get->get_company_name($authUser['id']), 'readonly' => true],
                                                                   'company_position' => ['type' => 'hidden', 'placeholder' => $extras['company_position'], 'value' => $authUser['company_position'], 'readonly' => true],
                                                                   'post_name' => ['label' => false, 'value' => $content->name.' | '. __($extras['code']) .' '. $content->id, 'readonly' => true],
                                                                   'post_price' => ['label' => false, 'value' => $price, 'readonly' => true],
                                                                   'value1' => ['label' => false, 'placeholder' => $extras['tender_placeholder'], 'required' => true],
                                                                   'value' => ['value' => '', 'type' => 'hidden'],
                                                                   //'country' =>['label' => false, 'placeholder' => $extras['country'], 'required' => true, 'type' => 'select', 'options' => $countryNames, 'empty' => __($extras['country']), 'class' => 'country_offer'],                                                         
                                                                   'crane_type' => ['value' => $this->Get->get_categories_by_post($id), 'type' => 'hidden'],
                                                                   'postal_code' => ['label' => false, 'placeholder' => $extras['zip_code'], 'type' => 'hidden'],
                                                                   'description' => ['label' => false, 'placeholder' => $extras['your_offer'], 'required' => true, 'type' => 'textarea', 'type' => 'hidden'],
                                                                   'type' => ['value' => $avalible, 'type' => 'hidden'],
                                                                   'user_id' => ['value' => $authUser['id'], 'type' => 'hidden'],
                                                                   'author_id' => ['value' => $content->user_id, 'type' => 'hidden'],
                                                                   'post_id' => ['value' => $content->id, 'type' => 'hidden'],
                                                                   $extras['sell'] => ['label' => false, 'type' => 'submit', 'class' => 'btn btn-link fondo1 fondoh2 color0', 'name' => $key],
                                                                 ];
                  }

                   

                   echo $this->Form->create($this->request->params['controller'], ['url' => ['controller' => 'Posts', 'action' => 'offer', $content->id], 'class' => 'login-form']);

                  foreach ($inputs as $name => $options) {
                          echo $this->Form->input($name, $options);
                  }

                  echo $this->Form->end(); 
                  
                ?>


    <?php } else { ?>

      <h2><?= $respuesta; ?></h2>

    <?php } ?>
        

</section>
<!-- comprar vender fanbyxox -->

<?= $this->Html->css('front/jquery-ui'); // css jquery UI.
    echo $this->Html->script('front/jquery-ui.min'); // jquery UI ?>

<?= $this->Html->script('Administrator.locations');  // formato de números debe ir en la parte de arriba. ?>


<script type="text/javascript">
    
    //validar el dato de precio cuando se esta ofertando un producto
    $('#value1').change( function() {

          var val = $(this).val();
          
          if(!$.isNumeric(val)) {

              alert('<?= $extras["write_valid_value"]; ?>');
              $(this).val('');
          
          } else {

                if('<?= $min; ?>' > val) {

                     alert('<?= $extras["min_offer"]; ?>: <?= $minPrice; ?>');
                     $(this).val('<?= $info["currency"]; ?> $ ' + number_format('<?= $min; ?>'));
                     $('#value').attr('value', '<?= $min; ?>');

                } else {

                    $(this).val('<?= $info["currency"]; ?> $ ' + number_format(val));
                    $('#value').attr('value', val);

                }

          }

    });

    //autocompletar fechas
     $(document).ready(function() {

                             // fechas con Jquery
                            $('.datepick').each(function(i) {
                                this.id = 'datepicker' + i;
                            }).datepicker();                 

                            
                            $('#datepicker0').change(function() {
                              var datMin = $(this).val();
                              $('#datepicker1').datepicker('option', 'minDate', new Date(datMin));
                            });                         
  });

</script>

</body>
</html>