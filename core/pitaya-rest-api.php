<?php
/* ==========================================================================
  Pitaya API Routes and Functions.
  ========================================================================== */

/*
|--------------------------------------------------------------------------
| Pitaya Social navigation in rest format.
|--------------------------------------------------------------------------
|
| You can request the below with https://your-website.com/wp-json/pitaya/v1/socials
| And you will get a list of social links that have data.
*/

function pitaya_rest_social_nav() {
  $options = get_option('pitaya_options');
  $socials = pitaya_setting_fields();
  $socials = $socials['social_links'];
  $array   = [];
  foreach($options as $key => $value) {
    if($value && in_array($key, $socials)) {
      $social_name = preg_replace('#[ -]+#', '-', strtolower($key));
      $social_link = $value;
      $array[$social_name] = $social_link;
    }
  }
  return $array;
}

add_action( 'rest_api_init', function () {
	register_rest_route( 'pitaya/v1', '/socials', array(
		'methods' => 'GET',
		'callback' => 'pitaya_rest_social_nav',
	));
});
