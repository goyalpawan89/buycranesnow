<div class="reg1_2">
    <div class="container">
      <div class="row">
        <div class="col-md-6 col-md-offset-3">
          <div class="panel panel-login-1">
            <!--<div class="panel-heading">
              <div class="row">
                <div class="col-xs-6"> <a href="#" class="active" id="login-form-link">Login</a> </div>
                <div class="col-xs-6"> <a href="#" id="register-form-link">Register</a> </div>
              </div>
              <hr>
            </div>-->
            <div class="panel-body ">
              <div class="row">
                <div class="col-lg-12">
                  <div class="register">
                    <h1 style="text-align:center;">Login </h1>
                  </div>
                </div>
                <div class="col-lg-12">
					<?php echo $this->Form->create('Users', ['url' => ['controller' => 'Users', 'action' => 'login'], 'class' => 'login-form']); ?>
                  <div class="form-group login_bg">
				  	<?php echo $this->Form->input('email', array('label' => false, 'class' => 'form-control','placeholder' => $extras['email'], 'type' => 'email', 'required' => true)); ?>
                  </div>
                  <div class="form-group login_bg">
				  	<?php echo $this->Form->input('password', array('label' => false, 'class' => 'form-control','placeholder' => $extras['password'], 'type' => 'password', 'required' => true)); ?>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-group text-left">
                    <input type="checkbox" tabindex="3" class="" name="remember" id="remember">
                    <label for="remember"> Remember Me</label>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-group text-right">
                    <div class="row">
                      <div class="col-lg-12">
                        <div class="text-right"> <a href="" class="newuser">New User?</a> | <a href="" class="">Reset Password?</a> </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-lg-12">
                  <div class="form-group text-left" style="margin:0px;">
                    <div class="row">
                      <div class="col-sm-3">
					  	 <?php echo $this->Form->submit('Log In', array('class' => 'form-control btn btn-primary search-color','id'=>"login-submit", 'name'=>'login')); ?>
                      </div>
                    </div>
                  </div>
                </div>
				<?php echo $this->Form->end();  ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
   <?php /*$inputs = ['email' => ['label' => false, 'placeholder' => $extras['email'], 'type' => 'email', 'required' => true],
                                         'password' => ['label' => false, 'placeholder' => $extras['password'], 'type' => 'password', 'required' => true],
                                         $extras['login'] => ['label' => false, 'type' => 'submit', 'class' => 'btn btn-link fondo1 fondoh2 color0', 'name' => 'login'],
                                        ]; 

                           

                                  foreach ($inputs as $name => $options) {
                                          echo $this->Form->input($name, $options);
                                  }*/

                          

                        ?>