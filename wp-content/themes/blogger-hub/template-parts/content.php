<?php
/**
 * The template part for displaying services
 * @package Blogger Hub
 * @subpackage blogger_hub
 * @since 1.0
 */
?>

<div id="post-<?php the_ID(); ?>" <?php post_class('inner-service'); ?>>
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
</div>