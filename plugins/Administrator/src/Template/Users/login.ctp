
    <center>
      
      <?php if($logo) { ?>
          <a href='<?= $this->Url->build('/', true); ?>'><img src="<?= $this->Url->build('/', true).$logo;?>" alt='Logo' title='Elymki <?= $blogName; ?>'></a>
          <br>
          <br>
      <?php } ?>

    </center>

    <div id="login" class="opacity">

    <!-- login form-->
    <?php echo $this->Form->create(); 
          
          // campos input de la página
          $campos = array('email'    => ['label' => false, 'placeholder' => __d('administrator', 'Ingresa tu correo electrónico'), 'id' => 'usuario', 'class' => 'form-control usuario'],
                          'password' => ['label' => false, 'placeholder' => __d('administrator', 'Ingresa tu contraseña'), 'type' => 'password', 'id' => 'pass', 'autocomplete' => 'off', 'class' => 'form-control password'],
                         );

              foreach ($campos as $name => $campo) {
                  echo $this->Form->input($name, $campo); 	
              }

          // fin campos input de la página ?>
          
          <p><button type="submit" class="fondo3 color5 fondoh2"><?php echo __d('administrator', 'Iniciar sesión'); ?></button></p>

          <?php echo $this->Form->end(); 

    ?>
    <!--fin login form-->
    
    <p class="example-item" id="modal-ajax"><a href="javascript;"><?php echo __d('administrator', '¿Olvidó su contraseña?'); ?></a></p>

    </div>


<script>
	
	 $("modal-ajax").addEvent("click", function(e){
    e.stop();
  //var SM = new SimpleModal({"btn_ok":"Confirm button", "width":600});
    
        var SM = new SimpleModal(
            {
            "hideFooter":true,
              "btn_ok":"Confirm button",
              "overlayClick":true,
              "width":400,
              "onAppend":function(){
                $("simple-modal").fade("hide");
                setTimeout((function(){ $("simple-modal").fade("show")}), 200 );
                var tw = new Fx.Tween($("simple-modal"),{
                  duration: 1600,
                  transition: 'bounce:out',
                  link: 'cancel',
                  property: 'top'
                }).start(-400, 150)

                var item = $("simple-modal").getElement(".simple-modal-footer a");
                    item.removeClass("primary").setStyles({"background":"#824571","color": "#FFF" });
                    item.getParent().addClass("align-left");
	                  item.addEvent("mouseenter", function(){
	                    var parent = this.getParent();
	                    if( parent.hasClass("align-left") ){
	                      parent.removeClass("align-left").addClass("align-right");
	                    }else{
	                      parent.removeClass("align-right").addClass("align-left");
	                    }
	                  })
              }
            });
    
  
        // Aggiunge Bottone annulla
        SM.addButton("Cancelar", "btn");
        SM.show({
          "model":"modal-ajax",
          "title":"Has olvidado tu contraseña?",
          "param":{
          "url":"<?php echo $this->Url->build('/', true);?>admin/Users/forgetpwd",
            "onRequestComplete": function(){ }
          }
        });
  })
  
</script>
