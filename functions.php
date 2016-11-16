<?php
/* ==========================================================================
 Functions.php - Setup of Wordpress and overrides.
========================================================================== */


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
| Basic Theme Setup
|--------------------------------------------------------------------------
|
| The comment structure and description here should be each line Starts
| With a capital letter, even if the sentence Has not Ended, Also
| Notice the indentaiton as each line has less and less
*/

register_nav_menus([
  'primary' => __(
    'Primary Navigation',
    'Pitaya'
  ),
  'footer' => __(
    'Footer Navigation',
    'Pitaya'
  ),
]);

//removes inline css for galleries
add_filter( 'use_default_gallery_style', '__return_false' );

add_post_type_support('page', 'excerpt');


if (!current_user_can( 'edit_pages')) {
    add_filter('show_admin_bar', '__return_false'); //remove admin bar for all but admins/editors
}

if(!current_user_can('manage_options')){
  add_filter( 'wpseo_use_page_analysis', '__return_false'); //only show for admins
}

add_image_size('thumbnail-wide', 400, 266, true); //.666 ratio
//add_image_size('header-image', 1800, 250, true);
//add_image_size('home-slide', 1800, 400, true);

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

/* Force galleries to link to file and not attachment */
add_shortcode('gallery', 'devsGalleryShortcode');
function devsGalleryShortcode($atts) {
	if(!$atts['link']) {
    	$atts['link'] = 'file';
	}
	if($atts['link'] == 'attachment'){
    	$atts['link'] = 'file';
	}
    return gallery_shortcode($atts);
}

add_action('print_media_templates', function(){ ?>
	<script type="text/html" id="tmpl-custom-gallery-setting">
	    <label class="setting">
	        <span>Gallery Type</span>
	        <select name="type" data-setting="type">
	            <option value="masonry">Masonry</option>
	            <option value="slider">Slider</option>
	        </select>
	    </label>
	</script>

	<script>
	    jQuery(document).ready(function($) {
	        wp.media.view.Settings.Gallery = wp.media.view.Settings.Gallery.extend({
	        	template: function(view){
	          		return wp.media.template('gallery-settings')(view)
	               		+ wp.media.template('custom-gallery-setting')(view);
	        	}
	        });
	    });
	</script>

<?php });

function pitaya_gallery($output, $attr) {
    global $post;
    if (isset($attr['orderby'])) {
      $attr['orderby'] = sanitize_sql_orderby($attr['orderby']);
      if (!$attr['orderby'])
        unset($attr['orderby']);
    }
    extract(shortcode_atts([
      'order' => 'ASC',
      'orderby' => 'menu_order ID',
      'type'  =>  '',
      'id' => $post->ID,
      'itemtag' => 'dl',
      'icontag' => 'dt',
      'captiontag' => 'dd',
      'columns' => 3,
      'size' => 'thumbnail',
      'include' => '',
      'exclude' => ''
    ], $attr));
    if ('RAND' == $order) $orderby = 'none';
    if (!empty($include)) {
      $include = preg_replace('/[^0-9,]+/', '', $include);
      $_attachments = get_posts([
        'include' => $include,
        'post_status' => 'inherit',
        'post_type' => 'attachment',
        'post_mime_type' => 'image',
        'order' => $order,
        'orderby' => $orderby
      ]);
      $attachments = [];
      foreach ($_attachments as $key => $val) {
        $attachments[$val->ID] = $_attachments[$key];
      }
    }
    if (empty($attachments)) return '';
      ob_start(); ?>
      <div class="gallery gallery--<?php if ($attr['type'] === 'slider') { echo 'slider'; } else { echo 'masonry'; } ?>">
      <?php
      foreach ($attachments as $id => $attachment) {
        $thumb = wp_get_attachment_image_src($id, 'medium_large');
        $full   = wp_get_attachment_image_src($id, 'full'); ?>
        <div class="gallery__item">
          <a href="<?php echo $full[0]; ?>">
            <img src="<?php echo $thumb[0]; ?>" alt="" />
          </a>
        </div><!-- END gallery__item -->
      <?php } ?>
    </div><!-- END macy -->
    <?php
    $output = ob_get_contents();
    ob_end_clean();
    return $output;
}
add_filter('post_gallery', 'pitaya_gallery', 10, 2);
