<?php
/**
 * The Header for our theme.
 * @package Blogger Hub
 */

?><!DOCTYPE html>

<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width">
  <link rel="profile" href="<?php echo esc_url( __( 'http://gmpg.org/xfn/11', 'blogger-hub' ) ); ?>">
  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php /** slider section **/ ?>

<div id="header">
  <div class="menu-sec">
    <div class="container">
      <div class="toggle"><a class="toggleMenu" href="#"><?php esc_html_e('Menu','blogger-hub'); ?></a></div>
      <div class="menubox col-md-8 col-sm-8">
        <div class="nav">
          <?php wp_nav_menu( array('theme_location'  => 'primary') ); ?>
        </div>
      </div>
      <div class="col-md-2 col-sm-2">
        <div class="social-links">
          <?php if( get_theme_mod( 'blogger_hub_facebook_url' ) != '') { ?>
            <a href="<?php echo esc_url( get_theme_mod( 'blogger_hub_facebook_url','' ) ); ?>"><i class="fab fa-facebook-f"></i></a>
          <?php } ?>
          <?php if( get_theme_mod( 'blogger_hub_twitter_url' ) != '') { ?>
            <a href="<?php echo esc_url( get_theme_mod( 'blogger_hub_twitter_url','' ) ); ?>"><i class="fab fa-twitter"></i></a>
          <?php } ?>
          <?php if( get_theme_mod( 'blogger_hub_insta_url') != '') { ?>
            <a href="<?php echo esc_url( get_theme_mod( 'blogger_hub_insta_url','' ) ); ?>"><i class="fab fa-instagram"></i></a>
          <?php } ?>
          <?php if( get_theme_mod( 'blogger_hub_linkdin_url') != '') { ?>
            <a href="<?php echo esc_url( get_theme_mod( 'blogger_hub_linkdin_url','' ) ); ?>"><i class="fab fa-linkedin-in"></i></a>
          <?php } ?>
          <?php if( get_theme_mod( 'blogger_hub_youtube_url' ) != '') { ?>
            <a href="<?php echo esc_url( get_theme_mod( 'blogger_hub_youtube_url','' ) ); ?>"><i class="fab fa-youtube"></i></a>
          <?php } ?>
        </div>
      </div>
      <div class="col-md-2 col-sm-2">
        <div class="search-box">
          <?php get_search_form(); ?>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="logo header-image">
  <?php if( has_custom_logo() ){ blogger_hub_the_custom_logo();
   }else{ ?>
  <h1><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
  <?php $description = get_bloginfo( 'description', 'display' );
  if ( $description || is_customize_preview() ) : ?> 
    <p class="site-description"><?php echo esc_html($description); ?></p>
  <?php endif; }?>
</div>