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
