<?php
/* ==========================================================================
 Pitaya Theme Activation.
========================================================================== */

/*
|--------------------------------------------------------------------------
| Page Creation on Activation.
|--------------------------------------------------------------------------
|
| The below function creates the pages listed in the array $pages.
| The array starts with a Page title, Then inside the page
| Title array is the Page Content and Page Template.
*/

function create_initial_pages() {

  // Get value to check if the theme has been activated before.
  $pages = [
   'Home'  => [                   // Page Title
      ''  =>	'front-page.php'    // Page Content and Page Template
    ],
    'Contact' => [               // Page Title
      ''  =>  'page-contact.php' // Page Content and Page Template
    ],
    'News' 		  => [             // Page Title
      ''	=>	''                 // Page Content and Page Template
    ],
  ];

  // Loops through each page in the above array and creates each page if the theme has not been activated before.
  foreach($pages as $page_url_title => $page_meta) {
    $id = get_page_by_title($page_url_title);
    foreach ($page_meta as $page_content=>$page_template){
     $page = [
        'post_type'     => 'page',
        'post_title'    => $page_url_title,
        'post_name'     => $page_url_title,
        'post_status'   => 'publish',
        'post_content'  => $page_content,
        'post_author'   => 1,
        'post_parent'   => ''
      ];
     if(!isset($id->ID)){
        $new_page_id = wp_insert_post($page);
        if(!empty($page_template)){
          update_post_meta($new_page_id, '_wp_page_template', $page_template);
        }
      }
    }
  }

  /*
  |--------------------------------------------------------------------------
  | Set Permalink Structure.
  |--------------------------------------------------------------------------
  |
  | The below function sets the wordpress Front Page, Blog Page
  | And Permalinks and the Permalink Structure to Postname,
  | You can set This to what you like.
  */

  $home = get_page_by_title( 'Home' );
    update_option( 'page_on_front', $home->ID );
    update_option( 'show_on_front', 'page' );
  $blog = get_page_by_title( 'News' );
    update_option( 'page_for_posts', $blog->ID );
  global $wp_rewrite;
  $wp_rewrite->set_permalink_structure('/%postname%/');
  update_option( "rewrite_rules", FALSE );
  $wp_rewrite->flush_rules( true );


  /*
  |--------------------------------------------------------------------------
  | Set Wordpress Menus.
  |--------------------------------------------------------------------------
  |
  | The array and foreach below sets up the wordpress Primary Menu &
  | Each link in the menu. You can Add more links or even another
  | Menu to the array, Make sure that the Page name is correct
  */

  $menus = [
   'Primary'  => [
     '/'      => 'Home',
     'contact'=> 'Contact',
     'news'   => 'news',
   ],
  ];

  foreach($menus as $menuname => $menuitems) {
   $menu_exists = wp_get_nav_menu_object($menuname);
   // If it doesn't exist, let's create it.
   if ( !$menu_exists) {
     $menu_id = wp_create_nav_menu($menuname);
     foreach($menuitems as $slug => $item) {
      wp_update_nav_menu_item($menu_id, 0, [
        'menu-item-title'  => $item,
        'menu-item-object'  => 'page',
        'menu-item-object-id'  => get_page_by_path($slug)->ID,
        'menu-item-type' => 'post_type',
        'menu-item-status'  => 'publish'
      ]);
     }
   }
  }
  // Menu names from functions.php
  $menu_header = get_term_by('name', 'primary', 'nav_menu');
  $menu_header_id = $menu_header->term_id;
  $locations = get_theme_mod('nav_menu_locations');
  $locations['primary'] = $menu_header_id;

  set_theme_mod( 'nav_menu_locations', $locations );
  // Set First Activation
  update_option( get_option('pitaya_options')['First Activation']) , false );
}

// Create above pages and menus if the theme has not been activated before.
if (isset($_GET['activated']) && is_admin() && !get_option('pitaya_options')['First Activation'])) {
   add_action('init', 'create_initial_pages');
}
/*
|--------------------------------------------------------------------------
| Plugin Initiation.
|--------------------------------------------------------------------------
|
| The function below takes any plugins you may have listed in the array and installs them from the source. The Source can be
| the You can reference either bundled plugins or plugins elsewhere on the internet from this parameter. For bundled
| plugins, this should be the path to the .zip file. For external plugins, the direct url to the .zip file.
*/

