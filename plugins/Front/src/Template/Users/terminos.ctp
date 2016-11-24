

<!-- contenido principal -->
<section class="content background">
  <div class="wrap wrap-user_profile terms_description">
      
      <?php if(isset($terminos) && !empty($terminos)) { ?>

      <section class="description_terms">
          <h2><?= $terminos->name;?></h2>
          <br>
          <?= $terminos->description;?>
      </section>

      <?php } ?>
      <!-- formulario de datos -->   


      <!-- descripcion de la categoria -->
            <article class="formulario_content">
              <h1 class="fondo1 content-side_description_title"><?= __($extras['general_data_term']); ?></h1><br>             
                  
                  <aside class="image_terms"><?php echo $this->Html->image($imagen."/picture?width=400&height=400", array("alt" => "Perfil", 'style'=>'vertical-align:top;')); ?></aside>

                  <?php //campos del formulario
                        $campos = ['name' => ['label' => __($extras['name']), 'class' => 'input-contact', 'requred' => 'requred', 'value' => $usuario['name']], 
                                   'last_name' => ['label' => __($extras['last_name']), 'class' => 'input-contact', 'requred' => 'requred', 'value' => $usuario['last_name']],
                                   'email' => ['label' => __($extras['email']), 'class' => 'input-contact', 'requred' => 'requred', 'value' => $usuario['email']], 
                                   //'tel' => ['label' => __($extras['phone']),  'placeholder' => __($extras['tel']), 'class' => 'input-contact', 'type' => 'tel', 'requred' => 'requred'], 
                                   'cel' => ['label' => __($extras['celphone']), 'placeholder' => __($extras['cel']), 'class' => 'input-contact indicative_cel', 'type' => 'tel', 'requred' => 'requred'], 
                                   'term' => ['label' => __($extras['term']), 'type' => 'checkbox', 'class' => 'input-contact', 'requred' => 'requred'], 
                                   __($extras['login']) => ['label' => false, 'class' => 'btn btn-terms fondo1 fondoh3 color3 colorh0', 'type' => 'submit'], 
                                  ];

                      echo $this->Form->create('contact', ['class' => 'formulario formulario_terms formulario_contacto']);

                        foreach ($campos as $name => $options) {
                                            echo $this->Form->input($name, $options); 
                                    } 
                      
                      //echo $this->Form->input('term', ['label' => $extras['term'], 'type' => 'checkbox', 'class' => 'input-contact terms', 'required' => true]); 
                                    
                  echo $this->Form->end(); ?>

            </article>


      
  
  </div>
</section>


<script type="text/javascript">
  
  jQuery(document).ready(function() {
                        
          $('<?= $this->Form->input('code_cel', ['label' => false, 'class' => 'code_phone input-contact', 'placeholder' => __($extras["indicative"]), 'div' => false, 'requred' => 'requred']); ?>').insertBefore(".indicative_cel");
          $('<?= $this->Form->input('area_cel', ['label' => false, 'class' => 'input-contact area_phone', 'placeholder' => __($extras["area_cel"]), 'div' => false, 'requred' => 'requred']); ?>').insertBefore(".indicative_cel");

  });

</script>





