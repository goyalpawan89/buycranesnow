
<?php $video = $this->Get->get_field_by_page_id($page_home->id, 'video'); 
      if(isset($video) && !empty($video)) { $imgLink = $video; $class = 'fancybox-media video'; } else { $imgLink = ''; $class = ''; } ?>

<!-- publicidad inferior -->
<section class="publicidad background border3">
    <div class="wrap">

    <!-- ultimas gruas -->
                        <ul class="page_home-latests latest_list fondo0">
                        <h2 class="fondo1 color3"><?= __($extras['latests_publications']); ?></h2>

                          <div id="scrollable_div1">
                          <?php foreach ($latests as $id => $name) { 
                            
                                    echo '<li>'.$this->Html->link($this->Get->get_name($id, 'Pages'), $this->Get->get_link($id, 'Posts'), ['class' => 'color3 fondoh3 colorh1']).'</li>';
                                   
                          } ?>
                          </div>

                        </ul>
    <!-- ultimas gruas -->


    <!-- testimonios -->

      <table class="page_home" width="100%">
        <tr>
          <td class="page_home-image">

            <?= $this->Html->link($this->Html->image($this->Image->url($page_home->archive_id, 'medium'), ['class' => 'page_home-image-img', 'alt' => $this->Get->get_name($page_home->id, 'Pages')]), $imgLink, ['class' => $class.' border1', 'escape' => false, 'rel' => false]); ?>
          </td>
          <td class="page_home-text">
            <?= $this->Get->get_content($page_home->id, 'Pages'); ?>
          </td>
        </tr>
      </table>
    </div>
</section>
<!-- fin publicidad inferior -->



<script type="text/javascript">
  
  <?php if(!$authUser) { ?>
      $('.page_home-text a').attr('href', '#login');
      $('.page_home-text a').addClass('fancybox color3');
  <?php } ?>

</script>