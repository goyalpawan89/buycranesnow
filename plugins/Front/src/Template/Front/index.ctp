
<!-- banner principal -->
<?= $this->element('Front.banner');?>
<!-- fin banner principal -->

<!-- categorias principales -->
<section class="categories_home background">
      <aside class="wrap categories_home-aside">

        <?php foreach ($principal_categories as $key => $category) { $image = $category->archive_id; ?>
          <li class="categories_home-item">
            <a href="<?= $this->Get->get_link($category->id, 'Categories'); ?>" class="colorh1 color3">
              <table class="categories_home-item-table">
                <tr>
                <td class="categories_home-item-table-img"><?php //echo $this->Html->image($this->Image->url($image, 'medium'), ['fullBase' => true, 'plugin' => false, 'alt' => 'cambio'.$category->name]); ?>
                <img src="<?= $this->Image->url($image, 'medium'); ?>">
                </td>
                </tr>
                <tr><td><span><?= __($this->Get->get_name($category->id, 'Categories')); ?></span></td></tr>
              </table>
            </a>
          </li>
        <?php } ?>
      </aside>
</section>
<!--fin categorias principales -->

<?php if(isset($publicity) && !empty($publicity)) { 
      
      $imagePublicity = $this->Image->url($publicity->archive_id, 'full');  ?>
<!-- promociones principales -->
<section class="banner_promo opacity" style="background-image: url(<?= $imagePublicity; ?>);">
  <aside class="wrap">
      <div class="banner_promo_1">
        <h2 class="color1"><?= __($publicity->name); ?></h2>
        <article class="color0"><?= __($publicity->description); ?></article>
      </div>
      <div class="banner_promo_2">
      <?php if(!$authUser) {
               echo $this->Html->link(__($extras['login']), '#login', ['class' => 'fancybox btn fondo1 fondoh3 color3 colorh0']); 
          } else { 
               echo $this->Html->link(__($controllerText['crane_publish']), 'admin/Posts/add', ['class' => 'fancybox btn fondo1 fondoh3 color3 colorh0']); 
        }
      ?>
      </div>
  </aside>
</section>
<!-- fin promociones principales -->
<?php } ?>


<!-- destacados principales -->
<?= $this->element('Front.carousel_sugerencias');?>
<!-- fin carousel destacados principales -->


<!-- carousel destacados principales -->
<?= $this->element('Front.destacados');?>
<!-- fin carousel destacados principales -->