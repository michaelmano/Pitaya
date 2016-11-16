<?php
/*
 * Template Name: Contact Page
 * Description: Contact Page
 */
get_header(); ?>
<?php while(have_posts()) : the_post(); ?>
<?php the_content(); ?>
<?php endwhile; ?>
<?php get_footer(); ?>