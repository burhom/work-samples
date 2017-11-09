<section id="home">
  <a href="#" class="home-logo">
    <img src="/assets/img/logo-home.png" alt="<?php echo get_bloginfo('name'); ?>">
  </a>
  <div id="home-nav">
    
    <?php while (have_posts()) : the_post();
      
      $menus = wp_get_nav_menus();
      $menu_items = wp_get_nav_menu_items($menus[0]);
     
      foreach ($menu_items as $menu_item): ?>
        <a href="<?php echo $menu_item->url; ?>">
          <div class="diamond"></div>
          <h2><?php echo $menu_item->title; ?></h2>
        </a>
      <?php endforeach;
    endwhile; ?>

  </div>
</section>