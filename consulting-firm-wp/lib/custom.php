<?php

// Custom functions


/**
 * Customize Adjacent Post Link Order
 */
function wpse73190_gist_adjacent_post_where($sql) {
  if ( !is_main_query() || !is_singular() )
    return $sql;

  $the_post = get_post( get_the_ID() );
  $patterns = array();
  $patterns[] = '/post_date/';
  $patterns[] = '/\'[0-9]{4}-[0-9]{2}-[0-9]{2} [0-9]{2}:[0-9]{2}:[0-9]{2}\'/';
  $replacements = array();
  $replacements[] = 'menu_order';
  $replacements[] = $the_post->menu_order;
  return preg_replace( $patterns, $replacements, $sql );
}
add_filter( 'get_next_post_where', 'wpse73190_gist_adjacent_post_where' );
add_filter( 'get_previous_post_where', 'wpse73190_gist_adjacent_post_where' );

function wpse73190_gist_adjacent_post_sort($sql) {
  if ( !is_main_query() || !is_singular() )
    return $sql;

  $pattern = '/post_date/';
  $replacement = 'menu_order';
  return preg_replace( $pattern, $replacement, $sql );
}
add_filter( 'get_next_post_sort', 'wpse73190_gist_adjacent_post_sort' );
add_filter( 'get_previous_post_sort', 'wpse73190_gist_adjacent_post_sort' );


/*  ------------------------------ */
/*  Custom Client Colors
/*  ------------------------------ */
function client_theme() {
  echo '<link rel="stylesheet" type="text/css" href="' .get_template_directory_uri() . '/lib/css/client-theme.css">';
}

add_action('admin_head', 'client_theme');



/*  ------------------------------ */
/*  Collect theme options
/*  ------------------------------ */
function roots_get_global_options(){

  $roots_option = array();

  $roots_option   = get_option('roots_options');

  return $roots_option;
}

 /**
 * Call the function and collect in variable
 *
 * Should be used in template files like this:
 * <?php echo $wptuts_option['wptuts_txt_input']; ?>
 *
 * Note: Should you notice that the variable ($wptuts_option) is empty when used in certain templates such as header.php, sidebar.php and footer.php
 * you will need to call the function (copy the line below and paste it) at the top of those documents (within php tags)!
 */
 $roots_option = roots_get_global_options();


 /* ------------------------------ */
/*  Google Analytics
/*  ------------------------------ */

function roots_google_analytics() {

  $roots_option = roots_get_global_options();
  $google_analytics = $roots_option['roots_ga'];

  if ($google_analytics) {
    echo "\n\t<script>\n";
    echo "\t\tvar _gaq=[['_setAccount','$google_analytics'],['_trackPageview']];\n";
    echo "\t\t(function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];\n";
      echo "\t\tg.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';\n";
      echo "\t\ts.parentNode.insertBefore(g,s)}(document,'script'));\n";
echo "\t</script>\n";
}
}

add_action('wp_footer', 'roots_google_analytics', 100);


/*  ------------------------------ */
/*  Add admin menu separators
/*  ------------------------------ */

// Registers admin menu separators
add_action('admin_menu','admin_menu_separator');

/**
 * Create Admin Menu Separator
 **/
function add_admin_menu_separator($position) {

  global $menu;
  $index = 0;

  foreach($menu as $offset => $section) {
    if (substr($section[2],0,9)=='separator')
      $index++;
    if ($offset>=$position) {
      $menu[$position] = array('','read',"separator{$index}",'','wp-menu-separator');
      break;
    }
  }

  ksort( $menu );
}

/**
 * Adds Admin Menu Separators
 **/
function admin_menu_separator() {

  add_admin_menu_separator(15);
  add_admin_menu_separator(19);
  add_admin_menu_separator(49);
  add_admin_menu_separator(53);
  add_admin_menu_separator(54);
}


/*  ------------------------------ */
/*  Custom Dashboard Widgets
/*  ------------------------------ */

