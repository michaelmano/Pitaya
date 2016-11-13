<?php

/* ==========================================================================
 Pitaya Custom Theme Functions
========================================================================== */

/*
|--------------------------------------------------------------------------
| Shortcodes
|--------------------------------------------------------------------------
|
| The comment structure and description here should be each line Starts
| With a capital letter, even if the sentence Has not Ended, Also
| Notice the indentaiton as each line has less and less
*/


/*
|--------------------------------------------------------------------------
| Social Media links
|--------------------------------------------------------------------------
|
| Add and remove social media links here, They will show in the backend under Theme Settings and you can edit them. When you
| Run the function <?php pitaya_display_social_nav(); ?> if they have a value they will show in a unordered list.
*/

function pitaya_socials() {
  return ['Facebook', 'Twitter', 'YouTube','Instagram','Twitter','LinkedIn','Pinterest','Google Plus+','Tumblr','Flickr','Vine'];
}
/*
|--------------------------------------------------------------------------
| Display Social Navigation. <?php pitaya_display_social_nav(); ?>
|--------------------------------------------------------------------------
|
| The function below checks if the theme options page has any values for the social links and if they are not empty it will
| echo a <ul> then it runs through foreach social link and checks if it has a value, if a value exists it will then
| print it out in a list item with the key being the social name e.g. Facebook, and the value being the link.
*/

function pitaya_social_nav() {
  $output = '';
  ob_start();
  // Content from here on returned to the display_social_nav command
    $options = get_option('pitaya_options');
    $socials = pitaya_socials();
    foreach($options as $key => $value) {
      if($value && in_array($key, $socials)) {
        echo '
        <li class="'. $key .'">
          <a target="_blank" href="'. $value .'">
          <span class="inner">
              <img class="injectSvg" data-src="'. get_template_directory_uri() .'/assets/images/icons/'. strtolower ( $key ) .'.svg" alt="'. $key .'">
            </span>
          </a>
        </li>';
      }
    }
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
