<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title><?php wp_title( '|', true, 'right' ); ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="<?php wp_title( '|', true, 'right' ); ?>">
  <?php wp_head(); ?>
  <?php get_template_part('includes/favicons'); ?>
  <div class="sprite">
    <?php include(locate_template('assets/images/icons/sprite.svg')); ?>
  </div><!-- END sprite -->

  <!--[if lt IE 9]>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script>
  <![endif]-->

<?php pitaya_google_analytics(); ?>
</head>
<body>

<header>
  <div class="container">
    <div class="logo">
      <a href="<?php echo esc_url( home_url( '/' ) ); ?>" alt="<?php echo get_bloginfo('name'); ?>">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo.svg" alt="<?php echo get_bloginfo('name'); ?>">
      </a>
    </div><!-- END logo -->
    <nav class="navigation">
      <div class="nav-toggle">
        <div class="nav-toggle__icon">
          <svg class="icon--bars"><use xlink:href="#bars"></use></svg>
          <svg class="icon--close"><use xlink:href="#close"></use></svg>
        </div><!-- END icon icon--large -->
      </div><!-- END nav-toggle -->
    <ul class="navigation__primary">
      <?php wp_nav_menu([
        'theme_location' => 'primary',
        'container' => false,
        'items_wrap' => '%3$s',
        'depth' => 3,
      ]);
      pitaya_social_nav([
        'size'  =>  'small',
        'float' =>  'right'
      ]);
      ?>
    </ul>
    </nav>
  </div><!-- END container -->
</header>
