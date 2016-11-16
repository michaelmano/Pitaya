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

function pitaya_create_initial_pages() {

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
     'news'   => 'News',
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
  if (FALSE === get_option('pitaya_activated') && FALSE === update_option('pitaya_activated',FALSE)) add_option('pitaya_activated',TRUE);
}

// Create above pages and menus if the theme has not been activated before.
if (isset($_GET['activated']) && is_admin() && FALSE === get_option('pitaya_activated') && FALSE === update_option('pitaya_activated',FALSE))  {
   add_action('init', 'pitaya_create_initial_pages');
}