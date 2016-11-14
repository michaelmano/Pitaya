<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title><?php wp_title( '|', true, 'right' ); ?></title>
  <meta name="description" content="<?php wp_title( '|', true, 'right' ); ?>">
  <?php pitaya_favicons(); ?>
  <?php wp_head(); ?>
  <!--[if lt IE 9]>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script>
  <![endif]-->
  <?php pitaya_google_analytics(); ?>
</head>
<body>