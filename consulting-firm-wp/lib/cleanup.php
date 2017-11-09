<?php

// Cleanup wordpress


// remove admin bar always
show_admin_bar(false);


/*  ------------------------- */
/*  Admin Section Clean-up
/*  ------------------------- */

// remove dashboard widgets
function roots_remove_dashboard_widgets() {
  remove_meta_box('dashboard_incoming_links', 'dashboard', 'normal');
  remove_meta_box('dashboard_plugins', 'dashboard', 'normal');
  remove_meta_box('dashboard_primary', 'dashboard', 'normal');
  remove_meta_box('dashboard_secondary', 'dashboard', 'normal');
  remove_meta_box('dashboard_recent_drafts', 'dashboard', 'normal');
  remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');
  remove_meta_box('dashboard_right_now', 'dashboard', 'normal');
  remove_meta_box('dashboard_activity', 'dashboard', 'normal');


  // posts
  remove_meta_box('dashboard_quick_press', 'dashboard', 'normal');
  //remove_meta_box('postexcerpt', 'post', 'normal');
  remove_meta_box('trackbacksdiv', 'post', 'normal');
  remove_meta_box('tagsdiv-post_tag', 'post', 'normal');
}

add_action('admin_init', 'roots_remove_dashboard_widgets');


// remove comments row
function remove_pages_count_columns($defaults) {
  unset($defaults['comments']);
  return $defaults;
}
add_filter('manage_pages_columns', 'remove_pages_count_columns');


// hide categories
function hide_categories() {
  register_taxonomy('category', array());
}
add_action('init', 'hide_categories');


// remove links section from admin
add_action( 'admin_menu', 'my_admin_menu' );
function my_admin_menu() {
  remove_menu_page('edit-comments.php');
  remove_menu_page('tools.php');
  remove_menu_page('link-manager.php'); 
  if ( current_user_can('edit_themes') == false) {
    remove_menu_page('options-general.php');
    remove_menu_page('themes.php');
  }
  
  remove_submenu_page('edit.php', 'edit-tags.php?taxonomy=post_tag');
  remove_submenu_page('themes.php', 'widgets.php');

  //should never be able to edit theme files!
  remove_submenu_page('themes.php', 'theme-editor.php');
  
  //check if we're using posts
  $roots_option = roots_get_global_options();
  $show_posts = $roots_option['roots_show_posts'];
  if ($show_posts == 'no') {
    remove_menu_page('edit.php'); 
  }
}


// remove wp nav links
function wps_admin_bar() {
  global $wp_admin_bar;
  $wp_admin_bar->remove_menu('wp-logo');
  $wp_admin_bar->remove_menu('about');
  $wp_admin_bar->remove_menu('wporg');
  $wp_admin_bar->remove_menu('documentation');
  $wp_admin_bar->remove_menu('support-forums');
  $wp_admin_bar->remove_menu('feedback');
  $wp_admin_bar->remove_menu('view-site');
  $wp_admin_bar->remove_menu('comments');
  //$wp_admin_bar->remove_menu('new-post');
  $wp_admin_bar->remove_menu('new-media');
  $wp_admin_bar->remove_menu('new-link');

  //check if we're using posts
  $roots_option = roots_get_global_options();
  $show_posts = $roots_option['roots_show_posts'];
  $role = get_role( 'editor' );
  if ($show_posts == 'no') {
    $wp_admin_bar->remove_menu('new-post'); 
    // $role->remove_cap( 'edit_posts' );
  } else {
    $role->add_cap( 'edit_posts' );
  }
}
add_action( 'wp_before_admin_bar_render', 'wps_admin_bar' );

// get the "editor" role object
$role = get_role( 'editor' );

// remove "theme, category editing, links, and deleting pages from this role object
$role->remove_cap( 'manage_categories' );
$role->remove_cap( 'manage_links' );
$role->remove_cap( 'delete_others_pages' );

$role->remove_cap( 'edit_themes' );
$role->remove_cap( 'switch_themes' );

