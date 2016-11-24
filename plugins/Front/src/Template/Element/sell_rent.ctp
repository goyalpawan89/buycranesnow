

<?php 

if(isset($authUser)) {

$forms = ['sell_crane' => ['type' => 'COMPRAR'],  'rent_crane' => ['type' => 'ALQUILAR']]; 
      
foreach ($forms as $key => $form) { ?>

<!-- comprar vender fanbyxox -->
<section id="<?= $key; ?>" class="loginbox">

    <h2><?= __($extras[$key]); ?></h2>
    
    <p><?= __($extras[$key.'_description']); ?></p>
        
        <?php 
          if($key == 'rent_crane') {

                                                //array con fechas
                                                $inputs = ['company_name' => ['label' => false, 'placeholder' => $extras['name'], 'value' => $this->Get->get_company_name($authUser['id']), 'disabled' => true, 'title' => __($extras['company_name']), 'class' => 'tooltip'],
                                                           'company_position' => ['label' => false, 'placeholder' => $extras['company_position'], 'value' => $authUser['company_position'], 'disabled' => true, 'title' => __($extras['company_position']), 'class' => 'tooltip'],
                                                           'post_name' => ['label' => false, 'value' => $content->name.' | '. __($extras['code']) .' '. $content->id, 'disabled' => true],
                                                           'value' => ['label' => false, 'type' => 'hidden'],
                                                           'country' => ['label' => false, 'placeholder' => $extras['proyect_country'], 'required' => true, 'type' => 'select', 'options' => $countryNames, 'empty' => __($extras['country'])],                                                         
                                                           'city' => ['label' => false, 'placeholder' => $extras['proyect_city'], 'required' => true, 'type' => 'select', 'options' => $cityNames, 'empty' => __($extras['city'])],
                                                           'postal_code' => ['label' => false, 'placeholder' => $extras['proyect_zip_code']],
                                                           'description' => ['label' => false, 'placeholder' => $extras['your_offer'], 'required' => true, 'type' => 'textarea'],
                                                           'industry_type' => ['label' => false, 'value' => __($extras[$authUser['industry_type']]), 'disabled' => true, 'title' => __($extras['industry_type']), 'placeholder' => __($extras['industry_type']), 'class' => 'tooltip'],
                                                           'equipment_buy_status' => ['label' => false, 'value' => __($extras[$authUser['equipment_buy_status']]), 'disabled' => true, 'title' => __($extras['equipment_buy_status']), 'placeholder' => __($extras['equipment_buy_status']), 'class' => 'tooltip'],
                                                           'operator' => ['label' => false, 'type' => 'select', 'options' => $requireOperator, 'empty' => __($extras['require_operator']) ],
                                                           'date_start' => ['label' => false, 'placeholder' => __($extras['date_start']), 'type' => 'text', 'required' => true, 'class' => 'datepick'],
                                                           'date_end' => ['label' => false, 'placeholder' => __($extras['date_end']), 'type' => 'text', 'required' => true, 'class' => 'datepick'],
                                                           'type' => ['value' => $form['type'], 'type' => 'hidden'],
                                                           'user_id' => ['value' => $authUser['id'], 'type' => 'hidden'],
                                                           'post_id' => ['value' => $content->id, 'type' => 'hidden'],
                                                           'author_id' => ['value' => $content->user_id, 'type' => 'hidden'],
                                                           //'all_company' => ['label' => __($extras['send_to_all_companies']), 'type' => 'checkbox'],                                                           
                                                           $extras['send'] => ['label' => false, 'type' => 'submit', 'class' => 'btn btn-link fondo1 fondoh2 color0', 'name' => $key],
                                                          ]; 
                                            } else {

                                               $price = $this->Number->currency($this->Get->get_field_by_post_id($content->id, 'price'), $info['currency']);

                                               $inputs = ['company_name' => ['label' => false, 'placeholder' => $extras['name'], 'value' => $this->Get->get_company_name($authUser['id']), 'disabled' => true],
                                                           'company_position' => ['label' => false, 'placeholder' => $extras['company_position'], 'value' => $authUser['company_position'], 'disabled' => true],
                                                           'post_name' => ['label' => false, 'value' => $content->name.' | '. __($extras['code']) .' '. $content->id, 'disabled' => true],
                                                           'post_price' => ['label' => false, 'value' => $price, 'disabled' => true],
                                                           'value' => ['label' => false, 'placeholder' => $extras['tender_placeholder'], 'required' => true],
                                                           'country' => ['label' => false, 'placeholder' => $extras['country'], 'required' => true, 'type' => 'hidden'],                                                         
                                                           'city' => ['label' => false, 'placeholder' => $extras['city'], 'required' => true, 'type' => 'hidden'],
                                                           'postal_code' => ['label' => false, 'placeholder' => $extras['zip_code'], 'type' => 'hidden'],
                                                           'description' => ['label' => false, 'placeholder' => $extras['your_offer'], 'required' => true, 'type' => 'textarea', 'type' => 'hidden'],
                                                           'type' => ['value' => $form['type'], 'type' => 'hidden'],
                                                           'user_id' => ['value' => $authUser['id'], 'type' => 'hidden'],
                                                           'author_id' => ['value' => $content->user_id, 'type' => 'hidden'],
                                                           'post_id' => ['value' => $content->id, 'type' => 'hidden'],
                                                           $extras['sell'] => ['label' => false, 'type' => 'submit', 'class' => 'btn btn-link fondo1 fondoh2 color0', 'name' => $key],
                                                         ]; 

           }
           

           echo $this->Form->create($this->request->params['controller'], ['url' => '', 'class' => 'login-form']);

          foreach ($inputs as $name => $options) {
                  echo $this->Form->input($name, $options);
          }

          echo $this->Form->end(); 

        ?>
        

</section>
<!-- comprar vender fanbyxox -->


<?php } } ?>
