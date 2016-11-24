
<div id="login" class="login-forget">

    <!-- login form-->
    <?php echo $this->Form->create('User', ['url' => ['action' => 'forgetpwd']]);  
          
          // campos input de la página
          $campos = array('email' => ['type' => 'email', 'label' => false, 'placeholder' => __d('administrator', 'Ingresa tu correo electrónico'), 'id' => 'usuario', 'class' => 'form-control usuario'], );

              foreach ($campos as $name => $campo) {
                  echo $this->Form->input($name, $campo); 	
              }

          // fin campos input de la página ?>
          
          <p><button type="submit" class="fondo3 color5 fondoh2"><?php echo __d('administrator', 'Enviar'); ?></button></p>

	<?php echo $this->Form->end(); ?>
    <!--fin login form-->

    <center><p class="example-item color2" id="modal-ajax"><?= __d('administrator', 'Revisa tu correo electrónico para continuar.'); ?></p></center>
    
</div>
