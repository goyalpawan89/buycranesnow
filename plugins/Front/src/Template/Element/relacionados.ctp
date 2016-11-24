
<?= pr($content->categories); ?>

<section class="destacados background border1">
    <div class="slider4">
      
      <?php foreach ($latestsPosts as $post) { 
        $image = $post->archive_id; //id de la imagen
        $excerpt = $this->Get->get_excerpt($post->id, 70); //get excerpt (descricion o texto dependiendo de si existe o no)
        $video = $this->Get->get_field_by_post_id($post->id, 'video'); ?>
        
          <div class="slide destacados_slide">
                    <a href="<?= $this->Get->get_link($post->id, 'Posts'); ?>">
                            <aside class="slide_img fondo0 border0 <?php if($video && !empty($video)) { echo 'list-post_image_video'; } ?>" style="background-image:url(<?= $this->Image->url($image, 'medium') ?>);">
                                <h3 class="color0 fondo2 border1"><?= $post->name; ?></h3>
                            </aside>
                    </a>
          </div>
      <?php } ?>
    </div>
</section>