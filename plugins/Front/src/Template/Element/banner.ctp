<section class="banner border1 background">
    <a href="" id="arrow_left"><?= $this->Html->image('arrow_left.png', ['alt' => 'Anterior']); ?></a>
    <a href="" id="arrow_right"><?= $this->Html->image('arrow_right.png', ['alt' => 'Siguiente']); ?></a>
    
    <?= $this->Html->image('ajax-loader.gif', ['id' => 'cycle-loader']); ?>
    <div id="maximage">

      <?php foreach ($imagesBanner as $image) {

            if(!empty($image['_joinData']['button_text'])) { $btnText = __d('Front', $image['_joinData']['button_text']); } else { $btnText = $extras['more_information']; } 
            if($image['_joinData']['new_tab'] != 0) { $target = '_blank'; } else { $target = '_self';  } ?>
      
              <div>
                <?= $this->Html->image($this->Image->url($image['id'], 'full'), ['alt' => 'banner']); ?>
                <?php //echo $this->Html->image('gradient.png', ['id' => 'gradient']); ?>
                <div class="in-slide-content color0" style="display:none;">
                  <div class="wrap">
                      <p><?= $image['_joinData']['description']; ?></p>
                      <p><?= $this->Html->link($btnText, $image['_joinData']['url'], ['class' => 'btn fondo1 fondoh3 color3 colorh0', 'target' => $target]);?></p>
                  </div>
                </div>
              </div> 

      <?php } ?>
      
    </div>
</section>