//add menu capability for editors
$role->add_cap( 'manage_options' );
$role->add_cap( 'edit_theme_options' );

//add GF capability for editors
$role->add_cap('gform_full_access');


/*  ------------------------- */
/*  Profile Fields
/*  ------------------------- */

//remove social fields
function remove_profile_fields( $contactmethods ) {
  unset($contactmethods['aim']);
  unset($contactmethods['jabber']);
  unset($contactmethods['yim']);
  unset($contactmethods['description']);
  return $contactmethods;
}
add_filter('user_contactmethods','remove_profile_fields',10,1);

// remove option fields
if(is_admin()){
  remove_action( 'admin_color_scheme_picker', 'admin_color_scheme_picker' );
  add_action( 'personal_options', 'prefix_hide_personal_options' );
}
function prefix_hide_personal_options() {
?>
<script type="text/javascript">
  jQuery(document).ready(function( $ ){
    $("#your-profile .form-table:first, #your-profile h3:first").remove();
  });
</script>
<?php
}

// remove default bio field
function remove_plain_bio($buffer) {
  $titles = array('#<h3>About Yourself</h3>#','#<h3>About the user</h3>#');
  $buffer=preg_replace($titles,'<h3>Password</h3>',$buffer,1);
  $biotable='#<h3>Password</h3>.+?<table.+?/tr>#s';
  $buffer=preg_replace($biotable,'<h3>Password</h3> <table class="form-table">',$buffer,1);
  return $buffer;
}

function profile_admin_buffer_start() { ob_start("remove_plain_bio"); }

function profile_admin_buffer_end() { ob_end_flush(); }

add_action('admin_head', 'profile_admin_buffer_start');
add_action('admin_footer', 'profile_admin_buffer_end');


/*  ------------------------------ */
/*  Custom Admin Footer
/*  ------------------------------ */

function change_footer_version() {
  return '';
}

function remove_footer_admin () {
  echo ADMIN_FOOTER;
}
add_filter('admin_footer_text', 'remove_footer_admin');
add_filter( 'update_footer', 'change_footer_version', 9999 );


/*  ------------------------------ */
/*  Move Menus Page
/*  ------------------------------ */

add_action('admin_menu', 'register_my_custom_submenu_page');

function register_my_custom_submenu_page() {
  add_submenu_page( 'edit.php?post_type=page', 'Navigation Menu', 'Navigation Menu', 'edit_pages', '/nav-menus.php' ); 
}


/*  ------------------------------ */
/*  Change Howdy
/*  ------------------------------ */

add_action( 'admin_bar_menu', 'wp_admin_bar_my_custom_account_menu', 11 );

function wp_admin_bar_my_custom_account_menu( $wp_admin_bar ) {
  $user_id = get_current_user_id();
  $current_user = wp_get_current_user();
  $profile_url = get_edit_profile_url( $user_id );
  
  if ( 0 != $user_id ) {
    /* Add the "My Account" menu */
    $avatar = get_avatar( $user_id, 28 );
    $howdy = sprintf( __('Welcome, %1$s'), $current_user->display_name );
    $class = empty( $avatar ) ? '' : 'with-avatar';
    
    $wp_admin_bar->add_menu( array(
      'id' => 'my-account',
      'parent' => 'top-secondary',
      'title' => $howdy . $avatar,
      'href' => $profile_url,
      'meta' => array(
        'class' => $class,
        ),
      ) );

  }
}


/*  ------------------------------ */
/*  Change Posts Display Name
/*  ------------------------------ */

function change_post_menu_label() {
  global $menu;
  global $submenu;
  $menu[5][0] = 'News';
  $submenu['edit.php'][5][0] = 'All News';
  echo '';
}
add_action( 'admin_menu', 'change_post_menu_label' );


/*  ------------------------------ */
/*  Clean-up TinyMCE
/*  ------------------------------ */

function make_mce_awesome( $init ) {
  $init['theme_advanced_blockformats'] = 'h2,h3,h4,p';
  $init['theme_advanced_disable'] = 
  'strikethrough, wp_more, justifyfull, pastetext, pasteword, forecolor, underline,spellchecker,wp_help, code';
  return $init;
}

