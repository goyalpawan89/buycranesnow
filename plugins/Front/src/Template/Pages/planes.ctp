
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
			<table class="content_planes fondogris">
				<tr>
					
					<td>
						<!-- descripcion de la categoria -->
						<article class="category-description description page_description planes_description">
							<h1><?= $content->name; ?></h1>

							<?php if(!empty($content->archive_id)) { echo $this->Html->image($this->Image->url($content->archive_id, 'full'), ['class' => 'img_page', 'alt' => $content->name]); } ?>

									<?= $content->description; ?>


						</article>

					</td>
				</tr>
			</table>

	</div>
</section>


<script type="text/javascript">
	$('.content_planes p a').addClass('btn fondo1 fondoh3 color3 colorh1');
	$('.content_planes table td').addClass('border1');
	$('.content_planes table td > strong').addClass('fondo3 color1');


	<?php  if($authUser) {

			if($authUser['type'] == 'Premium') { $text = 'see_profile';  } else { $text = 'change_premium'; } ?>

			$('a[href="#login"]').removeClass('fancybox').attr('href', '<?= $this->Url->build(["controller" => "Users", "action" => "profile"], true); ?>').text('<?= __($extras[$text]); ?>');

			$('a[href="#premium"]').replaceWith( '<?= $this->Get->get_pay_form($extras["get_premium"], $authUser, $info["premium"], $extras["paypal_pay"],  '12'); ?>');
			$('a[href="#professional_plan"]').replaceWith( '<?= $this->Get->get_pay_form($extras["professional_plan"], $authUser, $info["professional_plan"], $extras["paypal_pay"],  '6'); ?>');
			$('a[href="#banner_rotative"]').replaceWith( '<?= $this->Get->get_pay_form($extras["plan_banner_rotative"], $authUser, $info["banner_rotative"], $extras["get_it_now"],  '1'); ?>');
			$('a[href="#banner_static"]').replaceWith( '<?= $this->Get->get_pay_form($extras["plan_banner_static"], $authUser, $info["banner_static"], $extras["get_it_now"],  '1'); ?>');
			$('a[href="#banner_premium"]').replaceWith( '<?= $this->Get->get_pay_form($extras["plan_banner_premium"], $authUser, $info["banner_premium"], $extras["get_it_now"],  '1'); ?>');
			$('a[href="#banner_rotative_logotype_home"]').replaceWith( '<?= $this->Get->get_pay_form($extras["plan_banner_rotative_logotype_home"], $authUser, $info["banner_rotative_logotype_home"], $extras["get_it_now"],  '1'); ?>');

			$('.pay_button').each( function() {

					var lastTitle = $(this).parent().parent().find('#item-name');
					var newTitle = $(this).parent().parent().parent().parent().find('h3').text();
					
					$(lastTitle).val(newTitle);
					//alert(lastTitle);
			
			});

	<?php } else { ?>

			//usuario no logueados les abrirá popup de login
			$('.page_description a').attr('href', '#login').addClass('fancybox btn fondo1 fondoh3');

	<?php } ?>

</script>
