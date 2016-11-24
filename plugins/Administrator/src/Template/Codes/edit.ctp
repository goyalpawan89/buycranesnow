<!-- $controllerText (palabras especificas), $extras (palabras generales), $imagesText (palabras para la seccion imagenes) llamado desde component TextsComponent -> appcontroller textos del .ctp -->
 


<h1 id="principal" class="sinmargenabajo"><?php echo __($controllerText['title']); ?></h1>
<p id="descripcion"><?php echo __($controllerText['description']); ?></p>


<?php if(isset($codigos)){?>
<article>
  <h2>Códigos generados.</h2>
  <pre>
<?php echo print_r($codigos); ?>
</pre>
</article>
<?php } ?>


<?php $this->Form->templates($template);?>

<?php echo $this->Form->create($form, array( 'id'=>'upload', 'enctype' => 'multipart/form-data')); ?>

<div class="flexbox">
<!-- contenido izquierdo descripcion e info -->
	<section class="parte1 editor">
	        <?php echo $this->Form->input('cantidad', array('label' => false, 'placeholder' => $controllerText['title_placeholder'], 'required'));  ?>
	        <?php echo $this->Form->input('cc', array('label' => false, 'placeholder' => $controllerText['categorias']));  ?>

	        

        <table id="adicional" class="bloquete">
          <tr><td class="fondo colorblanco"><label for="PostType"><?php echo __($controllerText['metodo']); ?></label></td></tr>
          <tr>
            <td><?php echo $this->Form->input('metodo', array('type' => 'select', 'required', 'options' => $metodo, 'label' => false, 'empty' => $extras['select_default'])); ?>
                                         
            </td>
          </tr>
        </table>



  <!-- categorias de la publicación -->
          <table id="adicional">
                  <tr><td class="fondo colorblanco"><label for=""><?php echo __($extras['codes']); ?></label></td></tr>
                  <tr>
                    <td>
                      <aside class="category_aside"> 
                         <ul class="category_shoose"> 
      				 <?php 
                $getCategories = $this->requestAction('Administrator.Categories/getCategoriesPost', ['id'=>2]); 
               //echo pr($getCategories);

               $conteo=0;
               foreach($getCategories as $category) { ?>
                          <li>
                              <label for="<?php echo 'posts'.$category['id']; ?>" class="color">
                 <?php echo $this->Form->checkbox('posts.'.$conteo.'.id', 
      												   array('hiddenField' => false, 'label' => false, 'value' => $category['id'], 'id' => 'cat'.$category['id'], 'checked' => $category['check'], 'multiple'=>true )
      						); ?>

      						<?php $name=str_replace("_", "- ", $category['name']);
                  echo __($name); ?>
                              </label>
                          </li>
                       <?php $conteo++;} ?>
                         </ul>
                      </aside>   
                    </td>
                  </tr>
          </table>
                     	<!-- categorias de la publicación -->




	</section>

		


<!-- contenido derecho descripcion e info -->
	<section class="parte2">
		
	                      <!-- bloque datos generales boton enviar -->
	                        
	                      <!-- bloque datos generales boton enviar -->

	                      <!-- campos generales -->

	    <table id="adicional" class="bloquete">
          <tr><td class="fondo colorblanco"><label for="PostType"><?php echo __($controllerText['type']); ?></label></td></tr>
          <tr>
            <td><?php echo $this->Form->input('type', array('type' => 'select', 'required', 'options' => $tipo, 'label' => false, 'empty' => $extras['select_default'])); ?>
            <p class="mini_descrip"><?php echo __($controllerText['type_description']); ?></p>                              
            </td>
          </tr>
        </table>



         <table id="adicional" class="bloquete">
	        <tr><td class="fondo colorblanco"><label for="PostType"><?php echo __($controllerText['estado']); ?></label></td></tr>
	        <tr>
	          <td><?php echo $this->Form->input('status', array('type' => 'select', 'required', 'options' => $estado, 'label' => false, 'empty' => $extras['select_default'])); ?>
	                                     
	          </td>
	        </tr>
        </table>


		                                 
		            	  
		<table id="adicional">
            <tr>
            	<td><?php echo $this->Form->input(__($controllerText['submit']), array('type' => 'submit', 'label' => false)); ?> </td>
            </tr>
        </table>
		            	



	</section>

</div>

<?php echo $this->Form->end(); ?>



