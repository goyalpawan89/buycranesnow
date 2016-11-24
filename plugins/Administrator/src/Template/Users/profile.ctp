<?= $this->Form->create($user, array( 'id'=>'upload', 'enctype' => 'multipart/form-data')); ?>

<?php if($this->request->params['action'] != 'add') { ?>
<!-- información del usuario -->
    <section class="content-table">     
    	<section class="up-section section fondo5">

    		<div class="table table-profile_up">
                    <div class="table-cell">
                    	<?= $this->Html->image('http://0.gravatar.com/avatar/ad516503a11cd5ca435acc9bb6523536?s=150', ['alt' => 'Avatar', 'class' => 'avatar']); ?>
                    </div>

                    <div class="table-cell">
                   		<aside class="profile-data">
                    		<h2><?= $user->name. " " . $user->last_name; ?></h2>
                    		<p><?= __($controllerText['user_type']); ?>: <?= $user->role->name; ?></p>

                    		<span class="total_publications stat-count color3"><?= number_format($publicationsTotal); ?></span>
                    		<p><?= __($extras['total_publications']); ?></p>

                    	</aside>
                    </div>

                    <div class="border-left table-bars table-cell">
                    	<?php foreach($totalPosts as $type => $total) { ?>
                    	   <span><?= $total['name']; ?>: <?= $total['total']; ?></span>
                    	   <div id="bar-<?= $type; ?>" class="fondogris"></div>
                    	<?php } ?>
                    </div>

                    <div class="table-cell">
                    	<?php //$this->Form->button(__($controllerText['submit']), ['name' => $extras['update'], 'id'=>'button', 'class' => 'btn fondo2 color5 fondoh3 index-'.$this->request->params['action'],]); ?>
                    </div>
            </div>

    	</section>
    </section>
<!-- fin información del usuario -->
<?php } ?>

<!-- formulario de datos -->
<section class="complete">

	<?php foreach ($tablesData as $key => $datos) { ?>

	    <section class="content-table half">     
	    	<section class="section fondo5">

	    		<!-- tabla de usuarios -->
				<table class="table-index" cellpadding="0" cellspacing="0">
					<tr class="fondo2 color5">						
						<th><?= $extras[$key] ?></th>
					</tr>
					
					<?php foreach ($datos as $name => $options) { ?>
					<tr>
						<td><?= $this->Form->input($name, $options); ?></td>
					</tr>
					<?php } ?>
				</table>

				
	    		<!-- fin tabla de usuarios -->

	    	</section>
	    </section>
    <?php } ?>
    
</section>

<div class="password-comparation"><div id="pass-info"></div></div>
<!-- fin formulario de datos -->


<!-- información del usuario -->
    <section class="content-table">     
    	<section class="up-section btn-section section fondo5">

    		<div class="table">
                    <div class="table-cell">
							<?= $this->Form->button($extras['move_trash'], ['id'=>'button', 'class' => 'btn fondo1 color5 fondoh3 index-index',  
																	  			   'formaction' => $this->Url->build(["controller" => $this->request->params['controller'], "action" => 'clear/'.$user->id ]) ]); ?>
							
							<?= $this->Form->button(__($controllerText['submit']), ['name' => $extras['update'], 'id'=>'button', 'class' => 'btn fondo2 color5 fondoh3 index-'.$this->request->params['action'],]); ?>
                    </div>

                    <div class="table-cell">
	                    <p><?= $controllerText['empty_passwords']; ?></p>
                    </div>

            </div>
        </section>
    </section>

<?= $this->Form->end(); ?>


<?= $this->Html->script('Administrator.locations');  // paises y ciudades y estados. ?>


<!-- script cantidad de publicaciones y paginas -->
<script type="text/javascript">
	$(document).ready(function ($) {
		// progress bar (JqueryUI)
	    <?php // variable $totalPost y $publicationsTotal llamados desde el controlador $type = publication, page
	    foreach($totalPosts as $type => $total) { ?>
	    $(function() {
	        $( "#bar-<?= $type; ?>" ).progressbar({
	            value: <?= $total['total']; ?>
	        });
	    });

	    <?php } ?>
	});

    /* scritp fuerza contraseña */
    $(document).ready(function() {
        var password1       = $('#password'); //id of first password field
        var password2       = $('#password-confirm'); //id of second password field
        var passwordsInfo   = $('#pass-info'); //id of indicator element
       
        passwordStrengthCheck(password1,password2,passwordsInfo); //call password check function
       
    });

    function passwordStrengthCheck(password1, password2, passwordsInfo) {
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
                passwordsInfo.removeClass().addClass('vrystrongpass compare').html("<?= $extras['password_stronger']; ?>");
            }  
            else if(StrongPass.test(password1.val()))
            {
                passwordsInfo.removeClass().addClass('strongpass compare').html("<?= $extras['password_strong']; ?>");
            }  
            else if(MediumPass.test(password1.val()))
            {
                passwordsInfo.removeClass().addClass('goodpass compare').html("<?= $extras['password_good']; ?>");
            }
            else if(WeakPass.test(password1.val()))
            {
                passwordsInfo.removeClass().addClass('stillweakpass compare').html("<?= $extras['password_weak']; ?>");
            }
            else
            {
                passwordsInfo.removeClass().addClass('weakpass compare').html("<?= $extras['password_weaker']; ?>");
            }
        });
       
        $(password2).on('keyup', function(e) {
           
            if(password1.val() !== password2.val())
            {
                passwordsInfo.removeClass().addClass('weakpass compare').html("<?= $extras['password_dont_match']; ?>");  
            }else{
                passwordsInfo.removeClass().addClass('goodpass compare').html("<?= $extras['password_match']; ?>"); 
            }
               
        });
    }
</script>