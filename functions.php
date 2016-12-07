<?php
/* ==========================================================================
 Functions.php
========================================================================== */

// Add support for custom styles in WordPress editor
add_editor_style();

// Add default content width
if ( ! !empty( $content_width ) ) $content_width = 640;

/*
|--------------------------------------------------------------------------
| Enque Stylesheets and javascripts.
|--------------------------------------------------------------------------
|
| The Below functions will remove version numbers from static css/js files
| As this can cause caching issues, it will also enque the sites
| CSS and JS files and remove the wordpress emojis.
*/


function pitaya_remove_wp_ver_css_js( $src ) {
  if ( strpos( $src, 'ver=' . get_bloginfo('version') ) )
    $src = remove_query_arg('ver', $src );
  return $src;
}
add_filter('style_loader_src', 'pitaya_remove_wp_ver_css_js', 9999 );
add_filter('script_loader_src', 'pitaya_remove_wp_ver_css_js', 9999 );


function load_styles() {
  wp_register_style('pitaya-theme', get_template_directory_uri() .'/assets/stylesheets/style.css', array(), false, 'all');
  wp_enqueue_style('pitaya-theme');
}
add_action('wp_print_styles', 'load_styles');


function pitaya_scripts() {
  wp_deregister_script('jquery');
  wp_register_script('jquery', "http" . ($_SERVER['SERVER_PORT'] == 443 ? "s" : "") . "://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js", false, null);
  wp_enqueue_script('jquery');
	wp_register_script('pitaya-functions', get_template_directory_uri() . '/assets/javascripts/site.js', array(), false, true );
	wp_enqueue_script('pitaya-functions' );
}
if (!is_admin()) add_action('wp_enqueue_scripts', 'pitaya_scripts', 11 );

// REMOVE WP EMOJI
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');
remove_action('admin_print_scripts', 'print_emoji_detection_script' );
remove_action('admin_print_styles', 'print_emoji_styles' );

/*
|--------------------------------------------------------------------------
| Basic Theme Setup
|--------------------------------------------------------------------------
|
| The comment structure and description here should be each line Starts
| With a capital letter, even if the sentence Has not Ended, Also
| Notice the indentaiton as each line has less and less
*/

// Add support for WordPress custom menus
add_action( 'init', 'register_my_menu' );

// Register areas for custom menus
function register_my_menu() {
	register_nav_menu( 'primary', __( 'Primary Navigation' ) );
	register_nav_menu( 'secondary', __( 'Secondary Navigation' ) );
}

//removes inline css for galleries
add_filter('use_default_gallery_style', '__return_false' );

add_post_type_support('page', 'excerpt');

if (!current_user_can('edit_pages')) {
    add_filter('show_admin_bar', '__return_false'); //remove admin bar for all but admins/editors
}

if(!current_user_can('manage_options')){
  add_filter('wpseo_use_page_analysis', '__return_false'); //only show for admins
}

if ( function_exists( 'add_image_size' ) ) add_theme_support( 'post-thumbnails' );
if ( function_exists( 'add_image_size' ) ) {
  add_image_size( 'gallery-thumb', 300, 999999 , false);
  add_image_size( 'article-featured', 640, 300, true );
  add_image_size( 'list-thumb', 382, 204, true );
  add_image_size( 'carousel', 1920, 600, true );
}

// Remove width and height dimensions from uploaded images

add_filter( 'get_image_tag', 'remove_width_and_height_attribute', 10 );
add_filter( 'post_thumbnail_html', 'remove_width_and_height_attribute', 10 );
add_filter( 'image_send_to_editor', 'remove_width_and_height_attribute', 10 );

function remove_width_and_height_attribute( $html ) {
   return preg_replace( '/(height|width)="\d*"\s/', "", $html );
}


/*
|--------------------------------------------------------------------------
| Redirect Attachment Pages.
|--------------------------------------------------------------------------
|
| This function will redirect anyone trying to visit
| an attachment page, This may be a search
| engine spider or an accidental link.
*/

function pitaya_redirect_attachment_page() {
	if ( is_attachment() ) {
		global $post;
		if ( $post && $post->post_parent ) {
			wp_redirect( esc_url( get_permalink( $post->post_parent ) ), 301 );
			exit;
		} else {
			wp_redirect( esc_url( home_url( '/' ) ), 301 );
			exit;
		}
	}
}
add_action('template_redirect', 'pitaya_redirect_attachment_page' );



/*
|--------------------------------------------------------------------------
| Enque Pitaya Functions.
|--------------------------------------------------------------------------
|
| The required files below are for the
| activation of the theme and also
| the theme settings page.
*/
require_once(dirname(__FILE__) . '/core/pitaya-activation.php');
require_once(dirname(__FILE__) . '/core/pitaya-menu.php');
require_once(dirname(__FILE__) . '/core/pitaya-settings.php');
require_once(dirname(__FILE__) . '/core/pitaya-functions.php');
require_once(dirname(__FILE__) . '/core/pitaya-post-types.php');
require_once(dirname(__FILE__) . '/core/pitaya-rest-api.php');
