<?php
get_header();
get_template_part( 'includes/carousel' );
?>
<div class="container">
  <div class="content">
    <div class="grid">
      <div class="1/2--xs-up grid__cell">
        <h3>Code quality</h3>
        <h4>BEM CSS naming structure.</h4>
        <p>But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account of the system, and expound the actual teachings of the great explorer of the truth, the master-builder of human happiness.</p>
        <h4>Infinitely nestable</h4>
        <p>To take a trivial example, which of us ever undertakes laborious physical exercise, except to obtain some advantage from it?</p>
      </div><!-- END grid__cell -->
      <div class="1/2--xs-up grid__cell">
        <h3>Responsive</h3>
        <h4>Real-world breakpoints</h4>
        <p>No one rejects, dislikes, or avoids pleasure itself, because it is pleasure, but because those who do not know how to pursue pleasure rationally encounter consequences that are extremely painful.</p>
        <h4>Add or remove breakpoints with one line of code</h4>
        <p>Nor again is there anyone who loves or pursues or desires to obtain pain of itself, because it is pain, but because occasionally circumstances occur in which toil and pain can procure him some great pleasure.</p>
      </p>
    </div><!-- END grid__cell -->
    </div><!-- END grid -->
    <div class="grid">
      <div class="1/3--xs-up grid__cell">
        <h4>No floats</h4>
        <p>But who has any right to find fault with a man who chooses to enjoy a pleasure that has no annoying consequences, or one who avoids a pain that produces no resultant pleasure?</p>
      </div><!-- END grid__cell -->
      <div class="1/3--xs-up grid__cell">
        <h4>Efficient CSS selectors</h4>
        <p>But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account of the system, and expound the actual teachings of the great explorer of the truth, the master-builder of human happiness.</p>
      </div><!-- END grid__cell -->
      <div class="1/3--xs-up grid__cell">
        <h4>Real-world breakpoints</h4>
        <p>On the other hand, we denounce with righteous indignation and dislike men who are so beguiled and demoralized by the charms of pleasure of the moment, so blinded by desire, that they cannot foresee</p>
      </div><!-- END grid__cell -->
    </div><!-- END grid -->
    <h3>Great Minimalistic Masonry, Pure Javascript without jQuery.</h3>
    <svg viewBox="0 0 100 100" class="icon icon--medium">
      <use xlink:href="#bug"></use>
    </svg>

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
