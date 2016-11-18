<?php
/* ==========================================================================
 Pitaya Custom Theme Functions
========================================================================== */

/*
|--------------------------------------------------------------------------
| Social Navigation. <?php pitaya_social_nav($args); ?>
|--------------------------------------------------------------------------
|
| This function has arguments suchs as size, float and container. Below is an example to display the navigation
| With a container, floating to the right (inline-block) and small icons. The container field is in case
| You wish to display the list items inside of another menus list. The boolian is a string.
*/

// pitaya_social_nav([
//   'size'      =>  'small',
//   'container' =>  'true',
//   'float'     =>  'right'
// ]);

function pitaya_social_nav($args) {

  $output = '';
  ob_start();
  // Content from here on returned to the display_social_nav command
    $options = get_option('pitaya_options');
    $socials = pitaya_setting_fields();
    $socials = $socials['social_links'];
    ?>
    <ul class="socials <?php if($args['float']) { echo 'socials--'. $args['float'] . '';} ?> <?php if($args['size']) { echo 'socials--'. $args['size'] . ''; } elseif (!isset($args['size'])) { echo 'socials__small'; }?>">
    <?php foreach($options as $key => $value) {
      if($value && in_array($key, $socials)) {
        $name = preg_replace('#[ -]+#', '-', strtolower($key)); ?>
        <li class="socials__<?php echo $name; ?>">
          <a target="_blank" href="<?php echo $value; ?>" class="icon icon--medium">
            <svg><use xlink:href="#<?php echo $name; ?>"></use></svg>
          </a>
        </li>
      <?php }
    } ?>
    </ul><!-- END Socials -->
  <?php
  // End of content return
  $output = ob_get_contents();
  ob_end_clean();
  if($output) {
    echo $output;
  }
}

/*
|--------------------------------------------------------------------------
| Google Analytics
|--------------------------------------------------------------------------
|
| Displays the google analytics code if the field is filled in from the settings area.
*/

function pitaya_google_analytics() {
  $output = '';
  ob_start();
  $options     = get_option('pitaya_options');
  $google_code = $options['Google Analytics Number'];

  if($google_code):
    echo '
    <!-- Google Analytics -->
    <script>
    window.ga=window.ga||function(){(ga.q=ga.q||[]).push(arguments)};ga.l=+new Date;
    ga("create", "'. $google_code .'", "auto");
    ga("send", "pageview");
    </script>
    <script async src="https://www.google-analytics.com/analytics.js"></script>
    <!-- End Google Analytics -->';
  endif;

  $output = ob_get_contents();
  ob_end_clean();
  if($output) {
    echo $output;
  }
}

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
  $logoBg = get_stylesheet_directory_uri().'/assets/images/logo.svg';

  echo "
  <style type='text/css'>
  #login h1 a, .login h1 a {
    position: relative;
    background-image: none;
    margin: 0;
    height: 96px;
    width: 100%;
  }
  .login h1 a:before {
    content: '';
    position: absolute;
    top: 50%; right: 50%;
    margin-top: -48px;
    margin-right: -48px;
    width: 96px;
    height: 96px;
    background: url($logoBg) 50% 50% no-repeat;
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
add_shortcode('gallery', 'pitaya_gallery_shortcode');
function pitaya_gallery_shortcode($atts) {
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

/*
|--------------------------------------------------------------------------
| Add Post Meta to all pages
|--------------------------------------------------------------------------
|
| The Below function will add a post meta box to all pages that has a checkbox
| That will enable or disable the sidebar instead of having multiple page
| Templates I find this to be the cleanest way of doing things.
*/


function pitaya_add_sidebar_meta() {
  add_meta_box('featured_checkbox_id','Pitaya Functions', 'pitaya_sidebar_meta_callback', 'page', 'side', 'high');
}

function pitaya_sidebar_meta_callback( $post ) {
	global $post;
  $args = [
    'enable_sidebar'  =>  get_post_meta( $post->ID, 'enable_sidebar', true )
  ];

  if($post->post_parent) $args['hide_from_menu'] = get_post_meta( $post->ID, 'hide_from_menu' , true );

  foreach ($args as $key => $value) { ?>
    <input type="checkbox" style="margin:0 16px 0 0;" name="<?php echo $key; ?>" value="true" <?php echo (($value=='true') ? 'checked="checked"': '');?>/>
    <label for="<?php echo $key; ?>"><?php echo ucwords ( str_replace('_', ' ', $key)); ?></label><br />
<?php
  }
}


function pitaya_save_sidebar_meta($post_id){
  update_post_meta( $post_id, 'enable_sidebar', $_POST['enable_sidebar']);
	update_post_meta( $post_id, 'hide_from_menu', $_POST['hide_from_menu']);
}

add_action( 'save_post'     , 'pitaya_save_sidebar_meta');
add_action( 'add_meta_boxes', 'pitaya_add_sidebar_meta' );
