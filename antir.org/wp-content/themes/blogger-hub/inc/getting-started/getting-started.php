<?php
//about theme info
add_action( 'admin_menu', 'blogger_hub_gettingstarted' );
function blogger_hub_gettingstarted() {    	
	add_theme_page( esc_html__('Get Started', 'blogger-hub'), esc_html__('Get Started', 'blogger-hub'), 'edit_theme_options', 'blogger_hub_guide', 'blogger_hub_mostrar_guide');   
}

// Add a Custom CSS file to WP Admin Area
function blogger_hub_admin_theme_style() {
   wp_enqueue_style('custom-admin-style', get_template_directory_uri() . '/inc/getting-started/getting-started.css');
}
add_action('admin_enqueue_scripts', 'blogger_hub_admin_theme_style');

//guidline for about theme
function blogger_hub_mostrar_guide() { 
	//custom function about theme customizer
	$return = add_query_arg( array()) ;
	$theme = wp_get_theme( 'blogger-hub' );
?>
<div class="wrapper-info">
	<div class="col-left">
		<div class="intro">
			<h3><?php esc_html_e( 'Welcome to Blogger Hub Wordpress Theme', 'blogger-hub' ); ?></h3>
		</div>
		<div class="color_bg_blue">
			<p>Version: <?php echo esc_html($theme['Version']);?></p>
				<p class="intro_version"><?php esc_html_e( 'Congratulations! You are about to use the most easy to use and felxible WordPress theme.', 'blogger-hub' ); ?></p>
				<div class="blink">
					<h4><?php esc_html_e( 'Theme Created By Themesglance', 'blogger-hub' ); ?></h4>
				</div>
			<div class="intro-text"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/inc/getting-started/images/themesglance-logo.png" alt="" /></div>
			<div class="coupon-code"><?php esc_html_e( 'Get', 'blogger-hub' ); ?> <span><?php esc_html_e( '20% off', 'blogger-hub' ); ?></span> <?php esc_html_e( 'on Premium Theme with the discount code: ', 'blogger-hub' ); ?> <span><?php esc_html_e( '" TGYear2018 "', 'blogger-hub' ); ?></span></div>
		</div>
		<div class="started">
			<h3><?php esc_html_e( 'Lite Theme Info', 'blogger-hub' ); ?></h3>
			<p><?php esc_html_e('Blogger Hub is a minimal WordPress theme designed aesthetically for giving modern look to your site. This multipurpose theme can be used for food blog, fashion blog, lifestyle blog, tech blog, sports blog, personal blog, travel blog, craft blog, photography blog etc. It can prove to be a landing page. Magazines and newsletter sites can seamlessly blend into its design. If you are looking for a theme for writing journal or your biography then Blog Hub is the answer for you. It can be used as a writers theme. It is a bloggers junction. The Blogger Hub WordPress theme can be customized to make small to big changes. It is a fully responsive, cross-browser compatible and translation ready theme. It has various styling options making it versatile to be used in various forms. This mobile-friendly theme has short codes implemented which make your site clean and secure. The stunning design, interactive and user-friendly interface attract everyones attention and make them adhere to your site for longer time. Its SEO-friendliness gives your site a higher rank in Google search engine. Though the theme has various features and functionalities, still it has faster page loading ability. The social media integration makes your site reach wider audience.', 'blogger-hub')?></p>
			<hr>
			<h3><?php esc_html_e( 'Help Docs', 'blogger-hub' ); ?></h3>
			<ul>
				<p><?php esc_html_e( 'Blogger Hub', 'blogger-hub' ); ?> <a href="<?php echo esc_url( BLOGGER_HUB_THEMESGLANCE_FREE_THEME_DOC ); ?>" target="_blank"> <?php esc_html_e( 'Documentation', 'blogger-hub' ); ?></a></p>
			</ul>
			<hr>
			<h3><?php esc_html_e( 'Get started with Blogger Hub Theme', 'blogger-hub' ); ?></h3>
			<div class="col-left-inner"> 
				<img src="<?php echo esc_url(get_template_directory_uri()); ?>/inc/getting-started/images/free-screenshot.png" alt="" />
			</div>		
			<div class="col-right-inner">
				<p><?php esc_html_e( 'Go to', 'blogger-hub' ); ?> <a target="_blank" href="<?php echo esc_url( admin_url('customize.php') ); ?>"><?php esc_html_e( 'Customizer', 'blogger-hub' ); ?> </a> <?php esc_html_e( 'and start customizing your website', 'blogger-hub' ); ?></p>
				<ul>
					<li><?php esc_html_e( 'Easily customizable ', 'blogger-hub' ); ?> </li>
					<li><?php esc_html_e( 'Absolutely free', 'blogger-hub' ); ?> </li>
				</ul>
			</div>
		</div>
	</div>
	<div class="col-right">
		<div class="col-left-area">
			<h3><?php esc_html_e('Premium Theme Information', 'blogger-hub'); ?></h3>
			<hr>
		</div>
		<div class="centerbold">
			<img src="<?php echo esc_url(get_template_directory_uri()); ?>/inc/getting-started/images/responsive.png" alt="" />
			<hr class="firsthr">
			<a href="<?php echo esc_url( BLOGGER_HUB_THEMESGLANCE_LIVE_DEMO ); ?>" target="_blank"><?php esc_html_e('Live Demo', 'blogger-hub'); ?></a>
			<a href="<?php echo esc_url( BLOGGER_HUB_THEMESGLANCE_PRO_THEME_URL ); ?>"><?php esc_html_e('Buy Pro', 'blogger-hub'); ?></a>
			<a href="<?php echo esc_url( BLOGGER_HUB_THEMESGLANCE_THEME_DOC ); ?>" target="_blank"><?php esc_html_e('Pro Documentation', 'blogger-hub'); ?></a>
			<hr class="secondhr">
		</div>
		<h3><?php esc_html_e( 'PREMIUM THEME FEATURES', 'blogger-hub'); ?></h3>
		<ul>
		 	<li><?php esc_html_e( 'Category Slider', 'blogger-hub'); ?></li>
		 	<li><?php esc_html_e( 'Post slider', 'blogger-hub'); ?></li>
		 	<li><?php esc_html_e( 'Gallery Section', 'blogger-hub'); ?></li>
		 	<li><?php esc_html_e( 'Sidebar to showcase latest trends and news', 'blogger-hub'); ?></li>
		 	<li><?php esc_html_e( 'Woocommerce Product Section', 'blogger-hub'); ?></li>
		 	<li><?php esc_html_e( 'Newsletter', 'blogger-hub'); ?></li>
		 	<li><?php esc_html_e( 'Instagram section', 'blogger-hub'); ?></li>
		 	<li><?php esc_html_e( 'Gallery Plugin with shortcode', 'blogger-hub'); ?></li>
		 	<li><?php esc_html_e( 'Social Icon widget', 'blogger-hub'); ?></li>
		 	<li><?php esc_html_e( 'Contact Layout', 'blogger-hub'); ?></li>
		 	<li><?php esc_html_e( 'Recent Post Widget with thumbnails', 'blogger-hub'); ?></li>
		 	<li><?php esc_html_e( 'Blog full width, With Left and Right sidebar Template', 'blogger-hub'); ?></li>
		</ul>
	</div>
	<div class="service">
		<div class="col-md-3">
			<h3><span class="dashicons dashicons-media-document"></span> <?php esc_html_e('Get Support', 'blogger-hub'); ?></h3>
			<ol>
				<li>
				<a href="<?php echo esc_url( BLOGGER_HUB_THEMESGLANCE_SUPPORT ); ?>" target="_blank"><?php esc_html_e('Support Forum', 'blogger-hub'); ?></a>
				</li>
			</ol>
		</div>
		<div class="col-md-3">
			<h3><span class="dashicons dashicons-welcome-widgets-menus"></span> <?php esc_html_e('Getting Started', 'blogger-hub'); ?></h3>
			<ol>
				<li> <?php esc_html_e('Start', 'blogger-hub'); ?> <a target="_blank" href="<?php echo esc_url( admin_url('customize.php') ); ?>"><?php esc_html_e('Customizing', 'blogger-hub'); ?></a> <?php esc_html_e('your website.', 'blogger-hub'); ?></li>
			</ol>
		</div>
		<div class="col-md-3">
			<h3><span class="dashicons dashicons-star-filled"></span> <?php esc_html_e('Rate This Theme', 'blogger-hub'); ?></h3>
			<ol>
				<li>
				<a href="<?php echo esc_url( BLOGGER_HUB_THEMESGLANCE_REVIEW ); ?>" target="_blank"><?php esc_html_e('Rate it here', 'blogger-hub'); ?></a>
				</li>
			</ol>
		</div>
		<div class="col-md-3">
			<h3><span class="dashicons dashicons-editor-help"></span> <?php esc_html_e( 'Help Docs', 'blogger-hub' ); ?></h3>
			<ol>
				<li><?php esc_html_e( 'Blogger Hub Lite', 'blogger-hub' ); ?> <a href="<?php echo esc_url( BLOGGER_HUB_THEMESGLANCE_FREE_THEME_DOC ); ?>" target="_blank"> <?php esc_html_e( 'Documentation', 'blogger-hub' ); ?></a></li>
			</ol>
		</div>
	</div>
</div>
<?php } ?>