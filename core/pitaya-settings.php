<?php

/* ==========================================================================
 Pitaya Theme Settings Page.
========================================================================== */


/*
|--------------------------------------------------------------------------
| Pitaya Admin CSS/JS
|--------------------------------------------------------------------------
|
| The Below functions will echo css and js into the header/footer if the
| Page is Theme Settings. The reason for using inline vs a whole new
| File is that there is no reason to make additional http requests
| As they are not that large of a file.
*/

function pitaya_Colorpicker(){
  $screen = get_current_screen();
  if ($screen->id === 'toplevel_page_pitaya') {
    wp_enqueue_style( 'wp-color-picker');
    wp_enqueue_script( 'wp-color-picker');
  }
}
add_action('admin_enqueue_scripts', 'pitaya_Colorpicker');

function pitaya_admin_css() {
  // Check current admin screen.
  $screen = get_current_screen();
  if ($screen->id === 'toplevel_page_pitaya') {
    echo '
    <style>
    .toplevel_page_pitaya fieldset.pitaya_social_row {
      display: inline-block;
      width: 100%;
      padding: 0;
      margin: 0;
    }
    .toplevel_page_pitaya .pitaya_social_row th {
      display: none;
    }
    .toplevel_page_pitaya fieldset.pitaya_social_row input {
      width: 100%;
    }
    .toplevel_page_pitaya tr.pitaya_social_row {
      width: 100%;
    }
    .toplevel_page_pitaya fieldset h4 {
      margin: 5px 0;
    }
    @media screen and (min-width: 640px) {
      .toplevel_page_pitaya fieldset.pitaya_social_row {
        width: 24.5%;
      }
    }
    </style>
    ';
  }
}

add_action('admin_head', 'pitaya_admin_css');

function pitaya_admin_js() {
  $screen = get_current_screen();
  if ($screen->id === 'toplevel_page_pitaya') {
    echo '
      <script>
      jQuery(document).ready(function($){
        $(".color-field").wpColorPicker();
      });
    </script>
    ';
  }
}

add_action('admin_footer', 'pitaya_admin_js');



/*
|--------------------------------------------------------------------------
| Theme Setting Fields
|--------------------------------------------------------------------------
|
| Each of the below socials are an arrayand you can add as many as you would like. I have just grabbed the most popular and left them. The function
| <?php pitaya_display_social_nav(); ?> Will call the navigation however if you wish to call one seperatly or modify the output you can do
| $socials = get_option('pitaya_options', 'socials'); and $socials['Facebook'] to get the value. don't forge to check if is not null.
*/

function pitaya_settings_init() {

  // Register Theme Settings.
  register_setting('pitaya', 'pitaya_options');
  // Add Section for General Settings.
  add_settings_section(
  'pitaya_section_general',
  __('General Settings', 'pitaya'),
  'pitaya_section_general_cb',
  'pitaya'
  );

  add_settings_section(
  'pitaya_section_socials',
  __('Social Media Links', 'pitaya'),
  'pitaya_section_socials_cb',
  'pitaya'
  );

  add_settings_field(
    'pitaya',
    __('Primary Theme Colour', 'pitaya'),
    'pitaya_field_general_cb',
    'pitaya',
    'pitaya_section_general', [
      'first_activation'  => 'First Activation',
      'theme_colour'  => 'Theme Primary Colour',
      'analytics'  => 'Google Analytics Number',
      'google_maps_api'  => 'Google Maps API',
      'class' => 'pitaya_social_row'
    ]
  );


  add_settings_field(
    'pitaya',
    __('Social Media Links', 'pitaya'),
    'pitaya_field_socials_cb',
    'pitaya',
    'pitaya_section_socials', [
      'socials' =>  pitaya_socials(),
      'class' => 'pitaya_social_row'
    ]
  );
}

add_action('admin_init', 'pitaya_settings_init');

