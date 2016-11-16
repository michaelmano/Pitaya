<footer>
  <div class="container">
    <p class="copyright">&copy; Copyright <?php echo date('Y');?> <span itemprop="name"><?php bloginfo('name'); ?></span>. All Rights Reserved | <a href="https://www.michaelmano.com">Theme Developed by <span>Michael Mano</span></a> for the <a href="https://www.github.com/michaelmano/Pitaya"><span>Pitaya Project</span></a></p>
    <?php pitaya_social_nav([
      'size'  =>  'small',
      'container' =>  'true',
      'float' =>  'right'
    ]); ?>
  </div><!-- END container -->
</footer>
</body>
<?php wp_footer(); ?>
</html>
