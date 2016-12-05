<?php get_header(); ?>
  <div class="container">
    <div class="content content--sidebar">
    <?php if(have_posts()) : ?>
    <h1><?php the_title(); ?></h1>
    <?php while(have_posts()) : the_post(); ?>
      <?php get_template_part('post','meta'); ?>
      <?php if(has_post_thumbnail()) { ?>
        <?php the_post_thumbnail('article-featured', array('class' => 'article--thumbnail')); ?>
      <?php } ?>
        <p><?php the_content(); ?></p>
      <?php endwhile; ?>
    <?php endif; /* post loop */ ?>
    </div><!-- END content -->
  <?php get_sidebar('blog'); ?>
  </div><!-- END container -->
<?php get_footer(); ?>
