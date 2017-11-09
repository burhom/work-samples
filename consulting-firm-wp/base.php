<?php
//check if redirect page
if (is_attachment() || is_author()) {
  wp_redirect(home_url(), 301); exit;
} else {
  get_template_part('templates/head'); ?>
  
  <?php if(is_single()) {
    $bodyClass = 'single';
  } elseif(is_front_page()) {
    $bodyClass = 'home';
  } elseif(is_page_template('template-projects.php')) {
    $bodyClass = 'projects';
  } elseif(is_page() && !is_page_template('template-projects.php')) {
    $bodyClass = 'page';
  }?>
  <body class="<?php echo $bodyClass; ?>">
    <div id="wrapper">
    
      <?php if(!is_front_page()) {
        // <!-- Header -->
        get_template_part('templates/header');
        // <!-- END Header -->
      } ?>

      <!-- Main Content -->
      <?php include roots_template_path(); ?>
      <!-- END Main Content -->

    </div>
    
    <!-- Footer -->
    <?php get_template_part('templates/footer'); ?>
    <!-- END Footer -->

  </body>
  </html>
<?php } ?>