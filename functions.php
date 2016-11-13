<?php

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

function pitaya_custom_login_logo() {
  $logoBg = get_stylesheet_directory_uri().'/assets/images/admin-logo.svg';
  $height = '100px';

  echo "
  <style type='text/css'>
  h1 a {
    max-height: $height;
    background-image: url($logoBg) !important;
    background-size: 100% 100%!important;
    width: auto !important;
    margin: 0 auto !important;
  }
  </style>
  ";
}
add_action('login_head', 'pitaya_custom_login_logo');

require_once WP_CONTENT_DIR . '/themes/Pitaya/core/pitaya-settings.php';
require_once WP_CONTENT_DIR . '/themes/Pitaya/core/pitaya-functions.php';
