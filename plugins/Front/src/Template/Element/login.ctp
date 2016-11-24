<!-- register SELECT box sin lightbox-->

<section id="select_register" class="loginbox">
    
    <h2><?= __($extras['select_register']); ?></h2>

    <aside class="aside-form">
        <center>
            <?= $this->Html->link($extras['user_register'], '#register', ['class' => 'btn btn-link fancybox fondo1 color3 fondoh3 colorh1']); ?>
        </center>
    </aside>
    
    <p class="or"><?= __($extras['or']); ?></p>

    <aside class="aside-form">
        <center>
            <?= $this->Html->link($extras['company_register'], '#register_company', ['class' => 'btn btn-link fancy_company fondo1 color3 fondoh3 colorh1']); ?>
        </center>
    </aside>

      <?= $this->Html->link(__($extras['accept_terms']), $this->Get->get_link(41, 'Pages'), ['target' => '_blanck', 'class' => 'terminos post-user_contact_list_item before-list_item color3 colorh4']); ?>

</section>


<!-- register COMPANY box sin lightbox-->


<section id="register_company" class="loginbox">
  
            <h2><?= __($extras['company_register']); ?></h2>
          
            <!-- login DB div -->

            <aside class="aside-form">

                        <p><?= __($extras['complete_form']); ?></p>
                        
                        <?php $inputs = ['name' => ['label' => false, 'placeholder' => $extras['name'].' *', 'required' => true], 
                                         'last_name' => ['label' => false, 'placeholder' => $extras['last_name'].' *', 'required' => true], 
                                         'email' => ['label' => false, 'placeholder' => $extras['email'].' *', 'type' => 'email', 'required' => true, 'autocomplete' => 'off', 'class' => 'new_email'],
                                         'password' => ['label' => false, 'placeholder' => $extras['password'].' *', 'type' => 'password', 'required' => true, 'autocomplete' => 'off'],
                                         'password_confirm' => ['label' => false, 'placeholder' => $extras['password_confirmation'].' *', 'type' => 'password', 'required' => true, 'autocomplete' => 'off'],
                                         'company_name' => ['label' => false, 'placeholder' => $extras['company_name'].' *'],
                                         'company_email' => ['label' => false, 'placeholder' => $extras['company_email'].' *'],
                                         //'company_identification' => ['label' => false, 'placeholder' => $extras['company_identification']],
                                         'anti' => ['label' => __('Digita este valor:'). $anti, 'placeholder' => __('Antispam *'), 'required' => true, 'autocomplete' => 'off'],
                                         $extras['create'] => ['label' => false, 'type' => 'submit', 'class' => 'btn btn-link fondo1 fondoh2 color0 new_create', 'name' => 'register'],
                                        ]; 

                           echo $this->Form->create($create_user, ['url' => ['controller' => 'Users', 'action' => 'add_user'], 'class' => 'login-form register_form', 'autocomplete' => 'off']);

                          foreach ($inputs as $name => $options) {

                                  if($name == 'password') { //agregar el div de validaciones
                                    echo '<div class="password-comparation"><div id="pass-info"></div></div>';
                                  }

                                  echo $this->Form->input($name, $options);
                          }

                          echo $this->Form->input('term', ['label' => false, 'type' => 'checkbox', 'class' => 'terms', 'required' => true]);
                          echo $this->Html->link(__($extras['accept_terms']), $this->Get->get_link(41, 'Pages'), ['target' => '_blanck', 'class' => 'terminos post-user_contact_list_item before-list_item color3 colorh4']); 

                          echo $this->Form->end(); 

                        ?>


              </aside>

</section>



<!-- register USER box sin lightbox-->

