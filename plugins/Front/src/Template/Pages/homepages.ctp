
<!-- contenido principal -->
<section class="content background">
	<div class="wrap">
			
			<!-- publicidad superuir -->
			<?= $this->element('Front.publicity_up'); ?>
			
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
					<td class="fondogris">
						<?= $this->element('sidebar');?>
					</td>
					<td>

						<!-- descripcion de la categoria -->
						<article class="category-description description page_description">
							<h1><?= $content->name; ?></h1>

							<?php if(!empty($content->archive_id)) { echo $this->Html->image($this->Image->url($content->archive_id, 'full'), ['class' => 'img_page', 'alt' => $content->name]); } ?>

							<?= $content->description; ?>
						</article>

					</td>
				</tr>
			</table>

	</div>
</section>