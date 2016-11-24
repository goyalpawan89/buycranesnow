              <!-- ocultar buscador desde el menu para que no quede sobre la barra en el responsive -->
              <?php /*<aside clasS="hidde_search"><?php echo $this->element('Front.buscador');?></aside>             */ ?>
              <!--end ocultar buscador desde el menu para que no quede sobre la barra en el responsive -->

              <aside class="up-menu">
                <div class="wrap_menu">
                  
                  <!-- buscador heaer -->
                  <?php $datos = ['s' => ['label' => false, 'placeholder' => __($extras['wrhite_your_search']), 'required' => true], 
                                  __($extras['search']) => ['id' => 'Buscar', 'label' => false, 'type' => 'submit', 'class' => 'submit fondoh1 colorh3', 'value' => __($extras['search_submit']) ], 
                                   ]; ?>

                          <?= $this->Form->create('search', ['url' => $this->Get->get_url_translate_simple_search(), 'type' => 'get', 'id' => 'search_header']); ?>
                              <?php foreach ($datos as $name => $options) { ?>
                                    <?php echo $this->Form->input($name, $options); ?>
                              <?php } ?>
                  <?php echo $this->Form->end(); ?>
                  <!-- fin buscador heaer -->


                  <?php if (!$authUser) { 

                   echo $this->Html->link(__($extras['register']), '#register_company', ['class' => 'fancybox btn btn-link fondo1 fondoh3 color3 colorh0']);  
                   echo $this->Html->link(__($extras['login']), '#login', ['class' => 'fancybox btn btn-link fondo1 fondoh3 color3 colorh0']); 
                   
                   } else { 
                  
                   $loginName = $authUser['name'];
                   echo $this->Html->link(__d('front', $extras['control_panel']), $this->Get->get_url_translate('Users', 'profile'), ['class' => 'btn btn-link fondo1 fondoh3 color3 colorh0']); 
                   
                   //si no hay solicitudes activas no mostrar
                   if($this->Get->get_offers_count($authUser["id"]) != 0) {
                      echo '<span class="notification_offert">'.$this->Get->get_offers_count($authUser["id"]).'</span>'; //notificaciones de gruas
                   }
                   
                   if(isset($authUser['role_id']) && $authUser['role_id'] <= 2) {
                    echo $this->Html->link(__($extras['see_site']), $this->Get->get_url_translate('users', 'site'), ['class' => 'btn btn-link fondo1 fondoh3 color3 colorh0']); 
                   }
                   echo $this->Html->link(__($extras['logout']), $this->Get->get_url_translate('users', 'logout'), ['class' => 'btn btn-link fondo1 fondoh3 color3 colorh0']); 

                  } 

                  ?>
                  <aside class="all_flags border1">
                      <?php foreach ($languages as $name => $flag) {
                                if(!isset($this->request->params['language']) && $name != 'en') { // es como idioma por defecto.
                                        
                                        echo $this->Html->link($this->Html->image("flags/4x3/".$flag.".svg", 
                                                                                  ["alt" => $name]), $this->Get->get_language_link($name), 
                                                                                  ['plugin' => false, 'escape' => false, 'class' => 'flags']); 
                                } else {
                                  if(isset($this->request->params['language']) && $this->request->params['language'] != $name) {

                                        echo $this->Html->link($this->Html->image("flags/4x3/".$flag.".svg", 
                                                                                  ["alt" => $name]), $this->Get->get_language_link($name), 
                                                                                  ['plugin' => false, 'escape' => false, 'class' => 'flags']); 
                                  }
                                }
                            }
                      ?>

                  </aside>

                </div>
              </aside>


              <input id="mobile_menu" type="checkbox">
              <ul class="nav">
                    
                    <li><a class="principal-main color3" href="#"><i class="icon-home icon-large"></i></a></li>
                    
                    <?php if(isset($info['frontend_main_home']) && !empty($info['frontend_main_home'])) { ?>
                    <!--- Regular Menu Button -->  
                     <li><a class="principal-main color3" href="<?= $this->Url->build('/', true); ?>"> <?= __($info['frontend_main_home']); ?></a></li>
                    <!--- Regular Menu Button Ends--> 
                    <?php } ?>


                    <?php $l=1; foreach ($menu as $key => $item) { ?>
          
                      <!-- Regular Menu Button -->  
                          <li class="item-menu item-<?= $item['id']; ?><?php if(!empty($item['children'])) { echo ' dropdown '; }?>">

                            <a class="principal-main color3" href="<?= $this->Get->get_link($item['id'], $item['type']); ?>"> <?= __($this->Get->get_name($item['id'], $item['type'])); ?></a>
                            
                            <?php if($item['id'] == 15 || isset($item['children']) && !empty($item['children'])) { ?>
                                <div class="fulldrop"> 
                                      <div class="wrap">
                                            <div class="column">
                                                <aside class="mapa">
                                                <?php $a = 1; $continentes = ['América' => __($extras['america']), 'Europa' => __($extras['europe']), 'Asia' => __($extras['asia']), 'Oceania' => __($extras['oceania']), 'África' => __($extras['africa'])];
                                                foreach ($continentes as $name => $continentName) { 
                                                    echo $this->Html->link('<i id="'.$name.'" class="fa fa-map-marker tooltip color1" title="'.__($continentName).'"></i>', $this->Get->get_url_translate('Posts', 'find', $name), ['escape' => false, 'class' => 'continent-'.$a.' color1']); 
                                                $a++; } ?>
                                                </aside>
                                            </div>
                                            <div class="column">
                                                <?php if($item['id']==15) { ?>

                                                        <h3 class="color1"><?= __($extras['industry_type_label']); ?></h3> 
                                                        <ul>
                                                          <?php foreach ($tiposUsuario as $name => $userType) {

                                                              $action = 'index?company='. $name; ?>

                                                              <li><?= $this->Form->postLink(__($userType), $this->Get->get_url_translate('Users', $action), ['escape' => false, 'title' => '', 'class' => 'colorh1 color0'] ); ?>

                                                          <?php } ?>
                                                        </ul>

                                                    <?php } else { ?>
                                                        <h3><?php //__($extras['sub_items']); ?></h3>
                                                        <ul>
                                                          <?php foreach ($item['children'] as $sub) { ?>
                                                              <li><a class="colorh1 color0" href="<?= $this->Get->get_link($sub['id'], $sub['type']); ?>?avalible=sell"> <?= __($this->Get->get_name($sub['id'], $sub['type'])); ?></a>
                                                          <?php } ?>
                                                        </ul>
                                                <?php } ?>
                                            </div>
                                      </div>
                                </div>
                            <?php } ?>

                          </li>
                      <!-- Regular Menu Button Ends --> 


                    <?php $l++; } ?>

                             
            </ul> 


