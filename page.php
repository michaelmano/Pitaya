<?php get_header(); ?>
<div class="container">
  <div class="content">
    <?php
    if ( have_posts() ) {
      while ( have_posts() ) {
    		the_post();
    		the_content();
    	}
    } ?>
  </div><!-- END content -->
</div><!-- END container -->
<?php get_footer(); ?>