add_filter('tiny_mce_before_init', 'make_mce_awesome');

add_filter( 'wp_default_editor', create_function('', 'return "tinymce";') );

if ( current_user_can('edit_themes') !== true) {
  add_action( 'admin_head', 'disable_html_editor_wps' );
  function disable_html_editor_wps() {
    echo '<style type="text/css">#content-html {display: none;}</style>';
  }
}


add_filter( 'mce_buttons_2', 'my_mce_buttons_2' );

function my_mce_buttons_2( $buttons ) {
  array_unshift( $buttons, 'styleselect' );
  return $buttons;
}

add_filter( 'tiny_mce_before_init', 'my_mce_before_init' );

function my_mce_before_init( $settings ) {

  $style_formats = array(
    array(
      'title' => 'Item Title',
      'block' => 'span',
      'classes' => 'title',
      'wrapper' => true
      ),

    array(
      'title' => 'Item Description',
      'block' => 'span',
      'classes' => 'desc',
      'wrapper' => true
      )
    );

  $settings['style_formats'] = json_encode( $style_formats );

  return $settings;

}


/*  ------------------------- */
/*  END
/*  ------------------------- */


function roots_head_cleanup() {
  remove_action('wp_head', 'feed_links', 2);
  remove_action('wp_head', 'feed_links_extra', 3);
  remove_action('wp_head', 'rsd_link');
  remove_action('wp_head', 'wlwmanifest_link');
  remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
  remove_action('wp_head', 'wp_generator');
  remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);

  global $wp_widget_factory;
  remove_action('wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style'));

  if (!class_exists('WPSEO_Frontend')) {
    remove_action('wp_head', 'rel_canonical');
    add_action('wp_head', 'roots_rel_canonical');
  }
}

function roots_rel_canonical() {
  global $wp_the_query;

  if (!is_singular()) {
    return;
  }

  if (!$id = $wp_the_query->get_queried_object_id()) {
    return;
  }

  $link = get_permalink($id);
  echo "\t<link rel=\"canonical\" href=\"$link\">\n";
}
add_action('init', 'roots_head_cleanup');

/**
 * Remove the WordPress version from RSS feeds
 */
add_filter('the_generator', '__return_false');

/**
 * Manage output of wp_title()
 */
function roots_wp_title($title) {
  if (is_feed()) {
    return $title;
  }

  $title .= get_bloginfo('name');

  return $title;
}
add_filter('wp_title', 'roots_wp_title', 10);


/**
 * Clean up output of stylesheet <link> tags
 */
function roots_clean_style_tag($input) {
  preg_match_all("!<link rel='stylesheet'\s?(id='[^']+')?\s+href='(.*)' type='text/css' media='(.*)' />!", $input, $matches);
  // Only display media if it is meaningful
  $media = $matches[3][0] !== '' && $matches[3][0] !== 'all' ? ' media="' . $matches[3][0] . '"' : '';
  return '<link rel="stylesheet" href="' . $matches[2][0] . '"' . $media . '>' . "\n";
}
add_filter('style_loader_tag', 'roots_clean_style_tag');

/**
 * Add and remove body_class() classes
 */
function roots_body_class($classes) {
  // Add post/page slug
  if (is_single() || is_page() && !is_front_page()) {
    $classes[] = basename(get_permalink());
  }

  // Remove unnecessary classes
  $home_id_class = 'page-id-' . get_option('page_on_front');
  $remove_classes = array(
    'page-template-default',
    $home_id_class
  );
  $classes = array_diff($classes, $remove_classes);

  return $classes;
}
add_filter('body_class', 'roots_body_class');

/**
 * Wrap embedded media as suggested by Readability
 *
 * @link https://gist.github.com/965956
 * @link http://www.readability.com/publishers/guidelines#publisher
 */
function roots_embed_wrap($cache, $url, $attr = '', $post_ID = '') {
  return '<div class="entry-content-asset">' . $cache . '</div>';
}
add_filter('embed_oembed_html', 'roots_embed_wrap', 10, 4);

