<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title><?php wp_title( '|', true, 'right' ); ?></title>
  <meta name="description" content="<?php wp_title( '|', true, 'right' ); ?>">
  <?php
  wp_head();
  pitaya_favicons();
  pitaya_google_analytics(); ?>
  <div class="sprite hidden">
    <?php echo include_once(''. get_template_directory_uri() .'/assets/images/icons/sprite.svg'); ?>
  </div><!-- END sprite -->
  <!--[if lt IE 9]>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script>
  <![endif]-->
</head>
<body>

<header>
  <div class="container">
    <nav class="navigation navigation--primary">
    <ul>
      <?php wp_nav_menu([
        'theme_location' => 'primary',
        'container' => false,
        'items_wrap' => '%3$s',
        'depth' => 3,
      ]);
      pitaya_social_nav([
        'container' => 'false',
        'size'  =>  'small',
      ]); ?>
    </ul>
    </nav>
  </div><!-- END container -->
</header>