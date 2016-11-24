
    <center>
      <?php echo $this->Html->image($logo, ['alt' => $blogName, 'class' => 'logo']); ?>
    </center>

    <div id="login" class="opacity">

    <!-- login form-->
    <?php echo $this->Form->create(); 
          
          // campos input de la página
          $campos = array('password' => 			 ['label' => false, 'placeholder' => __d('administrator', 'Contraseña'), 'type' => 'password', 'class' => 'form-control usuario'],
                          'password_confirmation' => ['label' => false, 'placeholder' => __d('administrator', 'Repita su contraseña'), 'type' => 'password', 'autocomplete' => 'off', 'class' => 'form-control password'],
                         );

              foreach ($campos as $name => $campo) {
                  echo $this->Form->input($name, $campo); 	
              }

          // fin campos input de la página ?>
          
          <p><button type="submit" class="fondo1 color2 opacityh"><?php echo __d('administrator', 'Cambiar contraseña'); ?></button></p>

          <?php echo $this->Form->end(); 

    ?>
    <!--fin login form-->
    
    </div>