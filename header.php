<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title><?php wp_title( '|', true, 'right' ); ?></title>
  <meta name="description" content="<?php wp_title( '|', true, 'right' ); ?>">
  <?php wp_head(); ?>

  <?php include(locate_template('includes/favicons.php')); ?>
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
      <svg xmlns="http://www.w3.org/2000/svg" height="110" viewBox="0 0 255 110" width="255">
        <g clip-rule="evenodd" fill-rule="evenodd">
          <path fill="#991d60" d="M130 73.2c4.3-4.75 8.47-9.35 13.1-14.4 3.22 3.4 6.03 6.36 8.89 9.38 2.86-6.23-.884-16.5-8.23-21.6-10.2-7-22.8-8.36-35 4.16-3.19-3.56-6.35-7.08-9.92-11.1 10-10.6 19.9-21 29.9-31.7 10.2 10.6 20 20.9 30.3 31.7l6.88-7.19c12.8 15 13.3 49.4-15 65-7-8-14-15.9-21-24.3z"/>
          <path fill="#ee466a" d="M102 72.6c4.3 5.68 8.32 11 12.6 16.7-.27.352-1.03 1.41-1.86 2.39-6.12 7.23-6.13 7.22-13.3 1.04-.125-.108-.25-.22-.373-.33-8.3-7.38-8.29-7.37-.845-15.4 1.5-1.6 2.5-3.3 3.5-4.4z"/>
        </g>
        <g clip-rule="evenodd" fill-rule="evenodd">
          <path fill="none" d="M118 88c-11 .63-21.8 1.24-32.7 1.86-1.08-18.9-2.15-37.8-3.24-56.8l32.7-1.86c0 18.8 2 37.8 3 56.8zm-2-24.8c-3.65-5.32-6.93-10.1-10.2-14.9-3.37-4.88-6.77-9.76-10.2-14.8-12 15.4-14.6 40.4-5.64 54.2 8.4-8.1 16.8-16.1 25.8-24.5z"/>
          <path fill="#acd035" d="M111 51.3c-7.37 9.78-14.4 19.2-21.6 28.6-11.3-12.1-12.9-37.2-3.7-54.4 4.26 4.34 8.43 8.57 12.6 12.8 3.7 4.2 7.7 8.4 12.7 13z"/>
        </g>
      </svg>
    </div><!-- END logo -->
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
