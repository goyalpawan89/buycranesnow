<?php 
	// camops personalizados del post
	
	if(!empty($user->archive_id)) { $logo = $this->Image->url($user->archive_id, 'full'); } else { $logo = $this->Url->build('/', true).$logo; } // logo de solo gruas si no hay imagen o logo del usuario (empresa) ?>


<!-- contenido principal -->
<section class="content background">
	<div class="wrap wrap-user_profile">
			
			<!-- publicidad superuir -->
			<?= $this->element('Front.publicity_up'); ?>

			<!-- descripcion superior -->
			<article class="category-description description">
				<table class="post-user_description">
					<tr> 
						<td>
							<aside class='post-user_img'><?php //echo $this->Html->image($logo, ['alt' => $blogName]);; ?>
								<?= $this->element('Front.upload_files'); ?>
							</aside>
							
							<div class="post-user_text">
								<span class="post-user_text_title"><?= $name; ?></span>
																
								<div>
									<p>
									<?php if(!empty($address) || !empty($city)) { ?><span class="post-user_text_dir"><?= $address; ?> <?= $city; ?></span> <?php } ?>
									<?php //$this->Html->link(__($extras['see_map']), '#mapa', ['class' => 'show-map post-user_text_dir color2 colorh3']); ?>
									</p>
									<p><b><?= $extras['email']; ?></b> <?= $email; ?></p>
									<p><b><?= $extras['user_account_type']; ?></b> <?= $user->type; ?></p>
								</div>
							</div>
						</td>
						<td>
							
							<div class="post-user_contact">
							<?= $this->Form->create($user, array( 'id'=>'profile', 'class' => 'general_form', 'enctype' => 'multipart/form-data')); ?>
								
								<li class="post-user_contact_list">
									<?= $this->Html->link(__($extras['my_favorites']), ['controller' => 'Posts', 'action' => 'my_favorites'], ['class' => 'post-user_contact_list_item before-list_item favorite color3 colorh1 fondoh3']); ?>
								</li>
								<li class="post-user_contact_list">
									<?php if($user->role_id <= $empresa_id) { 
										
											echo $this->Html->link(__($extras['see_site']), ['controller' => 'Users', 'action' => 'site'], ['class' => 'post-user_contact_list_item before-list_item see_site color3 colorh1 fondoh3']); 
										  
										  } else { 

										  	echo $this->Form->input('type', ['value' => 'business', 'type' => 'hidden']);
										  	echo $this->Form->button(__($extras['update_bussines_user']), ['label' => false, 'name' => 'role_id', 'value' => 2, 'type' => 'submit', 'class' => 'post-user_contact_list_item before-list_item change-btn fondo3 color1 colorh2 fondoh1']); 

										  } ?>
								</li>

								<?php if($user->role_id <= $empresa_id) { ?>
								<li class="post-user_contact_list">
									<?= $this->Html->link(__($extras['post_crane']), '/admin/posts/add', [ 'class' => 'post-user_contact_list_item before-list_item post_crane color3 colorh1 fondoh3', 'target' => '_blank']); ?>
								</li>
								<?php } ?>
								
								<li class="post-user_contact_list">
									<?= $this->Html->link(__($extras['my_offers']), ['controller' => 'Users', 'action' => 'my_offers'], ['class' => 'btn btn-sell my_offers fondo1 fondoh3 color3 colorh0']); ?>
								</li>

							<?= $this->Form->end(); ?>
							</div>

						</td>
					</tr>					
				</table>
			</article>
			<!-- fin descripcion superior -->
			
			<?php if(isset($authUser) &&  isset($authUser['type']) && $authUser['type'] == 'Basic') { ?>
				
				<!-- formulario de datos -->
				<h1 class="fondo1 color2 content-side_description_title"><?= __($extras['paypal_pay']); ?></h1>
				
				<article class="category-description description post-user_description">
					
					<p><?= $info['get_premium_now']; ?></p>
					<p><br><?= $this->Html->Link($extras['change_premium'], $this->Get->get_link(89, 'Pages'), ['class' => 'btn-link btn fondo1 fondoh3 color2 colorh0']); ?></p>

				</article>

			<?php } ?>



			<!-- formulario de datos -->
			<h1 class="fondo1 color2 content-side_description_title"><?= __($extras['general_data']); ?></h1>

			<article class="category-description description post-user_description">
			
			<?= $this->Form->create($user, array( 'id'=>'personal_data', 'class' => 'formulario formulario_profile', 'enctype' => 'multipart/form-data')); 

								  $datos = ['name'=>['label'=> $extras['name'], 'option'=>''], 
								   		    'last_name'=>['label'=> $extras['last_name'], 'option'=>''],
								   			//'identification'=>['label'=> $extras['identification'], 'requred' => false], 
								   			'email'=> ['label' => $controllerText['email'], 'type'=>'email', 'required'], 
								   			//'country'=>['label'=>  $extras['country']],
								   			//'city'=>['label'=>  $extras['city']],
								   			//'state'=>['label'=>  $extras['state']],
								   			//'zip_code'=>['label'=>  $extras['zip_code']],
								   			//'tel'=>['label'=>  $extras['phone'], 'type' => 'tel', 'class' => 'indicative_tel'],
								   			'cel'=>['label'=>  $extras['celphone'], 'type' => 'tel', 'class' => 'indicative_cel'],
								   			 __($extras['update']) =>['label'=>  false, 'type' => 'submit', 'class' => 'btn btn-sell fondo1 fondoh3 color3 colorh0', 'name' => 'update'],
							  		   ];

						foreach ($datos as $name => $options) { 
							echo $this->Form->input($name, $options); 
					} 

					?>

					<script type="text/javascript">                        
                        $('<?= $this->Form->input('code_cel', ['label' => false, 'value' => $codes['code_cel'], 'class' => 'code_phone input-contact', 'div' => false, 'type' => 'select', 'options' => $codigosTelefono,  'requred' => 'requred']); ?>').insertBefore(".indicative_cel");
                        $('<?= $this->Form->input('area_cel', ['label' => false, 'value' => $codes['area_cel'], 'class' => 'input-contact area_phone', 'placeholder' => __($extras["area_cel"]), 'div' => false, 'requred' => 'requred']); ?>').insertBefore(".indicative_cel");
					</script>

			<?= $this->Form->end(); ?>


			</article>
			<!-- fin formulario de datos -->
			
			<?php if($user->role_id <= $empresa_id) { ?>
			<!-- formulario de datos -->
				<h1 class="fondo1 color2 content-side_description_title"><?= __($extras['company_profile']); ?></h1>
				<article class="category-description description post-user_description">
				
				<?= $this->Form->create($user, array( 'id'=>'company_data', 'class' => 'formulario formulario_profile formulario_empresa', 'enctype' => 'multipart/form-data')); 

					if(isset($user->company_city_id) && !empty($user->company_city_id)) { $opcionCiudad = [$user->company_city_id => $this->Get->get_city_by_id($user->company_city_id)]; } else { $opcionCiudad = NULL; }

									$datos = ['company_name'=>['label'=> $extras['name'], 'option'=>''], 
									   		  'company_position'=>['label'=>  $extras['company_position']],									  
									   		  //'company_identification'=>['label'=> $extras['identification'], 'option'=>''], 
									   		  'company_email'=> ['label' => $extras['email'], 'type'=>'email', 'required'], 
									   		  'company_tel'=>['label'=>  $extras['phone'], 'type' => 'tel', 'class' => 'indicative_tel_company', 'required' => 'required'],
									   		  'company_country'=>['label'=>  $extras['country'], 'required' => 'required', 'class' => 'country', 'type' => 'select', 'empty' => $company_country,  ],
									   		  'company_state'=>['label'=>  $extras['state'], 'required' => 'required', 'class' => 'state', 'type' => 'select', 'empty' => $company_state],
									   		  'company_city'=>['label'=>  $extras['city'], 'required' => 'required', 'class' => 'city', 'type' => 'select', 'empty' => $company_city],
									   		  'company_address'=>['label'=>  $extras['address']],
								   			  'company_zip_code'=>['label'=>  $extras['zip_code'], 'required' => 'required'],
								   			  //'equipment_type'=>['label'=>  $extras['equipment_type'], 'type' => 'select', 'options' => $equipmentType, 'empty' => $extras['select_default'], 'required' => 'required'],
								   			  'equipment_buy_status'=>['label'=>  $extras['equipment_buy_status'], 'type' => 'select', 'options' => $equipmentStatus, 'empty' => $extras['select_default'], 'required' => 'required'],
								   			  'industry_type'=>['label'=>  $extras['industry_type'], 'type' => 'select', 'options' => $industryType, 'empty' => $extras['select_default'], 'required' => 'required'],
								  		    ];

								  	$datos1 = ['description' => ['label' => __($extras['user_description']), 'class' => 'input-contact textarea', 'type' => 'textarea', 'requred' => 'requred'], 									   			
									   		   __($extras['company_update']) =>['label'=>  false, 'type' => 'submit', 'class' => 'btn btn-sell fondo1 fondoh3 color3 colorh0', 'name' => 'company_update'],
								  		    ];

							foreach ($datos as $name => $options) { 
								echo $this->Form->input($name, $options); 
							} ?>

							<aside class="checkboxes">
							<label class="checkboxes_label"><?= __($extras['equipment_type']); ?></label>
								<?php

								$a = 0; foreach ($equipamento as $key => $name) {
								//checkear si el elemento esta seleccionado desde UsersEquipments
								$selected = array_search($key, $userEquipment);
								if($selected !== false) { $check = 'checked'; } else { $check = NULL; } 

									echo $this->Form->input('equipments.'.$a.'.id', ['label' => __d('front', $name), 'value' => $key, 'type'=> 'checkbox', 'checked' => $check]); 
									$a++; 
								}

								?>
							</aside>

							<?php
							foreach ($datos1 as $name => $options) { 
								echo $this->Form->input($name, $options); 
							} ?> 


							<script type="text/javascript">
								    // agregamos los values aquí por defecto porque no los autocompleta al agregarlos fuera de la etiqeta form
                        			$('<?= $this->Form->input('company_code_tel', ['label' => false, 'value' => $codes['company_code_tel'], 'class' => 'code_phone input-contact', 'div' => false, 'type' => 'select', 'options' => $codigosTelefono,  	'requred' => 'requred']); ?>').insertBefore("#company-tel");
                        			$('<?= $this->Form->input('company_area_tel', ['label' => false, 'value' => $codes['company_area_tel'], 'class' => 'input-contact area_phone', 'placeholder' => __($extras["area_cel"]), 'div' => false, 'requred' => 'requred']); ?>').insertBefore("#company-tel");
							</script>

				<?= $this->Form->end(); ?>


				</article>
			<!-- fin formulario de datos -->
			<?php } ?>


			<!-- formulario de datos -->
			<h1 class="fondo1 color2 content-side_description_title"><?= __($extras['update_password']); ?></h1>
			<article class="category-description description post-user_description">
			
			<?= $this->Form->create($user, array( 'id'=>'pass_data', 'class' => 'formulario', 'enctype' => 'multipart/form-data')); 

								  $datos = ['password'=>['label'=>  $extras['password'], 'autocomplete' => 'off', 'value' => ''],
								   			'password_confirm'=>['label'=>  $extras['password_confirm'], 'autocomplete' => 'off'],
								   			 __($extras['update_password']) =>['label'=>  false, 'type' => 'submit', 'class' => 'btn btn-sell fondo1 fondoh3 color3 colorh0', 'name' => 'change'],								   			
							  		   ];

						foreach ($datos as $name => $options) { 
							echo $this->Form->input($name, $options); 
					} 

			echo $this->Form->end(); ?>


			</article>
			<!-- fin formulario de datos -->

			<?php if($user->role_id <= $empresa_id) { ?>
			<!-- formulario de datos -->
				
				
				<content class="bussines_table">
						
						<!-- gruas en venta -->
						<h1 class="fondo2 color0 content-side_description_title"><?= __($extras['recived_offers']); ?> <?= __($extras['for_sell']); ?></h1>

						<?php // titulos para la venta
						$titles = ['image' => $extras['image'], 
										'name' => $extras['customer'], 
										'price' => $extras['price'], 
										'value' => $extras['offer'], 
										'counteroffer' => $extras['counteroffer'], 
										'status' => $extras['status'], 
										'send_email' => $extras['actions'], 
										]; ?>

										<article class="users_table-item">
												<table width="100%" cellspacing="0" cellpadding="0">
													<tr class="fondo1">
														<?php foreach ($titles as $key => $title) { ?>
																<th><?php echo $this->Paginator->sort($key, __($title)); ?></th>
														<?php } ?>
													</tr>													
														<?php foreach ($postsSell as $post) {												  
																  $image = $this->Image->get_thumbnail_by_id($post->post_id, 'medium');
																  $link = $this->Get->get_link($post->post_id, 'Posts');
																  $name = $this->Get->get_name($post->post_id, 'Posts');
																  $avalible = $this->Get->get_field_by_post_id($post->post_id, 'avalible');
											   				  	  $price = $this->Get->get_field_by_post_id($post->post_id, 'price');
											   				  	  $precio = $this->Number->currency($price, $info['currency']); 
											   				  	  $status = $post->status; 
											   				  	  $location = $post->country. ' - ' . $post->city; 
											   				  	  $offerDescription = $post->description; 
											   				  	  $offert = $this->Number->currency($post->value, $info['currency']); 
											   				  	  $counteroffer = $this->Number->currency($post->counteroffer, $info['currency']); 
											   				  	  $email = 'mailto:'.$this->Get->get_company_email($post->user_id);
											   				  	  $customer = $this->Get->get_company_name($post->user_id);

											   				  	   ?>

											   				  	  <tr class="<?= $status; ?>">

											   				  	  		<td><?= $this->Html->link($this->Html->image($image, ['class' => 'bussines_image tooltip']), $link, ['title' => $name, 'class' => '', 'escape' => false]); ?></td>
																		<td><?= $this->Html->link($customer, $email, ['class' => 'color2 colorh3 tooltip', 'title' => $offerDescription. ' | '. __($extras['location']). ' '.$location]); ?></td>
																		<td><?php if(!empty($precio)) { echo $precio; } ?></td>
																		<td><?php if(!empty($post->value)) { echo $offert; } ?></td>
																		<td>

																		<?=  $this->Form->create($user, ['id'=> 'form_offert_input', 'class' => 'form_offert_input', 'enctype' => 'multipart/form-data']);
																				echo $this->Form->input('counteroffer1', ['placeholder' => $counteroffer, 'class' => 'input_ofert tooltip', 'title' => __($extras['click_to_offer']), 'label' => false, 'required' => 'required']);
																				echo $this->Form->input('counteroffer', ['type' => 'hidden']);
																				echo $this->Form->input('post_id', ['type' =>'hidden', 'value' => $post->post_id]);
																				echo $this->Form->input('sell_rent_id', ['type' =>'hidden', 'value' => $post->id]);
																				echo $this->Form->end(); ?>

																		</td>
																		<td><?= __($extras[$status]); ?></td>
																		
																		<td>
																			<span><?= $this->Html->link('', ['controller' => 'Users', 'action' => 'deny', $post->id], 
																											['title' => $extras['deny_offer'], 'class' => 'tooltip btn-offer deny_offer colorh3 color1 fondoh1 fondo3']); ?></span>
																			<span><?= $this->Html->link('', ['controller' => 'Users', 'action' => 'accept', $post->id], 
																											['title' => $extras['accept_offer'], 'class' => 'tooltip btn-offer accept_offer colorh3 color1 fondoh1 fondo3']);?></span>
																			<span><?= $this->Html->link('', ['controller' => 'Users', 'action' => 'pending', $post->id], 
																											['title' => $extras['pending_offer'], 'class' => 'tooltip btn-offer pending_offer colorh3 color1 fondoh1 fondo3']); ?></span>
																		</td>

											   				  	  </tr>

											   			<?php } ?>

												</table>
									    </article>
							
						<!-- gruas en alquiler -->
						<h1 class="fondo2 color0 content-side_description_title"><?= __($extras['recived_offers']); ?> <?= __($extras['for_rent']); ?></h1>

						<?php // titulos para la venta
							 $titles = ['image' => $extras['image'], 
										 'name' => $extras['customer'], 
										 'price' => $extras['price'], 
										 'date_start' => $extras['since'], 
										 'date_end' => $extras['until'], 
										 'status' => $extras['status'], 
										 'send_email' => $extras['actions'], 
										]; ?>


										<article class="users_table-item">
												<table width="100%" cellspacing="0" cellpadding="0">
													<tr class="fondo1">
														<?php foreach ($titles as $key => $title) { ?>
																<th><?php echo $this->Paginator->sort($key, __($title)); ?></th>
														<?php } ?>
													</tr>

													<?php foreach ($postsRent as $post) {												  
																  $image = $this->Image->get_thumbnail_by_id($post->post_id, 'medium');
																  $link = $this->Get->get_link($post->post_id, 'Posts');
																  $name = $this->Get->get_name($post->post_id, 'Posts');
																  $avalible = $this->Get->get_field_by_post_id($post->post_id, 'avalible');
											   				  	  $price = $this->Get->get_field_by_post_id($post->post_id, 'price');
											   				  	  $precio = $this->Number->currency($price, $info['currency']); 
											   				  	  $status = $post->status; 
											   				  	  $since = $post->date_start; 
											   				  	  $until = $post->date_end; 
											   				  	  $email = 'mailto:'.$this->Get->get_company_email($post->user_id);
											   				  	  $customer = $this->Get->get_company_name($post->user_id); ?>

											   				  	  <tr class="<?= $status; ?>">

											   				  	  		<td><?= $this->Html->link($this->Html->image($image, ['class' => 'bussines_image']), $link, ['title' => $name, 'class' => '', 'escape' => false]); ?></td>
																		<td><?= $this->Html->link($customer, $email, ['class' => 'color2 colorh3']); ?></td>
																		<td><?php if(!empty($precio)) { echo $precio; } ?></td>
																		<td><?php if(!empty($since)) { echo $since; } ?></td>
																		<td><?php if(!empty($until)) { echo $until; } ?></td>
																		<td><?= __($extras[$status]); ?></td>
																		
																		<td>
																			<span><?= $this->Html->link('', ['controller' => 'Users', 'action' => 'deny', $post->id], 
																											['title' => $extras['deny_offer'], 'class' => 'tooltip btn-offer deny_offer colorh3 color1 fondoh1 fondo3']); ?></span>
																			<span><?= $this->Html->link('', ['controller' => 'Users', 'action' => 'accept', $post->id], 
																											['title' => $extras['accept_offer'], 'class' => 'tooltip btn-offer accept_offer colorh3 color1 fondoh1 fondo3']);?></span>
																			<span><?= $this->Html->link('', ['controller' => 'Users', 'action' => 'pending', $post->id], 
																											['title' => $extras['pending_offer'], 'class' => 'tooltip btn-offer pending_offer colorh3 color1 fondoh1 fondo3']); ?></span>
																		</td>

											   				  	  </tr>

											   	<?php } ?>

												</table>
									    </article>

				</content>

			<?php } // si no es un usuario empresarial no debe mostrar esto ?>

			
	
	</div>
