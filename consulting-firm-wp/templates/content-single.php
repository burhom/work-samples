<?php while (have_posts()) : the_post(); ?>
  <section class="single-project">
  
    <?php $slides = get_field('image_slider');
    if($slides) { ?>
      <div class="slider">
        <a href="#" class="prev">
          <span></span>
          <i class="fa fa-chevron-left"></i>
        </a>
        <a href="#" class="next">
          <span></span>
          <i class="fa fa-chevron-right"></i>
        </a>
          <?php foreach( $slides as $slide ):
            $slide_img = wp_get_attachment_image_src($slide['id'], 'slide_img');
            echo '<div class="slide"><img src="'.$slide_img[0].'"></div>';
          endforeach; ?>
      </div>
    <?php } ?>
    <div class="container">
      <div class="row">
        <div class="col-md-9 col-md-offset-3">
          <header>
            <h1 class="project-title"><?php the_title(); ?><br><?php the_field('address_2'); ?></h1>
          </header>
          <h3>Description</h3>
          <div class="content"><?php the_content(); ?></div>
          
          <?php $map_link = get_field('map_url');
          if($map_link) { ?>
            <a href="<?php echo $map_link; ?>" target="_blank" class="map-link">
              <span>View</span>
              <div class="diamond-wrapper">
                <div class="diamond"></div>
                <i class="fa fa-map-marker"></i>
              </div>
              <span>Map</span>
            </a>
          <?php } ?>
        </div>
      </div>
    </div>
  </section>
<?php endwhile; ?>
