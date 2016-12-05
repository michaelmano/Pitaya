<?php
$carousels = get_posts([
  'posts_per_page' => 20,
  'post_type' => 'carousel',
  'meta_key' => '_thumbnail_id',
  'tax_query' => array(
    array(
      'taxonomy' => 'carousel-category',
      'field' => 'slug',
      'terms' => $post->post_name
    )
  )
]);
if(count($carousels) > 0)
{ ?>
  <div class="carousel">
  <?php
  $count = 0;
  foreach ($carousels as $carousel)
  {
    $count++;
    $carousel_image = wp_get_attachment_image_src(get_post_thumbnail_id($carousel->ID), 'carousel'); ?>
    <div class="carousel__item carousel__item--<?php echo $count; ?>">
      <?php $carousel_link = get_post_meta($carousel->ID, 'carousel_link', true);
      if($carousel_link) { echo '<a href="'. $carousel_link .'">'; } ?>
      <img src="<?php echo $carousel_image[0]; ?>" alt="<?php echo $carousel->post_title; ?>"/>
      <div class="carousel__content">
        <h2><?php echo $carousel->post_title; ?></h2>
        <?php echo apply_filters('the_content', get_post_meta($carousel->ID, 'carousel_content', true)); ?>
      </div><!-- END carousel__content -->
      <?php if($carousel_link) { echo '</a>'; } ?>
    </div><!--END carousel__item -->
  <?php } ?>
  </div><!-- END carousel -->
<?php } ?>
