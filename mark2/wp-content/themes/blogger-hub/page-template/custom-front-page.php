<?php
/**
 * Template Name: Custom home page
 */

get_header(); ?>

<?php do_action('blogger_hub_above_post_section'); ?>

<div id="main-post" class="container">
  <div id="sidebar" class="col-md-3">
    <?php dynamic_sidebar('home-page'); ?>
  </div>
  <div id="category_post" class="col-md-9">
    <?php if( get_theme_mod('blogger_hub_section_title') != ''){ ?>
      <h2><?php echo esc_html(get_theme_mod('blogger_hub_section_title',__('Recent Post','blogger-hub'))); ?></h2>
    <?php }?>
    <?php 
      $page_query = new WP_Query(array( 'category_name' => get_theme_mod('blogger_hub_our_category','theblog')));?>
      <?php while( $page_query->have_posts() ) : $page_query->the_post(); ?>
        <div class="col-md-6 col-sm-6">
          <div class="blog-sec">
            <h3><a href="<?php echo esc_url(get_permalink() ); ?>"><?php the_title(); ?></a></h3>
            <hr class="post-hr">
            <div class="post-info">
              <i class="fa fa-calendar" aria-hidden="true"></i><span class="entry-date"><?php the_date(); ?></span>
            </div>
            <div class="mainimage">
                <?php 
                    if(has_post_thumbnail()) { 
                      the_post_thumbnail(); 
                    }
                ?>    
            </div>  
            <div class="post-info">
              <i class="fa fa-user" aria-hidden="true"></i><span class="entry-author"> <?php the_author(); ?></span>
              <i class="fa fa-comments" aria-hidden="true"></i><span class="entry-comments"> <?php comments_number( __('0 Comments','blogger-hub'), __('0 Comments','blogger-hub'), __('% Comments','blogger-hub') ); ?></span> 
            </div>
            <p><?php the_excerpt(); ?></p>
            <div class="blogbtn">
              <a href="<?php echo esc_url( get_permalink() );?>" class="blogbutton-small hvr-sweep-to-right" title="<?php esc_attr_e( 'Read Full', 'blogger-hub' ); ?>"><?php esc_html_e('Read Full','blogger-hub'); ?></a>
            </div>
            <div class="row">
              <div class="col-md-6">
                  <p class="post_tag"><?php
                    if( $tags = get_the_tags() ) {
                      echo '<span class="meta-sep"></span>';
                      foreach( $tags as $tag ) {
                          $sep = ( $tag === end( $tags ) ) ? '' : ' ';
                          echo '<a href="' . esc_url(get_term_link( $tag, $tag->taxonomy )) . '">#' . esc_html($tag->name) . '</a>' . esc_html($sep);
                      }
                  }?></p>
              </div>
              <div class="col-md-6">
                <div class="att_socialbox">
                  <i class="fas fa-share-alt"></i> <span><?php echo esc_html_e('Share :','blogger-hub'); ?></span>
                  <a href="https://www.facebook.com/sharer/sharer.php?u=<?php  the_permalink(); ?>" target="_blank"><i class="fab fa-facebook-f" aria-hidden="true"></i></a>
                  <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php  the_permalink(); ?>" target="_blank"><i class="fab fa-linkedin-in" aria-hidden="true"></i></a>
                  <a href="https://plus.google.com/share?url=<?php  the_permalink(); ?>" target="_blank"><i class="fab fa-google-plus-g" aria-hidden="true"></i></a>
                  <a href="https://twitter.com/share?url=<?php  the_permalink(); ?>" target="_blank"><i class="fab fa-twitter" aria-hidden="true"></i></a>
                  <a href="http://www.instagram.com/submit?url=<?php  the_permalink(); ?>" target="_blank"><i class="fab fa-instagram"></i></a>
                </div>
              </div>
            </div>
          </div>
          <div class="navigation">
              <?php
                  // Previous/next page navigation.
                  the_posts_pagination( array(
                      'prev_text'          => __( 'Previous page', 'blogger-hub' ),
                      'next_text'          => __( 'Next page', 'blogger-hub' ),
                      'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'blogger-hub' ) . ' </span>',
                  ) );
              ?>
              <div class="clearfix"></div>
          </div>
        </div>
        <?php endwhile; 
        wp_reset_postdata();
    ?>
  </div>
</div>

<?php do_action('blogger_hub_below_post_section'); ?>

<section id="wrapper">
  <div class="container">
    <div class="feature-box">
      <?php while ( have_posts() ) : the_post(); ?>
        <?php the_content(); ?>
      <?php endwhile; // end of the loop. ?>
    </div>
  </div>
</section>    

<?php get_footer(); ?>