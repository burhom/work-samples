<?php
/**
 * Roots includes
 */
require_once locate_template('/lib/utils.php');           // Utility functions
require_once locate_template('/lib/init.php');            // Initial theme setup and constants
require_once locate_template('/lib/wrapper.php');         // Theme wrapper class
require_once locate_template('/lib/config.php');          // Configuration
require_once locate_template('/lib/activation.php');      // Theme activation
require_once locate_template('/lib/titles.php');          // Page titles
require_once locate_template('/lib/cleanup.php');         // Cleanup
require_once locate_template('/lib/nav.php');             // Custom nav modifications
require_once locate_template('/lib/comments.php');        // Custom comments modifications
require_once locate_template('/lib/relative-urls.php');   // Root relative URLs
require_once locate_template('/lib/htaccess.php');        // Rewrites for assets, H5BP .htaccess
require_once locate_template('/lib/widgets.php');         // Sidebars and widgets
require_once locate_template('/lib/scripts.php');         // Scripts and stylesheets
require_once locate_template('/lib/post-types.php');      // Custom post types
require_once locate_template('/lib/login.php');           // Custom login screen
require_once locate_template('/lib/custom.php');          // Custom functions


if(is_admin()){
  require_once locate_template('/lib/options.php');       // Theme options
}

//include ACF
if ( current_user_can('edit_themes') == false) {
  define('ACF_LITE', true);
}
require_once locate_template('/lib/acf/acf.php');

//include ACF add-ons
if (!class_exists('acf_field_gallery')) {
  require_once locate_template('/lib/add-ons/acf-gallery/acf-gallery.php');

}
if (!class_exists('acf_field_repeater')) {
  require_once locate_template('/lib/add-ons/acf-repeater/acf-repeater.php');
}