// add_action( 'tgmpa_register', 'Pitaya_register_required_plugins' );
//
// function Pitaya_register_required_plugins() {
//
//   $plugins = array(
//    array(
//      'name'               => 'Gravityforms',
//      'slug'               => 'gravityforms',
//      'source'             => get_template_directory() . '/functions/plugins/gravityforms.zip',
//      'required'           => true,
//      'version'            => '',
//      'force_activation'   => true,
//      'force_deactivation' => true,
//      'external_url'       => '',
//      'is_callable'        => '',
//    ),
//    array(
//      'name'               => 'Advanced Custom Fields Pro',
//      'slug'               => 'advanced-custom-fields-pro',
//      'source'             => get_template_directory() . '/functions/plugins/advanced-custom-fields-pro.zip',
//      'required'           => true,
//      'version'            => '',
//      'force_activation'   => true,
//      'force_deactivation' => true,
//      'external_url'       => '',
//      'is_callable'        => '',
//    ),
//    array(
//      'name'               => 'Yoast SEO',
//      'slug'               => 'wordpress-seo',
//      'source'             => get_template_directory() . '/functions/plugins/wordpress-seo.zip',
//      'required'           => true,
//      'version'            => '',
//      'force_activation'   => true,
//      'force_deactivation' => true,
//      'external_url'       => '',
//      'is_callable'        => '',
//    )
//   );
//
//   $config = array(
//    'id'           => 'Pitaya',
//    'default_path' => '',
//    'menu'         => 'tgmpa-install-plugins',
//    'parent_slug'  => 'themes.php',
//    'capability'   => 'edit_theme_options',
//    'has_notices'  => true,
//    'dismissable'  => true,
//    'dismiss_msg'  => '',
//    'is_automatic' => false,
//    'message'      => '',
//   );
//   tgmpa( $plugins, $config );
// }


/*
|--------------------------------------------------------------------------
| Add Licence Keys for Gravity Forms and Advanced Custom Fields.
|--------------------------------------------------------------------------
|
| You can set the license keys for Gravity forms, Advanced Custom Fields and any other plugins that allow this, Or
| you can remove this all togeter if you prefer to keep your license keys private and hidden from clients.
| I personally enter them in the below and then remove them after the theme has been activated.
*/

define( 'GF_LICENSE_KEY', '' );

function auto_set_license_keys() {
  if ( ! get_option( 'acf_pro_license' )) {
    $save = array(
   'key'	=> '',
   'url'	=> home_url()
  );
  $save = maybe_serialize($save);
  $save = base64_encode($save);
    update_option( 'acf_pro_license', $save );
  }
}
add_action( 'after_switch_theme', 'auto_set_license_keys' );

/*
|--------------------------------------------------------------------------
| Import Gravity Forms and Advanced Custom Fields.
|--------------------------------------------------------------------------
|
| The definition below imports the gravity forms json file inside of the core/plugins folder and the function creates
| Advanced Custom Fields options pages, The fields for ACF will show in the options page however they will not be
| able to be edited from the backend. You can edit them manually inside of the core/plugins/acf.php file.
*/

define( 'GF_THEME_IMPORT_FILE', '/functions/plugins/import-files/gf-import.json');

if( function_exists('acf_add_options_page') ) {
  // add parent
  $parent = acf_add_options_page([
    'page_title' 	=> 'Theme General Settings',
    'menu_title'	=> 'Theme Settings',
    'menu_slug' 	=> 'theme-general-settings',
    'capability'	=> 'edit_posts',
    'redirect'		=> false
  ]);
  // add sub page
  acf_add_options_sub_page([
    'page_title' 	=> 'Social Settings',
    'menu_title' 	=> 'Social Settings',
    'parent_slug' => $parent['menu_slug'],
  ]);
  acf_add_options_sub_page([
    'page_title' 	=> 'Global Settings',
    'menu_title' 	=> 'Global Settings',
    'parent_slug' => $parent['menu_slug'],
  ]);

}