<?php /*

<section id="register" class="loginbox">
  
            <h2><?= __($extras['register']); ?></h2>
          
            <!-- login facebook div -->
            <aside class="aside-form">
            
                  <div class='entrar'>   
                        <div class='facebook-login color0'><?= $extras['facebook_singin'];?></div>
                        <aside class="facebook_login_btn" style="width:100%; overflow:hidden;position: absolute; left: 0px; margin-top: -30px; opacity: 0;">
                            <fb:login-button scope="public_profile,email,user_friends" onlogin="checkLoginState();" width="90">
                                  ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
                            </fb:login-button>
                        </aside>
                  </div>

                  <p><?= __($extras['facebook_login_description']); ?></p>

            </aside>
            <!-- login facebook div -->

            
            <p class="or"><?= __($extras['or']); ?></p>

            <!-- login DB div -->

            <aside class="aside-form">

                        <p><?= __($extras['complete_form']); ?></p>
                        
                        <?php $inputs = ['name' => ['label' => false, 'placeholder' => $extras['name'], 'required' => true], 
                                         'last_name' => ['label' => false, 'placeholder' => $extras['last_name'], 'required' => true], 
                                         'email' => ['label' => false, 'placeholder' => $extras['email'], 'type' => 'email', 'required' => true, 'autocomplete' => 'off', 'class' => 'new_email1'],
                                         'password' => ['label' => false, 'placeholder' => $extras['password'], 'type' => 'password', 'required' => true, 'autocomplete' => 'off'],
                                         'password_confirm' => ['label' => false, 'placeholder' => $extras['password_confirmation'], 'type' => 'password', 'required' => true, 'autocomplete' => 'off'],
                                         'code_cel' => ['label' => false, 'placeholder' => $extras['indicative'], 'class' => 'code_phone', 'type' => 'select', 'options' => $codigosTelefono],
                                         'area_cel' => ['label' => false, 'placeholder' => $extras['area_cel']],
                                         'cel' => ['label' => false, 'placeholder' => $extras['celphone']],
                                         $extras['create'] => ['label' => false, 'type' => 'submit', 'class' => 'btn btn-link fondo1 fondoh2 color0 new_create1', 'name' => 'register'],
                                        ]; 

                           echo $this->Form->create($create_user, ['url' => ['controller' => 'Users', 'action' => 'add_user'], 'class' => 'login-form register_form']);

                          foreach ($inputs as $name => $options) {

                                  if($name == 'password') { //agregar el div de validaciones
                                    echo '<div class="password-comparation"><div id="pass-info"></div></div>';
                                  }

                                  echo $this->Form->input($name, $options);
                          }

                          echo $this->Form->input('term', ['label' => false, 'type' => 'checkbox', 'class' => 'terms', 'required' => true]);
                          echo $this->Html->link(__($extras['accept_terms']), $this->Get->get_link(41, 'Pages'), ['target' => '_blanck', 'class' => 'terminos post-user_contact_list_item before-list_item color3 colorh4']); 

                          echo $this->Form->end(); 

                        ?>

              </aside>

</section>

<!-- fin register box sin lightbox-->

            */ ?>


<!-- login box -->
<section id="login" class="loginbox">

            <h2><?= __($extras['login']); ?></h2>
            
            <?php /*
            <!-- login facebook div -->
            <aside class="aside-form">
            
                  <div class='entrar'>   
                        <div class='facebook-login color0'><?= $extras['facebook_login'];?></div>
                        <aside class="facebook_login_btn" style="width:100%; overflow:hidden;position: absolute; left: 0px; margin-top: -30px; opacity: 0;">
                            <fb:login-button scope="public_profile,email,user_friends" onlogin="checkLoginState();" width="90">
                                  ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
                            </fb:login-button>
                        </aside>
                  </div>

                  <p><?= __($extras['facebook_login_description']); ?></p>

            </aside>
            <!-- login facebook div -->

            <p class="or"><?= __($extras['or']); ?></p>


            <!-- login DB div -->
            */ ?>
            

            <aside class="aside-form">
                        
                        <p><?= __($extras['start_session']); ?></p>
                        
                        <?php $inputs = ['email' => ['label' => false, 'placeholder' => $extras['email'], 'type' => 'email', 'required' => true],
                                         'password' => ['label' => false, 'placeholder' => $extras['password'], 'type' => 'password', 'required' => true],
                                         $extras['login'] => ['label' => false, 'type' => 'submit', 'class' => 'btn btn-link fondo1 fondoh2 color0', 'name' => 'login'],
                                        ]; 

                           echo $this->Form->create('Users', ['url' => ['controller' => 'Users', 'action' => 'login'], 'class' => 'login-form']);

                                  foreach ($inputs as $name => $options) {
                                          echo $this->Form->input($name, $options);
                                  }

                          echo $this->Form->end(); 

                        ?>

                        <p align="center"><?= $this->Html->link(__($extras['forgot_password']), '#change_password', ['class' => 'fancybox color3 colorh1']);  ?></p> 

            </aside>

            <aside class="dont_have_account">
                  <p align="center"><?= __($extras['dont_have_account']); ?> <b><?= $this->Html->link(__($extras['register']), '#register_company', ['class' => 'fancybox color3 colorh1']);  ?></b></p> 
            </aside>


            <!-- login DB div -->
      
</section>
<!--fin login box -->




