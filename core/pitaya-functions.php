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
    <?php if($args['container'] === 'true' || !isset($args['container']) ) { ?>
      <ul class="socials <?php if($args['float']) { echo 'socials--'. $args['float'] . '';} ?>">
    <?php } ?>
    <?php foreach($options as $key => $value) {
      if($value && in_array($key, $socials)) {
        $name = preg_replace('#[ -]+#', '-', strtolower($key)); ?>
        <li class="social-list-item socials__<?php echo $name; ?> <?php if($args['size']) { echo 'socials__'. $args['size'] . ''; } elseif (!isset($args['size'])) { echo 'socials__small'; }?>">
          <a target="_blank" href="<?php echo $value; ?>" class="icon icon--medium">
            <svg><use xlink:href="#<?php echo $name; ?>"></use></svg>
          </a>
        </li>
      <?php }
    } ?>
  <?php if($args['container'] === 'true' || !isset($args['container'])) { ?>
    </ul><!-- END Socials -->
  <?php }
  // End of content return
  $output = ob_get_contents();
  ob_end_clean();
  if($output) {
    echo $output;
  }
}

/*
|--------------------------------------------------------------------------
| Display Favicons. <?php pitaya_display_favicons(); ?>
|--------------------------------------------------------------------------
|
| This function will output all of the favicon sizes listed below. Please visit http://www.favicomatic.com/ and upload your
| favicon.png make sure the min size is 310 x 310 and you have "Every damn size, sir!" selected, Once you have downloaded
| the zip they will provide put the favicons in the folder assets/images/favicons and overwright the existing ones.
*/

function pitaya_favicons() {
  $output = '';
  ob_start();
  $options = get_option('pitaya_options');
  $primary_colour = $options['Theme Primary Colour'];
  // Content from here on returned to the display_social_nav command
  echo '
  <link rel="apple-touch-icon-precomposed" sizes="57x57" href="'. get_template_directory_uri() .'/assets/images/favicons/apple-touch-icon-57x57.png" />
  <link rel="apple-touch-icon-precomposed" sizes="114x114" href="'. get_template_directory_uri() .'/assets/images/favicons/apple-touch-icon-114x114.png" />
  <link rel="apple-touch-icon-precomposed" sizes="72x72" href="'. get_template_directory_uri() .'/assets/images/favicons/apple-touch-icon-72x72.png" />
  <link rel="apple-touch-icon-precomposed" sizes="144x144" href="'. get_template_directory_uri() .'/assets/images/favicons/apple-touch-icon-144x144.png" />
  <link rel="apple-touch-icon-precomposed" sizes="60x60" href="'. get_template_directory_uri() .'/assets/images/favicons/apple-touch-icon-60x60.png" />
  <link rel="apple-touch-icon-precomposed" sizes="120x120" href="'. get_template_directory_uri() .'/assets/images/favicons/apple-touch-icon-120x120.png" />
  <link rel="apple-touch-icon-precomposed" sizes="76x76" href="'. get_template_directory_uri() .'/assets/images/favicons/apple-touch-icon-76x76.png" />
  <link rel="apple-touch-icon-precomposed" sizes="152x152" href="'. get_template_directory_uri() .'/assets/images/favicons/apple-touch-icon-152x152.png" />
  <link rel="icon" type="image/png" href="'. get_template_directory_uri() .'/assets/images/favicons/favicon-196x196.png" sizes="196x196" />
  <link rel="icon" type="image/png" href="'. get_template_directory_uri() .'/assets/images/favicons/favicon-96x96.png" sizes="96x96" />
  <link rel="icon" type="image/png" href="'. get_template_directory_uri() .'/assets/images/favicons/favicon-32x32.png" sizes="32x32" />
  <link rel="icon" type="image/png" href="'. get_template_directory_uri() .'/assets/images/favicons/favicon-16x16.png" sizes="16x16" />
  <link rel="icon" type="image/png" href="'. get_template_directory_uri() .'/assets/images/favicons/favicon-128.png" sizes="128x128" />
  <meta name="application-name" content="&nbsp;"/>
  <meta name="theme-color" content="'.(($primary_colour)?''. $primary_colour .'':'#991d60').'">
  <meta name="msapplication-TileColor" content="'.(($primary_colour)?''. $primary_colour .'':'#991d60').'" />
  <meta name="msapplication-TileImage" content="'. get_template_directory_uri() .'/assets/images/favicons/mstile-144x144.png" />
  <meta name="msapplication-square70x70logo" content="'. get_template_directory_uri() .'/assets/images/favicons/mstile-70x70.png" />
  <meta name="msapplication-square150x150logo" content="'. get_template_directory_uri() .'/assets/images/favicons/mstile-150x150.png" />
  <meta name="msapplication-wide310x150logo" content="'. get_template_directory_uri() .'/assets/images/favicons/mstile-310x150.png" />
  <meta name="msapplication-square310x310logo" content="'. get_template_directory_uri() .'/assets/images/favicons/mstile-310x310.png" />
  ';
  // End of content return
  $output = ob_get_contents();
  ob_end_clean();
  if($output) {
    echo $output;
  }
}
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
	$sidebar_enabled = get_post_meta( $post->ID, 'sidebar_enabled', true );
?>
	<input type="checkbox" style="margin:0 16px 0 0;" name="sidebar_enabled" value="true" <?php echo (($sidebar_enabled=='true') ? 'checked="checked"': '');?>/><label for="sidebar_enabled">Enable Sidebar</span>
<?php
}


function pitaya_save_sidebar_meta($post_id){
	update_post_meta( $post_id, 'sidebar_enabled', $_POST['sidebar_enabled']);
}

add_action( 'save_post'     , 'pitaya_save_sidebar_meta');
add_action( 'add_meta_boxes', 'pitaya_add_sidebar_meta' );