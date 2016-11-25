<?php get_header(); ?>

  <div class="container">
    <div class="content content--sidebar">
      <?php if(have_posts()) : ?>
        <h1><?php echo get_option('pitaya_options')['Blog Page Title']; ?></h1>
        <div class="grid">
        <?php while(have_posts()) : the_post(); ?>
          <div id="post-<?php the_ID(); ?>" class="1/2--xs-up grid__item article">
            <?php get_template_part('post','meta'); ?>
            <?php if(has_post_thumbnail()) { ?>
              <?php the_post_thumbnail('article-featured', array('class' => 'article--thumbnail')); ?>
            <?php } ?>
            <h2 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
            <p><?php echo wp_trim_words( get_the_content(), 50 ); ?></p>
            <a href="<?php the_permalink(); ?>" class="button no-mb">Continue reading</a>
          </div><!-- END 1/2--xs-up grid__item -->
      <?php endwhile; ?>

      <?php global $wp_query; if ( $wp_query->max_num_pages > 1 ) : ?>

        <div class="grid__item">

          <?php
          global $wp_query;
          $big = 999999999;
          echo paginate_links([
            'base'    => str_replace( $big, '%#%', get_pagenum_link( $big ) ),
            'format'  => '?paged=%#%',
            'current' => max( 1, get_query_var('paged') ),
            'total'   => $wp_query->max_num_pages
          ]);
          ?>

        </div><!-- END grid__item -->

    <?php endif; /* pagination */ ?>

    </div><!-- END grid -->

    <?php endif; /* post loop */ ?>
    </div><!-- END content -->
    <?php get_sidebar('blog'); ?>
  </div><!-- END container -->
<?php get_footer(); ?>
