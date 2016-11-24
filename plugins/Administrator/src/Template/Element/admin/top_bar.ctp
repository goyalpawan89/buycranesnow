<hr class="linea fondo3">

<!--top bar principal -->
		<nav class="top-bar principal-bar">	
			<ul id="menu_left_bar">
				<li><a href="<?php echo $this->Url->build('/', true); ?>" target="_blank" class="main color5 home"><?php echo __d('administrator', $blogName); ?></a></li>
				<li><a class="main color5 language"><?= __d('administrator', $extras['actual_language']); ?>: <?= $extras[$language_default]; ?></a></li>
			</ul>
			<ul id="menu_bar">	
					
					
	                 <?php foreach ($languages as $name => $flag) {
	                            if(!isset($this->request->params['language']) && $name != $language_default) { // Idioma por default
	                                    
	                                    echo '<li>'.$this->Html->link($name, $this->Get->get_language_link($name), 
	                                                                              ['plugin' => false, 'escape' => false, 'class' => 'main color1 tooltip flag', 'title' => __d('administrator', "Idioma ".$name)]).'</li>'; 
	                            } else {
	                              if(isset($this->request->params['language']) && $this->request->params['language'] != $language_default) {
	                              		
	                                    echo '<li>'.$this->Html->link($language_default, $this->Get->get_language_link($language_default), 
	                                                                              ['plugin' => false, 'escape' => false, 'class' => 'main color1 tooltip flag', 'title' => __d('administrator', "Idioma ".$language_default)]).'</li>'; 
	                              }
	                            }
	                        }
	                  ?>
		            
				<!-- buscador -->
							
				  	<li class="searchit">  
							<i class="fa fa-search searchicon tooltip" title="<?php echo __d('administrator', 'Buscar'); ?>" ></i>
							<div class="searchbox">
							  <?php echo $this->Form->create('search', ['url' => '', 'type' => 'get']);           
					          		echo $this->Form->input('search',array("label" => false, "div" => false, "type"=>"text", "placeholder" => __d('administrator', 'Buscar...'), )); ?>
					          		<button type="submit" value=""><i class="fa fa-search"></i></button>
					          <?php echo $this->Form->end(); ?>

		         			 </div>
				    </li>
          
				<!-- fin buscador -->

				<!-- usuario y notificaciones -->
				<li><?php echo $this->Html->link(' ', array('controller' => 'Users', 'action' => 'profile'), array('class' => 'main color5 login tooltip', 'title' => __d('administrator', "Perfil usuario") ));?></li>
				<li><?php echo $this->Html->link(' ', array('controller' => 'Users', 'action' => 'logout'),  array('class' => 'main color5 logout tooltip', 'title' => __d('administrator', "Salir") ));?></li>
				<!-- fin usuario y notificaciones -->
			</ul>
		</nav>
<!--fin top bar -->


<nav class="top-bar">

		<ul id="menu_left_bar">

		<?php $url = '/'.$plugin.'/'.$this->name.'/';

			  if(!empty($menu)) { // si el menu existe generar el foreach.
			  foreach($menu as $main) {
			  if(in_array($this->view, $main) or in_array($this->name, $main)) { $estado = 'active fondo3'; } else { $estado = null; } ?>
		      <?php if(isset($this->request->params['prefix'])){
		      	$url = '/'.$this->request->params['prefix'].'/';
		      	?>
		      <li><?php echo $this->Html->link(__d('administrator', $main[0]), $url.$main[1], array('class'=> $estado. ' color5 fondoh3', 'id' => $this->name));?></li>	
		      <?php }else{?>
		      <li><?php echo $this->Html->link(__d('administrator', $main[0]), $url.$main[1], array('class'=> $estado. ' color5 fondoh3', 'id' => $this->name));?></li>	
		      <?php }?>
		<?php } 

		} ?>
		</ul>


		<?php //SubMenu
			foreach ($menu as $submenu) {
				//echo pr($submenu);
				if(array_key_exists("Submenu", $submenu) and in_array($this->view, $submenu)){
					?>
					<ul id="subMenu" class="fondo1">
			
					<?php foreach($submenu['Submenu'] as $subb) {
					 	  	//echo pr($subb);
						if(!isset($CODE)){
							$CODE=NULL;
						}
						  if(in_array($this->view,$subb) or in_array($CODE,$subb)) { $estado = 'active'; } else { $estado = null; } ?>
					      <li><?php echo $this->Html->link(__d('administrator', $subb[0]), array('action' => $subb[1]), array('class'=> $estado. ' color5', 'id' => $this->name));?></li>	
					<?php } ?>
					</ul>

		<?php }	} ?>

</nav>