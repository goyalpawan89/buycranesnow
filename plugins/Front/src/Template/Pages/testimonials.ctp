
<!-- contenido principal -->
<section class="content background">
	<div class="wrap">
			
			<!-- publicidad superuir -->			
			<aside id="breadcrumbs" class="list-description table">	
				<aside class="list-description_item table-cell"><b><?= $extras['you_are_in']; ?>: </b> 
					<?php $this->Html->addCrumb($content->name, '', ['class' => 'color2']); 
						  echo $this->Html->getCrumbs(' » '); ?>
				</aside>
			</aside>
			<!-- fin descripcion de la categoria -->

			<!-- Contenido de la categoria -->
			<table class="content-table content-table_page">
				<tr>
					
					<td>
					
						<!-- descripcion de la categoria -->
						<article id="content_testimonials" class="category-description description page_description">
							<h1><?= $content->name; ?></h1>

							<?php if(!empty($content->archive_id)) { echo $this->Html->image($this->Image->url($content->archive_id, 'full'), ['class' => 'img_page', 'alt' => $content->name]); } ?>

							<?php foreach ($testimonios as $page_home) {
										  $video = $this->Get->get_field_by_page_id($page_home->id, 'video'); 
										  if(isset($video) && !empty($video)) { $imgLink = $video; $class = 'fancybox-media video'; } else { $imgLink = false; $class = ''; } ?>
								
								    <!-- testimonios -->

									    <table id="testimonial_item" class="page_home" width="100%">
									        <tr>
											    <td class="page_home-image">
											        <?= $this->Html->link($this->Html->image($this->Image->url($page_home->archive_id, 'medium'), ['class' => 'page_home-image-img', 'alt' => $page_home->name]), $imgLink, ['class' => $class.' border1', 'escape' => false, 'rel' => false]); ?>
											    </td>
											    <td class="page_home-text">
											        <?= $page_home->description; ?>
											    </td>
											</tr>
										</table>
									<!-- fin publicidad inferior -->

								
							<?php } ?>

						</article>

					</td>
				</tr>
			</table>

	</div>
</section>

<script type="text/javascript">
	
	$('.page_home-text a').addClass('color1');

</script>