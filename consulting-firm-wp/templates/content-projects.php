<section id="projects">
  <div class="container">
    <div class="row">
      <div class="col-md-3">
        <h1>Projects</h1>
      </div>
      <div class="col-md-9">
        <div class="row">

          <?php       
          // args
          $args = array(
            'numberposts' => -1,
            'post_type' => 'project',
            'order' => 'ASC',
            'orderby' => 'menu_order'
          );
                 
          // get results
          $projects = new WP_Query( $args );

          while ( $projects->have_posts() ) : $projects->the_post(); ?>
            <article class="project-thumb col-sm-6 col-lg-4">
              <a href="<?php the_permalink(); ?>">
                <div class="thumb-wrapper">
                  <?php
                    $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'project_thumb');
                  ?>
                  <img src="<?php echo $thumb[0]; ?>">
                  <div class="overlay">
                    <div class="overlay-bg"></div>
                    <?php the_title(); ?><br><?php the_field('address_2'); ?>
                  </div>
                </div>
              </a>
            </article>
          <?php endwhile; ?>

        </div>
      </div>
    </div>
  </div>
</section>