function pitaya_section_general_cb($args) { ?>
<?php
}
function pitaya_field_general_cb($args) {
  $options = get_option('pitaya_options');  ?>


  <fieldset class="<?= esc_attr($args['class']); ?>">
    <h4 class="description" id="pitaya_options[<?= esc_attr($args['theme_colour']); ?>]"><?= esc_attr($args['theme_colour']); ?></h4>
    <input
      type="text"
      class="color-field <?= esc_attr($args['class']); ?>"
      name="pitaya_options[<?= esc_attr($args['theme_colour']); ?>]"
      placeholder="<?= esc_attr($args['theme_colour']); ?>"
      value="<?= $options[$args['theme_colour']]; ?>"
      />
  </fieldset>
  <fieldset class="<?= esc_attr($args['class']); ?>">
    <h4 class="description" id="pitaya_options[<?= esc_attr($args['analytics']); ?>]"><?= esc_attr($args['analytics']); ?></h4>
    <input
      type="text"
      class="<?= esc_attr($args['class']); ?>"
      name="pitaya_options[<?= esc_attr($args['analytics']); ?>]"
      placeholder="e.g. UA-36045025-1"
      value="<?= $options[$args['analytics']]; ?>"
      />
  </fieldset>
  <fieldset class="<?= esc_attr($args['class']); ?>">
    <h4 class="description" id="pitaya_options[<?= esc_attr($args['google_maps_api']); ?>]"><?= esc_attr($args['google_maps_api']); ?></h4>
    <input
      type="text"
      class="<?= esc_attr($args['class']); ?>"
      name="pitaya_options[<?= esc_attr($args['google_maps_api']); ?>]"
      placeholder="e.g. UA-36045025-1"
      value="<?= $options[$args['google_maps_api']]; ?>"
      />
  </fieldset>
<?php
}

function pitaya_section_socials_cb($args) { ?>
<?php
}
function pitaya_field_socials_cb($args) {
  $options = get_option('pitaya_options'); ?>
  <?php foreach($args['socials'] as $arg) { ?>
    <fieldset class="<?= esc_attr($args['class']); ?>">
      <h4 class="description" id="pitaya_options[<?= esc_attr($arg); ?>]"><?= esc_attr($arg); ?></h4>
      <input
        type="text"
        class="<?= esc_attr($arg); ?>"
        name="pitaya_options[<?= esc_attr($arg); ?>]"
        placeholder="e.g. http://www.<?= esc_attr(strtolower($arg)); ?>.com/user.name"
        value="<?= $options[$arg]; ?>"
        />
    </fieldset>
  <?php }
}

function pitaya_options_page() {
// add top level menu page
  add_menu_page(
    'Pitaya Theme Settings.',
    'Theme Settings',
    'manage_options',
    'pitaya',
    'pitaya_options_page_html'
  );
}

add_action('admin_menu', 'pitaya_options_page');

function pitaya_options_page_html() {
// check user capabilities
  if (!current_user_can('manage_options')) {
    return;
  }

  // add error/update messages

  // check if the user have submitted the settings
  // wordpress will add the "settings-updated" $_GET parameter to the url
  if (isset($_GET['settings-updated'])) {
  // add settings saved message with the class of "updated"
    add_settings_error('pitaya_messages', 'pitaya_message', __('Settings Saved', 'pitaya'), 'updated');
  }
  // show error/update messages
  settings_errors('pitaya_messages');
  ?>
  <div class="wrap">
  <h1><?= esc_html(get_admin_page_title()); ?></h1>
  <form action="options.php" method="post">
  <?php
  // output security fields for the registered setting "pitaya"
  settings_fields('pitaya');
  // output setting sections and their fields
  // (sections are registered for "pitaya", each field is registered to a specific section)
  do_settings_sections('pitaya');
  // output save settings button
  submit_button('Save Settings');
  ?>
  </form>
  </div>
  <?php
  }