<?php if($this->request->params['action'] !='profile') { ?>
<!-- carousel destacados principales -->
<section class="marcas background border1">
    <div class="wrap">
        <div class="slider3">
          <?php foreach ($customersImages as $image) { ?>
                <div class="slide marcas_slide">
                  <a class="marcas_a" style="background-image:url(<?= $this->Image->url($image['id'], 'full'); ?>);"></a>
                </div>
          <?php } ?>
        </div>
    </div>
</section>
<!-- fin carousel destacados principales -->
<?php } ?>

<footer class="fondo2">
	<div class="wrap">
		
		<!-- about us -->
		<aside class="footer_aside">
		 	<h3 class="footer_title color0"><?= __($extras['about_us']); ?></h3>
			 	<ul>
			 		<?php foreach ($main_about_us as $key => $item) {
			 			  $page = $this->Get->get_name($item['id'], $item['type']);
				 	      if(!empty($page)) { ?>
			 				<li class="servicios_list item-<?= $item['id']; ?>"><a class="color0 colorh1" href="<?= $this->Get->get_link($item['id'], $item['type']); ?>"> <?= $page; ?></a></li>
			 		<?php } } ?>
			 	</ul>
		</aside>
		
		<!-- services -->
		 <aside class="footer_aside">
		 	<h3 class="footer_title color0"><?= __($extras['our_services']); ?></h3>
				<ul>
				 	<?php foreach ($main_services as $key => $item) {
				 	      $page = $this->Get->get_name($item['id'], $item['type']);
				 	      if(!empty($page)) { ?>
			 				<li class="servicios_list item-<?= $item['id']; ?>"><a class="color0 colorh1" href="<?= $this->Get->get_link($item['id'], $item['type']); ?>"> <?= $page; ?></a></li>
			 		<?php } } ?>
			 	</ul>			
		 </aside>

		 <!-- account -->
		 <aside class="footer_aside">
		 	<h3 class="footer_title color0"><?= __($extras['bussiness_partner']); ?></h3>
				<ul>
				 	<?php foreach ($main_members as $key => $item) { 
				 		$page = $this->Get->get_name($item['id'], $item['type']);
				 	      if(!empty($page)) { ?>
			 				<li class="servicios_list item-<?= $item['id']; ?>"><a class="color0 colorh1" href="<?= $this->Get->get_link($item['id'], $item['type']); ?>"> <?= $page; ?></a></li>
			 		<?php } } ?>
			 	</ul>
		 </aside>

		<!-- account -->
		 <aside class="footer_aside">
		 	<h3 class="footer_title color0"><?= __($extras['account']); ?></h3>

		 		<ul>
				 	<li class="servicios_list"><?= $this->Html->link(__($extras['my_account']), $this->Get->get_url_translate('Users', 'profile'), ['class' => 'need_login color0 colorh1']); ?></li>

				 	<?php if($authUser) { ?>
					 	<li class="servicios_list user_type_<?= $userRole; ?>"><?= $this->Html->link(__($extras['my_favorites']), $this->Get->get_url_translate('Posts', 'my_favorites'), ['class' => 'need_login color0 colorh1' ]); ?></li>
					 	<li class="servicios_list"><?= $this->Html->link(__($extras['register']), '#register', ['class' => 'not_login color0 colorh1']); ?></li>
					 	<li class="servicios_list"><?= $this->Html->link(__($extras['forgot_password']), '#change_password', ['class' => 'not_login fancybox color0 colorh1']); ?></li>
					 	<li class="servicios_list user_type_<?= $userRole; ?>"><?= $this->Html->link(__($extras['see_site']), $this->Get->get_url_translate('Users', 'site'), ['class' => 'need_login color0 colorh1']); ?></li>
					 	<li class="servicios_list user_type_<?= $userRole; ?>"><?= $this->Html->link(__($extras['my_offers']), $this->Get->get_url_translate('Users', 'my_offers'), ['class' => 'need_login color0 colorh1']); ?></li>
					<?php } ?>
			 	</ul>
		 </aside>
	
	</div>
</footer>


<footer class="fondo2 inferior">
	<div class="wrap">
		
		<!-- about us -->
		<aside class="footer_aside newsletter_aside">
				
				<p class="color0"><?= __($info['suscribe_info']); ?></p>

				<?= $this->Form->create('Newsletters', ['url' => $this->Get->get_url_translate('Newsletters', 'index'), 'id'=>'newsletter', 'class' => 'fondo0', 'enctype' => 'multipart/form-data']); 
				
								echo $this->Form->input('email', ['label' => false, 'placeholder' => __($extras['newsletter_email']) ]);
								echo $this->Form->button('suscribe', ['label' => false, 'type'=>'submit', 'class' => 'color2 colorh0 fondo1 fondoh3'] );

				echo $this->Form->end(); ?>
		</aside>
		
		<!-- services -->
		 <aside class="footer_aside apps">
			<?= $this->Html->link('', '#', ['title' => 'App Store', 'class' => 'store app_store', 'escape' => true]); ?>
			<?= $this->Html->link('', '#', ['title' => 'Google Play', 'class' => 'store google_play', 'escape' => true]); ?>
		 </aside>

		<!-- account -->
		 <aside class="footer_aside social_icons">
		 		<span class="follow"><?= __($extras['follow_us']); ?></span>
			 	<?php $social =json_decode($info['social']); foreach ($social as $red) { echo $this->Html->link('', $red->url, ['title' => $red->name, 'class' => 'fa fa-'.$red->icon.' redes fondo0 fondoh1 color2', 'escape' => true]); } ?>
		 </aside>


	<div class="feet-footer color0">
				<p>
				<?= date('Y'); ?> <?= __($blogName); ?> - <?= __($extras['coryright']); ?> 
				<span class="developed_by"><font><?= __($extras['developed_by']); ?>:</font> <?= $this->Html->link('T&T Interactiva SAS',  'http://interactiva.net.co/', ["target" => '_blank', "alt" => "T&T interactiva S.A.S.", 'class' => 'color1']); ?></span>
				</p>
	</div>

	
	</div>
</footer>


    <!-- responsive nav -->
    <aside class="navigation_responsive">
        <label class="mobile_menu label-main" for="mobile_menu"><span class="item_responsive"><i class="fa fa-align-justify"></i></span></label>
        <label class="mobile_menu_search label-main"><span class="item_responsive"><i class="fa fa-search color0"></i></span></label>
        <!--<label class="mobile_menu_chat label-main"><a class="item_responsive" href="/chat/chat?locale=en" target="_blank" onclick="Mibew.Objects.ChatPopups['56d9f7b2b5360f85'].open();return false;"><i class="fa fa-weixin color0"></i></a></label>-->
	</aside>




<!-- Start of Smartsupp Live Chat script -->
<script type="text/javascript">
var _smartsupp = _smartsupp || {};
_smartsupp.key = "5aee8bc3cb222ec09d140f8c9fd60c95f9bf76c0";
window.smartsupp||(function(d) {
         var s,c,o=smartsupp=function(){ o._.push(arguments)};o._=[];
         s=d.getElementsByTagName('script')[0];c=d.createElement('script');
         c.type='text/javascript';c.charset='utf-8';c.async=true;
         c.src='//www.smartsuppchat.com/loader.js';s.parentNode.insertBefore(c,s);
})(document);
</script>
<!-- End of Smartsupp Live Chat script -->
