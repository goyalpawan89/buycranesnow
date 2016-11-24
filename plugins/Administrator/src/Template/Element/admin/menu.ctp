
<div id="menu">
	<nav>
		<h2><i class="fa fa-reorder color3 colorh2 tooltip" title="Menú"></i><?php echo __d('administrator', 'Escritorio'); ?></h2>
		<ul>

		<?php foreach($sidebar as $item => $b){
				if (in_array($this->name,$b) or array_search($this->name, $b)) { $estado = 'active fondo3'; } else { $estado = null; } ?>
				
				
				<li><?php echo $this->Html->link(__d('administrator',$b[0]), '#', array('class'=> $estado, 'title'=> $b[0], 'id' => $b[1])); ?></a>
					
					<h2><?php echo __d('administrator', $b[0]); ?></h2>
					<ul>
							<?php foreach ($b['submenu'] as $submenu) {
							      if($estado == 'active fondo3' && $this->request->params['action']=== $submenu[1])  { $estado = 'active fondo3'; } else { $estado = null; }  ?>

								<li><?php echo $this->Html->link(__d('administrator', $submenu[0]), '/'.$plugin.'/'.$b[1].'/'.$submenu[1], array('class'=> $estado, 'id' => $b[1]));?></a>
									<?php /*
										<h2><i class="fa fa-phone"></i>Mobile Phones</h2>
										<ul>
										<li> <?php echo $this->Html->link(__d('administrator','Todas las '. $b[0]), '/'.$plugin.'/'.$b[1], array('class'=> $estado, 'id' => $b[1]));?></li>
										<li> <a href="#">Thin Magic Mobile</a> </li>
										<li> <a href="#">Performance Crusher</a> </li>
										<li> <a href="#">Futuristic Experience</a> </li>
										</ul>
									*/ ?>

								</li>

							<?php } ?>
					</ul>
				</li>

			<?php } ?>

		</ul>

		 
	</nav>
</div>
