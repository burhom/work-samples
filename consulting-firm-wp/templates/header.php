<header id="header">
  <nav role="navigation" class="navbar">
    <div class="container">
      <div class="navbar-header">
        <div id="main-nav" class="collapse navbar-collapse">
          <?php
          if (has_nav_menu('primary_navigation')) :
            wp_nav_menu(array('theme_location' => 'primary_navigation', 'menu_class' => 'nav navbar-nav'));
          endif;
          ?>
        </div>
        <a href="/" class="logo">
          <img src="/assets/img/logo.png" alt="<?php echo get_bloginfo('name'); ?>">
        </a>
        <button type="button" data-toggle="collapse" data-target="#main-nav" class="navbar-toggle">
          <span class="sr-only">navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
      </div>
    </div>
  </nav>
</header>