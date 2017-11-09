<?php
/**
 * Register shortcodes
 */

//hr left
function hr_left_func( $atts ) {

  $hr = '<hr class="left" />';
            
   return $hr;
}
add_shortcode( 'hr_left', 'hr_left_func' );


//hr right
function hr_right_func( $atts ) {

  $hr = '<hr class="right" />';
            
   return $hr;
}
add_shortcode( 'hr_right', 'hr_right_func' );


//TWBS row shortcode
function row_func( $atts, $content = null ) {

  $row = '<div class="row">'.do_shortcode($content).'</div>';
            
   return $row;
}
add_shortcode( 'row', 'row_func' );


//create columns shortcode
function column_func( $atts, $content = null ) {

  extract( shortcode_atts( array(
    'width' => '6',
    'offset' => null,
  ), $atts ) );
  
  $column = '<div class="col-md-'.esc_attr($width).($offset !== null ? ' col-md-offset-'.esc_attr($offset) : '').'">'.do_shortcode($content).'</div>';
  
  return $column;
}
add_shortcode( 'col', 'column_func' );