<!-- login box -->
<section id="change_password" class="loginbox">

            <h2><?= __($extras['forgot_password']); ?></h2>
            

            <!-- login DB div -->

            <aside class="aside-form">
                        
                        <p><?= __($extras['write_email']); ?></p>
                        
                        <?= $this->Form->create('Users', ['url' => ['controller' => 'Users', 'action' => 'change_password'], 'class' => 'login-form']);

                                echo $this->Form->input('email', ['label' => false, 'placeholder' => $extras['email'], 'type' => 'email', 'required' => true]);
                                echo $this->Form->input($extras['send_email'], ['label' => false, 'type' => 'submit', 'class' => 'btn btn-link fondo1 fondoh2 color0', 'name' => 'login']);

                          echo $this->Form->end(); ?>

                        <p align="center"><b><?= $this->Html->link(__($extras['login_now']), '#login', ['class' => 'fancybox color3 colorh1']);  ?></b></p> 

            </aside>

            <!-- login DB div -->
      
</section>
<!--fin login box -->




<script type="text/javascript">

$('.new_email').change( function() {

  var email = $(this).val();

  $('.new_create').attr('disabled', 'disabled');

  //peticio ajax para validar si existe el correo en la DB
          $.get( "/user/userByEmail/" , { email: email }, function(data) {
          
          //input de email
          var input = $('.new_email');

                if(data == 1) {
                    
                    console.log(data);
                   
                    input.css({"border-color": "red", "border-width":"1px", "border-style":"solid"});
                    input.parent().prepend('<div class="password-comparation email_exist"><aside id="pass-info" class="stillweakpass"><center><?= $extras['user_already_exist']; ?></center></aside></div>');

                } else {
                    
                    $('.email_exist').hide();
                    input.css({"border-color":"green"});
                    $('.new_create').removeAttr('disabled');

                }
              
          });

});


$('.new_email1').change( function() {

  var email = $(this).val();

  $('.new_create1').attr('disabled', 'disabled');

  //peticio ajax para validar si existe el correo en la DB
          $.get( "/user/userByEmail/" , { email: email }, function(data) {
          
          //input de email
          var input = $('.new_email1');

                if(data == 1) {
                    
                    console.log(data);
                   
                    input.css({"border-color": "red", "border-width":"1px", "border-style":"solid"});
                    input.parent().prepend('<div class="password-comparation email_exist"><aside id="pass-info" class="stillweakpass"><center><?= $extras['user_already_exist']; ?></center></aside></div>');

                } else {
                    
                    $('.email_exist').hide();
                    input.css({"border-color":"green"});
                    $('.new_create1').removeAttr('disabled');

                }
              
          });

});

/* scritp fuerza contraseña */
$(document).ready(function() {
    var password1       = $('#password'); //id of first password field
    var password2       = $('#password-confirm'); //id of second password field
    var passwordsInfo   = $('#pass-info'); //id of indicator element
   
    passwordStrengthCheck(password1,password2,passwordsInfo); //call password check function
   
});

function passwordStrengthCheck(password1, password2, passwordsInfo)
{
    //Must contain 5 characters or more
    var WeakPass = /(?=.{5,}).*/;
    //Must contain lower case letters and at least one digit.
    var MediumPass = /^(?=\S*?[a-z])(?=\S*?[0-9])\S{5,}$/;
    //Must contain at least one upper case letter, one lower case letter and one digit.
    var StrongPass = /^(?=\S*?[A-Z])(?=\S*?[a-z])(?=\S*?[0-9])\S{5,}$/;
    //Must contain at least one upper case letter, one lower case letter and one digit.
    var VryStrongPass = /^(?=\S*?[A-Z])(?=\S*?[a-z])(?=\S*?[0-9])(?=\S*?[^\w\*])\S{5,}$/;
   
    $(password1).on('keyup', function(e) {
        if(VryStrongPass.test(password1.val()))
        {
            passwordsInfo.removeClass().addClass('vrystrongpass compare').html("<?php echo $extras['password_stronger']; ?>");
        }  
        else if(StrongPass.test(password1.val()))
        {
            passwordsInfo.removeClass().addClass('strongpass compare').html("<?php echo $extras['password_strong']; ?>");
        }  
        else if(MediumPass.test(password1.val()))
        {
            passwordsInfo.removeClass().addClass('goodpass compare').html("<?php echo $extras['password_good']; ?>");
        }
        else if(WeakPass.test(password1.val()))
        {
            passwordsInfo.removeClass().addClass('stillweakpass compare').html("<?php echo $extras['password_weak']; ?>");
        }
        else
        {
            passwordsInfo.removeClass().addClass('weakpass compare').html("<?php echo $extras['password_weaker']; ?>");
        }
    });
   
    $(password2).on('keyup', function(e) {
       
        if(password1.val() !== password2.val())
        {
            passwordsInfo.removeClass().addClass('weakpass compare').html("<?php echo $extras['password_dont_match']; ?>");  
        }else{
            passwordsInfo.removeClass().addClass('goodpass compare').html("<?php echo $extras['password_match']; ?>"); 
        }
           
    });
}
</script>