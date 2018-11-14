<?php
/**
 * The template for displaying the footer.
 * @package Blogger Hub
 */
?>
    <div  id="footer" class="copyright-wrapper">
      <div class="container">
        <div class="row">
          <div class="footerinner">
            <div class="col-md-3 col-sm-3">
                <?php dynamic_sidebar('footer-1');?>
            </div>
            <div class="col-md-3 col-sm-3">
                <?php dynamic_sidebar('footer-2');?>
            </div>
            <div class="col-md-3 col-sm-3">
                <?php dynamic_sidebar('footer-3');?>
            </div>
            <div class="col-md-3 col-sm-3">
                <?php dynamic_sidebar('footer-4');?>
            </div>
          </div>
        </div>
      </div>
      <div class="inner">
          <div class="copyright text-center">
            <p class="testparabt"><?php echo esc_html(get_theme_mod('blogger_hub_text',__('Blogger WordPress Theme By','blogger-hub'))); ?> <?php blogger_hub_credit_link(); ?></p>
          </div>
          <div class="clear"></div>
      </div>
    </div>
    <?php wp_footer(); ?>
  </body>
</html>