</section>


<?php 
       //funciones de editor visual
       echo $this->Html->css('Administrator.visual_editor/redactor'); // editor visual.
       echo $this->Html->script(['Administrator.visual_editor/combined.min', 'Administrator.visual_editor/redactor', 'Administrator.visual_editor/table', 
       							 'Administrator.visual_editor/video', 'Administrator.visual_editor/imagemanager', 'Administrator.visual_editor/filemanager']); // el ultimo para español seria 'Administrator.visual_editor/es'
        

?>



<?php 	echo $this->Html->css('Administrator.upload_files/uploadfile'); // upload images.
        echo $this->Html->script(['Administrator.upload_files/jquery.uploadfile.min']); // upload images ?>
        
        <script>
        $(document).ready(function() {     
			    //subir el logo del cliente
			    $("#fileuploader").uploadFile({
			              url:"<?php echo $this->Url->build('/', true);?>admin/config/upload",
			              multiple: false,
			              fileName:"upload",
			              returnType:"json",
			              uploadStr: "<?php echo $imagesText['button_profile']; ?>",
			              dragDropStr: "",            
			              formData: { user_id: <?php echo $id; ?> },

			              onSuccess:function(files,data,xhr,pd)
			              {
			                //datos = JSON.parse(data);
			                
			                //Generación de numeros de acuerdo a campos creados
			                numero=$('.ppp').length;
			               // console.log(numero);
			                $( "#eventsmessage" ).append( "<input type='hidden' class='ppp' name='archives[0-"+ numero +"][id]' value='"+data.File.result+"'>" );
			              },
              	});


        		// ofertas con values en usd
			    $('#counteroffer1').change( function() {

			          var val = $(this).val();
			          
			          if(!$.isNumeric(val)) {

			              alert('<?= $extras["write_valid_value"]; ?>');
			              $(this).val('');
			          
			          } else {

			                    $(this).val('<?= $info["currency"]; ?> $ ' + number_format(val));
			                    $('#counteroffer').attr('value', val);

			          }

			    });


        });


        //script para el editor visual debe ir de ultimo
        $(function()
        {
          $('textarea#description').redactor({
            lang: 'en',
            buttonSource: true,
          });
        });
</script>