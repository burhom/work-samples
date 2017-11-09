<?php
/**
 * Initial setup and constants
 */
function roots_setup() {

  // Register wp_nav_menu() menus (http://codex.wordpress.org/Function_Reference/register_nav_menus)
  register_nav_menus(array(
    'primary_navigation' => __('Primary Navigation', 'roots'),
  ));

  // Add post thumbnails (http://codex.wordpress.org/Post_Thumbnails)
  add_theme_support('post-thumbnails');
  set_post_thumbnail_size(550, 350, true);

  add_image_size('project_thumb', 550, 350, true); // project thumbs
  add_image_size('slide_img', 1200, 800, true); // header graphics

  // Tell the TinyMCE editor to use a custom stylesheet
  add_editor_style('lib/css/editor-style.css');
}
add_action('after_setup_theme', 'roots_setup');

// Backwards compatibility for older than PHP 5.3.0
if (!defined('__DIR__')) { define('__DIR__', dirname(__FILE__)); }

// Define helper constants
$get_theme_name = explode('/themes/', get_template_directory());

define('WP_BASE',                   wp_base_dir());
define('THEME_NAME',                next($get_theme_name));
define('RELATIVE_PLUGIN_PATH',      str_replace(site_url() . '/', '', plugins_url()));
define('FULL_RELATIVE_PLUGIN_PATH', WP_BASE . '/' . RELATIVE_PLUGIN_PATH);
define('RELATIVE_CONTENT_PATH',     str_replace(site_url() . '/', '', content_url()));
define('THEME_PATH',                RELATIVE_CONTENT_PATH . '/themes/' . THEME_NAME);