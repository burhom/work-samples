<?php

// Custom post types


/*--------------------------*/
/*  Projects
/*--------------------------*/

function project_title( $title ){
  $screen = get_current_screen();

  if  ( 'project' == $screen->post_type ) {
    $title = 'Enter Property Address';
  }

  return $title;
}

add_filter( 'enter_title_here', 'project_title' ); //filters title

//Menus Section
add_action( 'init', 'project' );
function project() {
  $labels = array(
    'name' => _x('Projects', 'post type general name'),
    'singular_name' => _x('Project', 'post type singular name'),
    'add_new' => _x('Add New', 'project'),
    'add_new_item' => __('Add New Project'),
    'edit_item' => __('Edit Project'),
    'new_item' => __('New Project'),
    'all_items' => __('All Projects'),
    'view_item' => __('View Project'),
    'search_items' => __('Search Projects'),
    'not_found' =>  __('No Projects, womp womp.'),
    'not_found_in_trash' => __('No Projects found in Trash'),
    'parent_item_colon' => '',
    'menu_name' => 'Projects'

    );
  $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true,
    'show_in_menu' => true,
    'show_in_nav_menus' => true,
    'query_var' => true,
    'rewrite' => true,
    'capability_type' => 'post',
    'has_archive' => true,
    'hierarchical' => true,
    'menu_position' => 52,
    'menu_icon' => 'dashicons-location',
    'supports' => array( 'title', 'editor', 'thumbnail', 'page-attributes' )
    );
  register_post_type('project',$args);
}


//add filter to ensure the menu is displayed when user updates a menu
add_filter( 'post_updated_messages', 'codex_project_updated_messages' );
function codex_project_updated_messages( $messages ) {
  global $post, $post_ID;

  $messages['project'] = array(
  0 => '', // Unused. Messages start at index 1.
  1 => sprintf( __('Project updated.'), esc_url( get_permalink($post_ID) ) ),
  2 => __('Custom field updated.'),
  3 => __('Custom field deleted.'),
  4 => __('Project updated.'),
  /* translators: %s: date and time of the revision */
  5 => isset($_GET['revision']) ? sprintf( __('Project restored to revision from %s'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
  6 => sprintf( __('Project added.'), esc_url( get_permalink($post_ID) ) ),
  7 => __('Project saved.'),
  8 => sprintf( __('Project submitted.'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
  9 => sprintf( __('Project scheduled for: <strong>%1$s</strong>.'),
  // translators: Publish box date format, see http://php.net/date
    date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
  10 => sprintf( __('Project draft updated.'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
  );

return $messages;
}

//display contextual help for Projects
add_action( 'contextual_help', 'codex_add_help_text', 10, 3 );

function codex_add_help_text( $contextual_help, $screen_id, $screen ) {
  //$contextual_help .= var_dump( $screen ); // use this to help determine $screen->id
  if ( 'project' == $screen->id ) {
    $contextual_help =
    '<p>' . __('Things to remember when adding or editing a Project:') . '</p>' .
    '<ul>' .
    '<li>' . __('Give it a short and sweet title.') . '</li>' .
    '</ul>' .
    '<p>' . __('If you want to schedule the Project to be published in the future:') . '</p>' .
    '<ul>' .
    '<li>' . __('Under the Publish module, click on the Edit link next to Publish.') . '</li>' .
    '<li>' . __('Change the date to a future date to publish this Project, then click on OK.') . '</li>' .
    '</ul>' .
    '<p><strong>' . __('For more information:') . '</strong></p>' .
    '<p>' . __('<a href="mailto:burhom@outlook.com" target="_blank">Email Me</a>') . '</p>' ;
  }
  return $contextual_help;
}
