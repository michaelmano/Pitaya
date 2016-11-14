<?php

/* ==========================================================================
 Functions.php - Setup of Wordpress and overrides.
========================================================================== */

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
    if ( strpos( $src, 'ver=' . get_bloginfo( 'version' ) ) )
        $src = remove_query_arg( 'ver', $src );
    return $src;
}
add_filter( 'style_loader_src', 'pitaya_remove_wp_ver_css_js', 9999 );
add_filter( 'script_loader_src', 'pitaya_remove_wp_ver_css_js', 9999 );


function load_styles() {
  wp_register_style('pitaya-theme', get_template_directory_uri() .'/assets/stylesheets/style.css', array(), false, 'all');
  wp_enqueue_style( 'pitaya-theme');
}
add_action('wp_print_styles', 'load_styles');


function pitaya_scripts() {

  wp_deregister_script('jquery');
  wp_register_script('jquery', "http" . ($_SERVER['SERVER_PORT'] == 443 ? "s" : "") . "://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js", false, null);
  wp_enqueue_script('jquery');

	wp_register_script( 'pitaya-functions', get_template_directory_uri() . '/assets/javascripts/site.js', array(), false, true );
	wp_enqueue_script( 'pitaya-functions' );
}
if (!is_admin()) add_action( 'wp_enqueue_scripts', 'pitaya_scripts', 11 );

// REMOVE WP EMOJI
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');

remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );


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
add_action( 'template_redirect', 'pitaya_redirect_attachment_page' );

/*
|--------------------------------------------------------------------------
| Change Login Logo.
|--------------------------------------------------------------------------
|
| Remove the Wordpress logo from the admin page
| and make assets/images/admin-logo.svg
| the default logo.
*/

function pitaya_custom_login_logo() {
  $logoBg = get_stylesheet_directory_uri().'/assets/images/admin-logo.svg';

  echo "
  <style type='text/css'>
  h1 a {
    max-height: '100px';
    background-image: url($logoBg) !important;
    background-size: 100% 100%!important;
    width: auto !important;
    margin: 0 auto !important;
  }
  </style>
  ";
}
add_action('login_head', 'pitaya_custom_login_logo');

/*
|--------------------------------------------------------------------------
| Wordpress Gallery Override.
|--------------------------------------------------------------------------
|
| The functions below will change the layout
| Type of the Wordpress gallery into
| The Masonry layout.
*/

function pitaya_post_gallery($output, $attr) {
    global $post;
    if (isset($attr['orderby'])) {
        $attr['orderby'] = sanitize_sql_orderby($attr['orderby']);
        if (!$attr['orderby'])
            unset($attr['orderby']);
    }
    extract(shortcode_atts(array(
        'order' => 'ASC',
        'orderby' => 'menu_order ID',
        'id' => $post->ID,
        'itemtag' => 'dl',
        'icontag' => 'dt',
        'captiontag' => 'dd',
        'columns' => 3,
        'size' => 'thumbnail',
        'include' => '',
        'exclude' => ''
    ), $attr));
    $id = intval($id);
    if ('RAND' == $order) $orderby = 'none';
    if (!empty($include)) {
        $include = preg_replace('/[^0-9,]+/', '', $include);
        $_attachments = get_posts(array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby));
        $attachments = array();
        foreach ($_attachments as $key => $val) {
            $attachments[$val->ID] = $_attachments[$key];
        }
    }
    if (empty($attachments)) return '';
    $output .= '<div class="macy">' . "\n\t";
    foreach ($attachments as $id => $attachment) {
        $thumb = wp_get_attachment_image_src($id, 'medium_large');
        $img   = wp_get_attachment_image_src($id, 'full');
        $output .= '<div class="macy__child">' . "\n\t\t";
        $output .= '<a href="'. $img[0] .'">' . "\n\t\t\t";
        $output .= '<img src="'. $thumb[0] .'" width="'. $thumb[1] .'" height="'. $thumb[2] .'" alt="" />' . "\n\t\t";
        $output .= '</a>' . "\n\t";
        $output .= '</div>' . "\n\t";
    }
    $output .= '</div>';
    return $output;
}
add_filter('post_gallery', 'pitaya_post_gallery', 10, 2);


/*
|--------------------------------------------------------------------------
| Enque Pitaya Functions.
|--------------------------------------------------------------------------
|
| The required files below are for the
| activation of the theme and also
| the theme settings page.
*/

require_once WP_CONTENT_DIR . '/themes/Pitaya/core/pitaya-settings.php';
require_once WP_CONTENT_DIR . '/themes/Pitaya/core/pitaya-functions.php';
require_once WP_CONTENT_DIR . '/themes/Pitaya/core/pitaya-post-types.php';