

<!-- contenido principal -->
<section class="content background">
	<div class="wrap">
			
			<?= $this->element('Front.up_category');?>

			<!-- Contenido de la categoria -->
			<table class="content-table">
				<tr>
					<td class="fondogris">
						<?= $this->element('sidebar');?>
					</td>
					<td>
						<content class="content-table_content">
											
								<?= $this->element('Front.post_info');?>

						</content>
					</td>
				</tr>
			</table>
			<!-- fin contenido de la categoria -->

			<!-- paginador -->
			<section class="up-section counter-section fondo5">
                            <div class="wrap">
                                <div class="pagin-count">
                                    <p><?= $this->Paginator->counter(['format' => ''.__($extras['page']).' {{page}} '.__($extras['of']).' {{pages}}, '.__($extras['showing']).' {{current}} '.__($extras['log']).' {{count}}']);?></p>
                                    <nav>
                                        <?= $this->Paginator->prev('');
                                              echo $this->Paginator->numbers(['separator' => ' - ','currentTag' => 'a', 'currentClass' => 'active','tag' => 'li','first' => 1]);
                                              echo $this->Paginator->next(''); ?>
                                    </nav>
                                </div>
                            </div>
			</section>
			<!-- fin paginador -->


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


<?= $this->element('Front.script_gruas_mapa');?>