/**
 * Add Bootstrap thumbnail styling to images with captions
 * Use <figure> and <figcaption>
 *
 * @link http://justintadlock.com/archives/2011/07/01/captions-in-wordpress
 */
function roots_caption($output, $attr, $content) {
  if (is_feed()) {
    return $output;
  }

  $defaults = array(
    'id'      => '',
    'align'   => 'alignnone',
    'width'   => '',
    'caption' => ''
  );

  $attr = shortcode_atts($defaults, $attr);

  // If the width is less than 1 or there is no caption, return the content wrapped between the [caption] tags
  if ($attr['width'] < 1 || empty($attr['caption'])) {
    return $content;
  }

  // Set up the attributes for the caption <figure>
  $attributes  = (!empty($attr['id']) ? ' id="' . esc_attr($attr['id']) . '"' : '' );
  $attributes .= ' class="thumbnail wp-caption ' . esc_attr($attr['align']) . '"';
  $attributes .= ' style="width: ' . (esc_attr($attr['width']) + 10) . 'px"';

  $output  = '<figure' . $attributes .'>';
  $output .= do_shortcode($content);
  $output .= '<figcaption class="caption wp-caption-text">' . $attr['caption'] . '</figcaption>';
  $output .= '</figure>';

  return $output;
}
add_filter('img_caption_shortcode', 'roots_caption', 10, 3);

/**
 * Clean up the_excerpt()
 */
function roots_excerpt_length($length) {
  return POST_EXCERPT_LENGTH;
}

function roots_excerpt_more($more) {
  return '&hellip;';
}
add_filter('excerpt_length', 'roots_excerpt_length');
add_filter('excerpt_more', 'roots_excerpt_more');

/**
 * Remove unnecessary self-closing tags
 */
function roots_remove_self_closing_tags($input) {
  return str_replace(' />', '>', $input);
}
add_filter('get_avatar',          'roots_remove_self_closing_tags'); // <img />
add_filter('comment_id_fields',   'roots_remove_self_closing_tags'); // <input />
add_filter('post_thumbnail_html', 'roots_remove_self_closing_tags'); // <img />

/**
 * Don't return the default description in the RSS feed if it hasn't been changed
 */
function roots_remove_default_description($bloginfo) {
  $default_tagline = 'Just another WordPress site';
  return ($bloginfo === $default_tagline) ? '' : $bloginfo;
}
add_filter('get_bloginfo_rss', 'roots_remove_default_description');

/**
 * Redirects search results from /?s=query to /search/query/, converts %20 to +
 *
 * @link http://txfx.net/wordpress-plugins/nice-search/
 */
function roots_nice_search_redirect() {
  global $wp_rewrite;
  if (!isset($wp_rewrite) || !is_object($wp_rewrite) || !$wp_rewrite->using_permalinks()) {
    return;
  }

  $search_base = $wp_rewrite->search_base;
  if (is_search() && !is_admin() && strpos($_SERVER['REQUEST_URI'], "/{$search_base}/") === false) {
    wp_redirect(home_url("/{$search_base}/" . urlencode(get_query_var('s'))));
    exit();
  }
}
if (current_theme_supports('nice-search')) {
  add_action('template_redirect', 'roots_nice_search_redirect');
}

/**
 * Fix for empty search queries redirecting to home page
 *
 * @link http://wordpress.org/support/topic/blank-search-sends-you-to-the-homepage#post-1772565
 * @link http://core.trac.wordpress.org/ticket/11330
 */
function roots_request_filter($query_vars) {
  if (isset($_GET['s']) && empty($_GET['s'])) {
    $query_vars['s'] = ' ';
  }

  return $query_vars;
}
add_filter('request', 'roots_request_filter');

/**
 * Tell WordPress to use searchform.php from the templates/ directory
 */
function roots_get_search_form($form) {
  $form = '';
  locate_template('/templates/searchform.php', true, false);
  return $form;
}
add_filter('get_search_form', 'roots_get_search_form');