//add documentation to dashboard
function documentation() {
  
  echo '<div class="wrapper">';
  echo '<h2>Pages</h2>';
  echo '<p>To edit your pages select the "Pages" link from the sidebar, or click <a href="edit.php?post_type=page">Here</a>.</p>';
  echo '<p>Hover over the page you\'d like to edit and a small list of links will appear. Click "Edit" to begin editing that page</p>';
  
  echo '<hr style="width:30px;margin:10px 0;border-bottom:none;border-top:1px solid #ccc;" />';
  echo '<h4 style="font-weight:bold;">Editing Pages</h4>';
  echo '<p>When editing a page you may want to edit the page Name/Title, the url it will exist at and the page content.</p>';
  echo '<p><strong>1) Page Title:</strong> The first field will be the page Name/Title as you\'d like it to appear on screen.</p>';
  echo '<p>Directly underneath this field you will see a preview of the "permalink." This is the url that this page can be reached at. You can change it by selecting the "edit" button. When you do, a small input field will appear with the current page url for you to edit. Make sure you use all lowercase letters and use dashes ("-") in place of spaces.</p>';
  echo '<p style="padding:10px;font-size:11px;background:#eee;"><i><strong>Note:</strong> Generally, WordPress will convert your page name to a friendly url. If you are editing it yourself, be sure to pick something relevant and short.</i></p>';
  echo '<p><strong>2) Page Content:</strong> Below this will be the WYSIWYG editor (stands for What You See Is What You Get). This is where you\'ll enter your page content. There are two views you can toggle between, "Visual" and "Text." You should stay in the Visual editor when possible.</p>';
  echo '<p>While editing there are a number of buttons you can select to change the style of your text. We recommend only using the following:</p>';
  echo '<ul style="list-style:initial;padding-left:30px;">';
  echo '<li>bold</li>';
  echo '<li>italic</li>';
  echo '<li>underline/strikethrough</li>';
  echo '<li>Blockquote (use for taglines)</li>';
  echo '<li>Heading 3 (from the dropdown)</li>';
  echo '<li>alignment (only when necessary, try to stick to the default, left-align)</li>';
  echo '</ul>';
  echo '<p style="padding:10px;font-size:11px;background:#eee;"><i><strong>Note:</strong> If you can\'t see a particular option, the last button in the first row (should look like a keyboard) will toggle the extra options.</i></p>';
  echo '<p><strong>3)</strong> When you are done editing your pages content and/or name, select the blue button labeled "Update" from the sidebar on the right of the edit screen (it is at the top, in a box labeled "Publish"). </p>';
  
  echo '<hr style="width:30px;margin:10px 0;border-bottom:none;border-top:1px solid #ccc;" />';
  echo '<h4 style="font-weight:bold;">Editing Footer Text</h4>';
  echo '<p>To edit the phone number and email listed in the footer of your website, simply edit the "Home" page and you will see 2 fields where you can change the phone number and email that will be listed.</p>';
  echo '<p>Once done editing, press the blue "Update" button at the top, right of the edit screen. It is in the box labeled "Publish."</p>';
  echo '<hr style="width:30px;margin:10px 0;border-bottom:none;border-top:1px solid #ccc;" />';
  echo '<p style="padding:10px;font-size:11px;background:#eee;"><i><strong>Note:</strong> You do not need to edit the "Projects" page as it automatically displays the Projects for you. This is being handled by setting the "Template" under the box labeled "Page Attributes" to "Display Projects."</i></p>';

  echo '<hr style="margin:35px 0 20px;border:1px solid #666;" />';

  echo '<h2>Projects</h2>';
  echo '<p>To edit an existing Project, navigate to the "Projects" link from the sidebar and select "All Projects" (or <a href="edit.php?post_type=project">click here</a>), and hover over the project you want to edit. A small list of links will appear, hit the one titled "Edit."</p>';
  echo 'To add a new project, navigate to the "Projects" link from the sidebar and select "Add New" (or <a href="post-new.php?post_type=project">click here</a>)</p>';
  
  echo '<hr style="width:30px;margin:10px 0;border-bottom:none;border-top:1px solid #ccc;" />';
  echo '<h4 style="font-weight:bold;">Creating/Editing a Project</h4>';
  echo '<p>When creating or editing a project, you\'ll have a number of fields that you will need to edit so that it is listed properly.</p>';
  echo '<p><strong>1) Project Title:</strong> The first thing you\'re going to want to do is enter the project title. This should be the Address as you\'d like it to appear visually.</p>';
  echo '<p style="padding:10px;font-size:11px;background:#eee;"><i><strong>Note:</strong> You only need to write the first line of the address, as "Washington, DC" will automatically be added to the thumb overlay.</i></p>';
  echo '<p><strong>2) Project Content:</strong> Next, you will see another WYSIWYG editor, similar to the one you saw when editing your pages. This will be the content that appears for your Project listing. Follow the same instructions for using the WYSIWYG editor as you do when editing your pages.</p>';
  echo '<p><strong>3) Gallery Images:</strong> Below the WYSIWYG editor is a space for you to add your images for the project. These are the images that will appear in a slider gallery when viewing the individual Project.</p>';
  echo '<p>To add an image, select the blue button labeled "Add Image." When you do this, a screen will appear prompting you to add an image to the Gallery. You will see two tabs labeled "Upload Files" and "Media Library."</p>';
  echo '<p style="padding-left:2em;">(a) Your media library is all of the files you\'ve uploaded to your website. You can quickly select one of those and hit "Select" in the bottom right-hand corner.</p>';
  echo '<p style="padding-left:2em;">(b) You may also select the tab labeled "Upload Files" to add new images from your computer. You may select more than one image at a time as well. Once uploaded the images should have a checkbox around them indicating you would like to add them to the gallery. Click the blue "Select" button to add them to the gallery.</p>';
  echo '<p>You can also change the order in which you want your images to appear in the slider simply by dragging the thumbnails in the box to reorder them.</p>';
  echo '<p style="padding:10px;font-size:11px;background:#eee;"><i><strong>Note:</strong> Please be sure the images you are uploading are no bigger than <strong>1400px</strong> wide by <strong>1000px</strong> tall and are set to <strong>72dpi</strong> (sometimes images from a camera are set to 300dpi, which is necessary for print, but not the web).</i></p>';
  echo '<p><strong>4) Project Order:</strong> To change the order in which your projects appear on the project page, you\'ll need to set the "Order" attribute. You can do this 1 of 2 ways:</p>';
  echo '<p style="padding-left:2em;">(a) When editing a project, the far right column has a box labeled "Attributes" (located directly below the blue "Update" button). There will be a field labeled "Order." Here you should set a number that correlates to the order you want the project to appear. The projects will list out in order from lowest to highest.</p>';
  echo '<p style="padding-left:2em;">(b) You can also edit the sort order on the fly, directly from the <a href="edit.php?post_type=project">All Projects</a> page. Just like when you want to edit an existing Project, and you hover over to reveal a list of links, instead of clicking "Edit," click "Quick Edit." A small box will appear where you can change things on the fly. Look for the field (on the right) labeled "Order" and make whatever changes necessary. Hit the Blue "Update" button to save.</p>';
  echo '<p><strong>5) Map Link:</strong> To have a link to google maps appear on a Project listing, all you have to do is enter a URL in the box labeled "Map Link" while editing a project. It\'s located on the right-hand side, below the "Attributes" box where you set the sort order.</p>';
  echo '<p style="padding:10px;font-size:11px;background:#eee;"><i><strong>Note:</strong> To get a Google Maps link, go to <a href="http://maps.google.com">maps.google.com</a> and enter the desired address. Once you\'ve got a pin on the map where you\'d like, there will be a small Cog wheel in the bottom, right-hand corner of the screen. Click it to reveal a menu. Select "Share and embed map." A small window will appear with a link. Feel free to check the box for "short URL" for a more friendly url. Copy and paste this URL into the box on the edit screen for your project and hit "Update."</i></p>';
  echo '<p><strong>6) Thumbnail:</strong> The last thing you\'ll want to be sure to do, is set a thumbnail for your project. This is the image that appears for the project when viewing the all of the projects. (Note: This image will not appear in the gallery).</p>';
  echo '<p>To set the thumbnail, navigate to the right-hand column on the edit screen. The very last box labeled "Featured Image" will have a link titled "Set featured image." Select this to bring up a window similar to when you are adding gallery images. Follow the same steps here as you do for gallery images to upload your thumbnail (Note: follow the same specs for the image size as you do for gallery images).</p>';

  echo '<hr style="margin:35px 0 20px;border:1px solid #666;" />';

  echo '<h2>Navigation</h2>';
  echo '<p>To change the order of the pages in the navigation of your website, go to the "Pages" link in the sidebar and select "Navigation Menu." (or <a href="nav-menus.php">click here</a>).</p>';
  echo '<p>From here you will see an Edit screen for the Menu Structure. On the left-hand side will be a list of available pages. You can select one by checking the checkbox to the left of the page title and then hitting the button labeled "Add to Menu."</p>';
  echo '<p>The Navigation items will appear on the right-hand side, in a vertical list. To change the order, simply drag and drop them in the order you want (Note: be sure they all line up vertically, as we do not support child pages).</p>';
  echo '<p>Once you are done, simply hit the blue button labeled "Save Menu."</p>';

  echo '<hr style="margin:35px 0 20px;border:1px solid #666;" />';
  
  echo '<h2>Shortcodes</h2>';
  echo '<h4 style="font-weight:bold;">Columns</h4>';
  echo '<p>For pages, you have the ability to seperate content out into columns if desired, in order to do this you will need to wrap your text in what are known as shortcodes. They are user-friendly tags that allow WordPress to manipulate your text. To start, whatever text you want to split into columns, you\'ll need to first wrap it all in the <code>[row]</code> shortcode. To do this just write <code>[row]</code> at the beginning of your text, and <code>[/row]</code> at the end of your text.</p>';
  echo '<p>From here, you can start creating your columns with your text. For this we use the <code>[col]</code> shortcode. It has some options that you can use to change the widths and positioning of the columns.</p>';
  echo '<p>The <code>[col]</code> shortcode has the options of "width" and "offset." You will use a number between 1-12 to set the width along the page. You can create any number of combinations of columns as long as each add up to 12.</p>';
  echo '<p>For example: <code>[col width="6"]</code>your column content<code>[/col]</code> will create a column that takes up half the page. You could use two of these to create a two column grid.</p>';
  
  echo '<hr style="width:30px;margin:10px 0;border-bottom:none;border-top:1px solid #ccc;" />';
  echo '<h4 style="font-weight:bold;">Divider Lines</h4>';
  echo '<p>You can also add small divider lines as a visual cue and/or flair. You have two options, one that is flush left, and one that is flush right.</p>';
  echo '<p>The shortcode for these are: <code>[hr_left]</code> and <code>[hr_right]</code>.</p>';
  echo '<p style="padding:10px;font-size:11px;background:#eee;"><i><strong>Note:</strong> You do not need to wrap these with text, or close them. Just place it anywhere you\'d like one to appear.</i></p>';

  echo '<hr style="margin:35px 0 20px;border:1px solid #666;" />';

  echo '<h2>Site Settings</h2>';
  echo '<p>If you\'d like to add Google Analytics to your website, simply navigate to the "Site Settings" link (or <a href="admin.php?page=roots-options">click here</a>)in the sidebar and enter your Google Analytics ID# into the field and hit the blue button labeled "Save Changes."</p>';

  echo '<hr style="margin:35px 0 20px;border:1px solid #666;" />';

  echo '<h2>User Settings</h2>';
  echo '<p>If you\'d like to change your password or email associated with your account, simply navigate to the "Profile" link in the sidebar (or <a href="profile.php">click here</a>) and edit the fields you\'d like to update, then click the blue button labeled "Update Profile."';

  echo '<hr style="margin:35px 0 20px;border:1px solid #666;" />';

  echo '<h2>SEO Settings</h2>';
  echo '<p>Each Project and Page has basic SEO fields to help you determine how you\'d like to appear in Search Results (ie. Google).</p>';
  echo '<p>The SEO fields are located in the right-hand column on the edit screens for both Projects and Pages in a box labeled "SEO." You have two fields "Description" and "Keywords." For the description, enter a short sentence or two describing the page. Be sure to include some important keywords in your description. This is what appears below the link in search results.</p>';
  echo '<p>They Keywords field, while obsolete now with Google, may still be useful to fill out, but not necessary. For example you could write something like: "dila, dc development, dc construction, dila development"</p>';

  echo '<hr style="margin:35px 0 20px;border:1px solid #666;" />';

  echo '<h2>Other Notes</h2>';
  echo '<p>We <strong>strongly</strong> encourage you to keep the WordPress core up-to-date.</p>';
  echo '<p>While your site doesn\'t <i>require</i> any plugins to update, we have installed a backup plugin that will save weekly backups of your database data to /backups in your uploads folder.</p>';

  echo '</div>';
}

//function to add widgets to the dash

function add_custom_widgets() {
  wp_add_dashboard_widget('documentation_widget', 'Documentation', 'documentation');  
}

add_action('wp_dashboard_setup', 'add_custom_widgets' );