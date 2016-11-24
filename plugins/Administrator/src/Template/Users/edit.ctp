<?php echo $this->Form->create($user, array( 'id'=>'upload', 'enctype' => 'multipart/form-data')); ?>

<!-- formulario de datos -->
<section class="complete">

	<?php foreach ($tablesData as $key => $datos) { ?>

	    <section class="content-table half">     
	    	<section class="section fondo5">

	    		<!-- tabla de usuarios -->
				<table class="table-index" cellpadding="0" cellspacing="0">
					<tr class="fondo2 color5">						
						<th><?php echo $extras[$key] ?></th>
					</tr>
					
					<?php foreach ($datos as $name => $options) { ?>
					<tr>
						<td><?php echo $this->Form->input($name, $options); ?></td>
					</tr>
					<?php } ?>
				</table>
		
	    		<!-- fin tabla de usuarios -->

	    	</section>
            <?php if($key == 'general_data') { ?><div class="password-comparation"><div id="pass-info"></div></div><?php } ?>

	    </section>
    <?php } ?>
    
</section>
<!-- fin formulario de datos -->


<!-- información del usuario -->
    <section class="content-table">     
    	<section class="up-section btn-section section fondo5">

    		<div class="table">
                    <div class="table-cell">
							<?php echo $this->Form->button($extras['move_trash'], ['id'=>'button', 'class' => 'btn fondo1 color5 fondoh3 index-index',  
																	  			   'formaction' => $this->Url->build(["controller" => $this->request->params['controller'], "action" => 'clear/'.$user->id ]) ]); ?>
							
							<?= $this->Form->button(__($controllerText['submit']), ['name' => $extras['update'], 'id'=>'button', 'class' => 'btn fondo2 color5 fondoh3 index-'.$this->request->params['action'],]); ?>
                    </div>

                    <div class="table-cell">
	                    <p><?php echo $controllerText['empty_passwords']; ?></p>
                    </div>

            </div>
        </section>
    </section>

<?php echo $this->Form->end(); ?>


<!-- script cantidad de publicaciones y paginas -->
<script type="text/javascript">
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