 
<?php # $extras['item']; variable de textos extra, $controllerText['item']; variable de texto del controlador. ?>

<!-- seccion principal -->
    <section class="content content-table">     
			
			  <section class="table content-table">




				      	<!-- categorias -->
				            <section class="table-cell right-content">     
				                  <table id="table-edit" class="table-edit_body" cellpadding="0" cellspacing="0">
				                      <tr>
				                            <td class="no-padding table-edit_body_fields border-none">  
				                                
				                                <h2 class="fondo2 color5"><?= __($extras['offer_info']); ?> <?= __d('Administrator', 'Disponible para'); ?>: <?= $extras[$offer->type]; ?></h2>

				                                <div class="categories-checkbox fondo5" style="max-height: inherit;">
				                                    <table id="table-edit" class="table-index" cellpadding="0" cellspacing="0" align="left">
														
														<?php $datos = ['id' => $offer->id, 'name' => $this->Get->get_user_name($offer->user_id), 'company_name' => $this->Get->get_company_name($offer->user_id), 'crane_author' => $offer->author_id, 
																		'avalible' => $offer->type, 'value' => $offer->value, 'offer_date' => $offer->created, 'status' => $offer->status,
																		'city' => $offer->city, 'country' => $offer->country,
																	   ]; 
														foreach($datos as $label => $dato) { 
																if(!empty($dato)) { ?>														
					                                    <tr>
				                                          <td style="text-align: left;">
				                                              <span><b><?= $extras[$label]; ?>:</b> <?= $dato; ?></span>
				                                          </td>
				                                        </tr>
				                                        <?php } } ?>

				                                    </table>
				                                </div>

				                            </td>
				                      </tr>
				                  </table>
				            </section>
				        <!-- fin categorias -->

		      </section>


	</section>
