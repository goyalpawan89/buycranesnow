
<!-- contenido principal -->
<section class="content background">
	<div class="wrap">
			

			<!-- Contenido de la categoria -->
			<table class="content-table">
				<tr>
					
					<td>
						<content class="content-table_content">
				

							<!-- isotope -->
								<div>
										<div class="grid">
											
											  <?= $this->element('Front.compare');?>

										<div>
								<div>
							<!-- isotope -->

						</content>
					</td>
				</tr>
			</table>
			<!-- fin contenido de la categoria -->

			


	</div>
</section> 


<!-- nuevos arrivos -->
			<section class="up-section counter-section background">
                    <div class="wrap">
                       	<h2 class="title-section"><?= __($extras['new_arrivals']); ?></h2>
                    </div>
					<?= $this->element('Front.destacados');?>
			</section>
<!--fin nuevos arrivos -->