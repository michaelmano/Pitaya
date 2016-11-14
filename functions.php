<?php

/* ==========================================================================
 Functions.php - Setup of Wordpress and overrides.
========================================================================== */

/*
|--------------------------------------------------------------------------
| Enque Stylesheets and javascripts.
|--------------------------------------------------------------------------
|
| The Below functions will enque the
| style.css and the site.js in
| the header and footer.
*/

function load_styles() {
  wp_register_style('pitaya-theme', get_template_directory_uri() .'/style.css', array(), '1.1', 'all');
  wp_enqueue_style( 'pitaya-theme');
}
add_action('wp_print_styles', 'load_styles');


function pitaya_scripts() {
	wp_register_script( 'pitaya-functions', get_template_directory_uri() . '/assets/javascripts/site.js', array(), '0.1.0', true );
	wp_enqueue_script( 'pitaya-functions' );
}
add_action( 'wp_enqueue_scripts', 'pitaya_scripts' );


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