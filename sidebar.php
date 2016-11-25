<div class="sidebar">
  <?php if(is_home() || is_single() || is_archive() || is_category()) { ?>
    <section class="categories">
      <h2>Categories</h2>
      <ul class="list list--links">
      <?php
      $categories = get_categories([
        'orderby' => 'name',
        'order'   => 'ASC'
      ]);
      foreach($categories as $cat) { ?>
        <li><a href="<?php echo get_category_link($cat->term_id); ?>"><?php echo $cat->name; ?></a></li>
      <?php } ?>
      <ul>
    </section>
  <?php } ?>
</div><!-- END sidebar -->
