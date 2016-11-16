<?php

/* ==========================================================================
 Pitaya Theme Settings Page.
========================================================================== */

/*
|--------------------------------------------------------------------------
| Fields and Settings
|--------------------------------------------------------------------------
|
| Below is the fields and settings inside of the fields in a simple to edit array.
| Just add to the array or make a new one to create more settings options.
*/

function pitaya_setting_fields() {
  return [
    'theme_settings'  => ['Theme Primary Colour', 'Google Analytics Number', 'Google Maps API'],
    'contact_details' => ['Address', 'Phone', 'Email'],
    'social_links'    => ['Facebook', 'Twitter', 'YouTube','Instagram','LinkedIn','Pinterest','Google Plus','Tumblr','Flickr','Vine', 'Github']
  ];
}


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
    .toplevel_page_pitaya fieldset.pitaya_settings_row {
      display: inline-block;
      width: 100%;
      padding: 0;
      margin: 0;
    }
    .toplevel_page_pitaya .pitaya_settings_row th {
      display: none;
    }
    .toplevel_page_pitaya fieldset.pitaya_settings_row input {
      width: 100%;
    }
    .toplevel_page_pitaya tr.pitaya_settings_row {
      width: 100%;
    }
    .toplevel_page_pitaya fieldset h4 {
      margin: 5px 0;
    }
    @media screen and (min-width: 640px) {
      .toplevel_page_pitaya fieldset.pitaya_settings_row {
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
        $("input.theme-primary-colour").wpColorPicker();
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


  $fields = pitaya_setting_fields();

  foreach ($fields as $key => $value) {

    $title = ucwords(str_replace("_", " ", $key));

    add_settings_section(
    'pitaya_section_'. $key .'',
    __($title, 'pitaya'),
    'pitaya_section_'. $key .'_cb',
    'pitaya'
    );

    add_settings_field(
      'pitaya',
      __($title, 'pitaya'),
      'pitaya_field_'. $key .'_cb',
      'pitaya',
      'pitaya_section_'. $key .'', [
        ''. $key .'' =>  $value,
        'class' => 'pitaya_settings_row'
      ]
    );
  }

}

add_action('admin_init', 'pitaya_settings_init');


function pitaya_section_theme_settings_cb($args) { ?>
<?php
}
function pitaya_field_theme_settings_cb($args) {
  $options = get_option('pitaya_options'); ?>
  <?php foreach($args['theme_settings'] as $arg) {
    $raw = preg_replace('#[ -]+#', '-', $arg);
    $class = strtolower($raw);
    ?>
    <fieldset class="<?= esc_attr($class); ?> <?= esc_attr($args['class']); ?>">
      <h4 class="description" id="pitaya_options[<?= esc_attr($arg); ?>]"><?= esc_attr($arg); ?></h4>
      <input
        type="text"
        class="<?= esc_attr($class); ?>"
        name="pitaya_options[<?= esc_attr($arg); ?>]"
        value="<?= $options[$arg]; ?>"
        />
    </fieldset>
  <?php }
}



function pitaya_section_contact_details_cb($args) { ?>
<?php
}
function pitaya_field_contact_details_cb($args) {
  $options = get_option('pitaya_options'); ?>
  <?php foreach($args['contact_details'] as $arg) {
    $raw = preg_replace('#[ -]+#', '-', $arg);
    $class = strtolower($raw);
    ?>
    <fieldset class="<?= esc_attr($class); ?> <?= esc_attr($args['class']); ?>">
      <h4 class="description" id="pitaya_options[<?= esc_attr($arg); ?>]"><?= esc_attr($arg); ?></h4>
      <input
        type="text"
        class="<?= esc_attr($class); ?>"
        name="pitaya_options[<?= esc_attr($arg); ?>]"
        value="<?= $options[$arg]; ?>"
        />
    </fieldset>
  <?php }
}



function pitaya_section_social_links_cb($args) { ?>
<?php
}
function pitaya_field_social_links_cb($args) {
  $options = get_option('pitaya_options'); ?>
  <?php foreach($args['social_links'] as $arg) {
    $raw = preg_replace('#[ -]+#', '-', $arg);
    $class = strtolower($raw);
    ?>
    <fieldset class="<?= esc_attr($class); ?> <?= esc_attr($args['class']); ?>">
      <h4 class="description" id="pitaya_options[<?= esc_attr($arg); ?>]"><?= esc_attr($arg); ?></h4>
      <input
        type="text"
        class="<?= esc_attr($class); ?>"
        name="pitaya_options[<?= esc_attr($arg); ?>]"
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