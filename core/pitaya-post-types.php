<?php
/* ==========================================================================
 Custom Post Types
========================================================================== */

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
  if(get_post_type($post->ID) === 'page') {

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
}


function pitaya_save_sidebar_meta($post_id){
  if(get_post_type($post_id) === 'page') {
    update_post_meta( $post_id, 'enable_sidebar', $_POST['enable_sidebar']);
    if($post->post_parent) update_post_meta( $post_id, 'hide_from_menu', $_POST['hide_from_menu']);
  }
}

add_action( 'save_post'     , 'pitaya_save_sidebar_meta');
add_action( 'add_meta_boxes', 'pitaya_add_sidebar_meta' );


/*
|--------------------------------------------------------------------------
| Carousel Custom Post Type With Post Meta
|--------------------------------------------------------------------------
|
| The Functions below will add a custom post type for the Carousel and also some post
| Meta which can be used for content inside of the carousel. Then we also add some
| Carousel categories so we can add carousels to more than just the front page.
*/


function pitaya_custom_post_carousel() {
	$labels = array(
		'name' => _x('Carousel', 'post type general name'),
		'singular_name' => _x('Carousel', 'post type singular name'),
		'add_new' => _x('Add New', 'Carousel'),
		'add_new_item' => __('Add New Carousel'),
		'edit_item' => __('Edit Carousel'),
		'new_item' => __('New Carousel'),
		'all_items' => __('All Carousel'),
		'view_item' => __('View Carousel'),
		'search_items' => __('Search Carousel'),
		'not_found' => __('No Carousel found'),
		'not_found_in_trash' => __('No Carousel found in the Trash'),
		'parent_item_colon' => '',
		'menu_name' => 'Carousel'
	);
	$args = array(
		'labels' => $labels,
		'description' => 'Holds Carousel specific data',
		'menu_position' => 30,
    'show_in_rest'  => true,
    'rest_controller_class' => 'WP_REST_Posts_Controller',
		'supports' => array('title', 'thumbnail'),
		'menu_icon' => 'dashicons-images-alt',
		'public' => true,
		'has_archive' => false,
		'exclude_from_search' => true,
		'publicly_queryable' => false,
		'query_var' => false,
	);
	register_post_type('carousel', $args);
}
add_action('init', 'pitaya_custom_post_carousel');

function pitaya_taxonomies_carousel() {
	$labels = array(
		'name' => _x('Carousel Categories', 'taxonomy general name'),
		'singular_name' => _x('Carousel Category', 'taxonomy singular name'),
		'search_items' => __('Search Carousel Categories'),
		'all_items' => __('All Carousel Categories'),
		'parent_item' => __('Parent Carousel Category'),
		'parent_item_colon' => __('Parent Carousel Category:'),
		'edit_item' => __('Edit Carousel Category'),
		'update_item' => __('Update Carousel Category'),
		'add_new_item' => __('Add New Carousel Category'),
		'new_item_name' => __('New Carousel Category'),
		'menu_name' => __('Carousel Categories'),
	);
	$args = array(
		'labels' => $labels,
		'hierarchical' => true,
		'rewrite' => array('slug' => 'carousel-category'),
	);
	register_taxonomy('carousel-category', 'carousel', $args);
}
add_action('init', 'pitaya_taxonomies_carousel', 0);

function pitaya_add_custom_post_carousel_meta() {
  add_meta_box('pitaya_custom_post_carousel_meta','Carousel Details', 'pitaya_add_custom_post_carousel_meta_callback', 'carousel', 'normal', 'high');
}

function pitaya_add_custom_post_carousel_meta_callback( $post ) {
  global $post;
  if(get_post_type($post->ID) === 'carousel') {

    $prefix = 'carousel_';
    $args = [
      $prefix . 'content'  =>  get_post_meta( $post->ID, $prefix . 'content', true ),
      $prefix . 'link'     =>  get_post_meta( $post->ID, $prefix . 'link', true )
    ];

    foreach ($args as $key => $value) { ?>
      <label for="<?php echo $key; ?>"><?php echo ucwords ( str_replace('_', ' ', $key)); ?></label><br />
      <input type="text" style="margin:0 16px 0 0; width: 100%;" name="<?php echo $key; ?>" value="<?php if($value) { echo $value; } ?>"/>
  <?php
    }
  }
}

function pitaya_save_custom_post_carousel_meta($post_id){
  if(get_post_type($post_id) === 'carousel') {
    $prefix = 'carousel_';
    update_post_meta( $post_id, $prefix . 'content', $_POST[$prefix . 'content']);
    update_post_meta( $post_id, $prefix . 'link', $_POST[$prefix . 'link']);
  }
}

add_action('add_meta_boxes', 'pitaya_add_custom_post_carousel_meta');
add_action('save_post', 'pitaya_save_custom_post_carousel_meta');