//register ACF fields
if(function_exists("register_field_group"))
{

// ========== SEO Meta Tags ========== //
  register_field_group(array (
    'id' => 'acf_seo',
    'title' => 'SEO',
    'fields' => array (
      array (
        'key' => 'field_535765da57f3c',
        'label' => 'Description',
        'name' => 'seo_desc',
        'type' => 'textarea',
        'instructions' => 'Enter the description here that you\'d like to show up in Search Results for this page/post.',
        'default_value' => '',
        'placeholder' => '',
        'maxlength' => 155,
        'formatting' => 'none',
      ),
      array (
        'key' => 'field_5357662557f3d',
        'label' => 'Keywords',
        'name' => 'seo_keywords',
        'type' => 'text',
        'instructions' => 'Enter up to 15 words or phrases separated by a comma.',
        'default_value' => '',
        'placeholder' => '',
        'prepend' => '',
        'append' => '',
        'formatting' => 'none',
        'maxlength' => '',
      ),
    ),
    'location' => array (
      array (
        array (
          'param' => 'post_type',
          'operator' => '==',
          'value' => 'page',
          'order_no' => 0,
          'group_no' => 0,
        ),
      ),
      array (
        array (
          'param' => 'post_type',
          'operator' => '==',
          'value' => 'post',
          'order_no' => 0,
          'group_no' => 1,
        ),
      ),
      array (
        array (
          'param' => 'post_type',
          'operator' => '==',
          'value' => 'project',
          'order_no' => 0,
          'group_no' => 2,
        ),
      ),
    ),
    'options' => array (
      'position' => 'side',
      'layout' => 'default',
      'hide_on_screen' => array (
        0 => 'custom_fields',
        1 => 'discussion',
        2 => 'comments',
        3 => 'author',
        4 => 'format',
        5 => 'tags',
        6 => 'send-trackbacks',
      ),
    ),
    'menu_order' => 2,
  ));

// ========== Project Gallery & Map Link ========== //
  register_field_group(array (
    'id' => 'acf_image-slider',
    'title' => 'Image Slider',
    'fields' => array (
      array (
        'key' => 'field_53cd9541a390e',
        'label' => 'Slides',
        'name' => 'image_slider',
        'type' => 'gallery',
        'preview_size' => 'thumbnail',
        'library' => 'all',
      ),
    ),
    'location' => array (
      array (
        array (
          'param' => 'post_type',
          'operator' => '==',
          'value' => 'project',
          'order_no' => 0,
          'group_no' => 0,
        ),
      ),
    ),
    'options' => array (
      'position' => 'normal',
      'layout' => 'no_box',
      'hide_on_screen' => array (
      ),
    ),
    'menu_order' => 0,
  ));
  register_field_group(array (
    'id' => 'acf_map-link',
    'title' => 'Map Link',
    'fields' => array (
      array (
        'key' => 'field_53cd9ec28a382',
        'label' => 'URL',
        'name' => 'map_url',
        'type' => 'text',
        'default_value' => '',
        'placeholder' => '',
        'prepend' => '',
        'append' => '',
        'formatting' => 'none',
        'maxlength' => '',
      ),
    ),
    'location' => array (
      array (
        array (
          'param' => 'post_type',
          'operator' => '==',
          'value' => 'project',
          'order_no' => 0,
          'group_no' => 0,
        ),
      ),
    ),
    'options' => array (
      'position' => 'side',
      'layout' => 'default',
      'hide_on_screen' => array (
      ),
    ),
    'menu_order' => 0,
  ));
  register_field_group(array (
    'id' => 'acf_project-address',
    'title' => 'Project Address',
    'fields' => array (
      array (
        'key' => 'field_53da4afaaca71',
        'label' => 'Address 2',
        'name' => 'address_2',
        'type' => 'text',
        'default_value' => 'Washington, DC',
        'placeholder' => '',
        'prepend' => '',
        'append' => '',
        'formatting' => 'none',
        'maxlength' => '',
      ),
    ),
    'location' => array (
      array (
        array (
          'param' => 'post_type',
          'operator' => '==',
          'value' => 'project',
          'order_no' => 0,
          'group_no' => 0,
        ),
      ),
    ),
    'options' => array (
      'position' => 'acf_after_title',
      'layout' => 'no_box',
      'hide_on_screen' => array (
      ),
    ),
    'menu_order' => 0,
  ));

// ========== Global Settings ========== //
  register_field_group(array (
    'id' => 'acf_global-settings',
    'title' => 'Global Settings',
    'fields' => array (
      array (
        'key' => 'field_53cda8caf2f88',
        'label' => 'Footer Phone Number',
        'name' => 'footer_phone',
        'type' => 'text',
        'default_value' => '',
        'placeholder' => '',
        'prepend' => '',
        'append' => '',
        'formatting' => 'none',
        'maxlength' => '',
      ),
      array (
        'key' => 'field_53cda8b5f2f87',
        'label' => 'Footer Email',
        'name' => 'footer_email',
        'type' => 'text',
        'default_value' => '',
        'placeholder' => '',
        'prepend' => '',
        'append' => '',
        'formatting' => 'none',
        'maxlength' => '',
      ),
    ),
    'location' => array (
      array (
        array (
          'param' => 'page_type',
          'operator' => '==',
          'value' => 'front_page',
          'order_no' => 0,
          'group_no' => 0,
        ),
      ),
    ),
    'options' => array (
      'position' => 'acf_after_title',
      'layout' => 'default',
      'hide_on_screen' => array (
        0 => 'permalink',
        1 => 'the_content',
        2 => 'excerpt',
        3 => 'custom_fields',
        4 => 'discussion',
        5 => 'comments',
        6 => 'revisions',
        7 => 'slug',
        8 => 'author',
        9 => 'format',
        10 => 'featured_image',
        11 => 'categories',
        12 => 'tags',
        13 => 'send-trackbacks',
      ),
    ),
    'menu_order' => 0,
  ));
}