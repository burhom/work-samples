<?php while (have_posts()) : the_post(); ?>

  <section id="<?php global $post; echo $post->post_name; ?>">
    <div class="container">
      <div class="row">
        <div class="col-md-3">
          <h1><?php the_title(); ?></h1>
        </div>
        <div class="col-md-9">
          <?php the_content(); ?>
        </div>
      </div>
    </div>
  </section>

<?php endwhile; ?>
