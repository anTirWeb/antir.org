<?php
/**
 * The Template for displaying all single posts.
 * @package Blogger Hub
 */

get_header(); ?>

<div class="container">
    <div class="main-wrap-box">
    	<?php
	    $left_right = get_theme_mod( 'blogger_hub_layout','Right Sidebar');
	    if($left_right == 'Right Sidebar'){ ?>
			<div class="col-md-9 col-sm-9" id="wrapper">
				<div class="feature-box">
		            <div class="bradcrumbs">
		                <?php blogger_hub_the_breadcrumb(); ?>
		            </div>
				</div>
				<div class="feature-box">
					<?php while ( have_posts() ) : the_post(); ?>					
						<h1><?php the_title();?></h1>
						<div class="post-info">
					        <i class="fa fa-calendar" aria-hidden="true"></i><span class="entry-date"><?php the_date(); ?></span>
					        <i class="fa fa-user" aria-hidden="true"></i><span class="entry-author"> <?php the_author(); ?></span>
					        <i class="fa fa-comments" aria-hidden="true"></i><span class="entry-comments"> <?php comments_number( __('0 Comments','blogger-hub'), __('0 Comments','blogger-hub'), __('% Comments','blogger-hub') ); ?></span> 
					    </div>
						<?php if(has_post_thumbnail()) { ?>
							<hr>
							<div class="feature-box">	
								<img src="<?php the_post_thumbnail_url('full'); ?>" width="100%">
							</div>
							<hr>					
						<?php } 
						the_content();

						wp_link_pages( array(
							'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'blogger-hub' ) . '</span>',
							'after'       => '</div>',
							'link_before' => '<span>',
							'link_after'  => '</span>',
							'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', 'blogger-hub' ) . ' </span>%',
							'separator'   => '<span class="screen-reader-text">, </span>',
						) );
							
						if ( is_singular( 'attachment' ) ) {
							// Parent post navigation.
							the_post_navigation( array(
								'prev_text' => _x( '<span class="meta-nav">Published in</span><span class="post-title">%title</span>', 'Parent post link', 'blogger-hub' ),
							) );
						} elseif ( is_singular( 'post' ) ) {
							// Previous/next post navigation.
							the_post_navigation( array(
								'next_text' => '<span class="meta-nav" aria-hidden="true">' . __( 'Next', 'blogger-hub' ) . '</span> ' .
									'<span class="screen-reader-text">' . __( 'Next post:', 'blogger-hub' ) . '</span> ' .
									'<span class="post-title">%title</span>',
								'prev_text' => '<span class="meta-nav" aria-hidden="true">' . __( 'Previous', 'blogger-hub' ) . '</span> ' .
									'<span class="screen-reader-text">' . __( 'Previous post:', 'blogger-hub' ) . '</span> ' .
									'<span class="post-title">%title</span>',
							) );
						}
		                
		                echo '<div class="clearfix"></div>';
		                
						the_tags(); 

		                // If comments are open or we have at least one comment, load up the comment template.
						if ( comments_open() || get_comments_number() ) {
							comments_template();
						}

		            endwhile; // end of the loop. 
		            wp_reset_postdata();?>
		        </div>
	       	</div>
			<div class="col-md-3 col-sm-3"><?php get_sidebar();?></div>
		<?php }else if($left_right == 'Left Sidebar'){ ?>
			<div class="col-md-3 col-sm-3"><?php get_sidebar();?></div>
			<div class="col-md-9 col-sm-9" id="wrapper">
				<div class="feature-box">
		            <div class="bradcrumbs">
		                <?php blogger_hub_the_breadcrumb(); ?>
		            </div>
				</div>
				<div class="feature-box">
					<?php while ( have_posts() ) : the_post(); ?>
						<h1><?php the_title();?></h1>
						<div class="post-info">
					        <i class="fa fa-calendar" aria-hidden="true"></i><span class="entry-date"><?php the_date(); ?></span>
					        <i class="fa fa-user" aria-hidden="true"></i><span class="entry-author"> <?php the_author(); ?></span>
					        <i class="fa fa-comments" aria-hidden="true"></i><span class="entry-comments"> <?php comments_number( __('0 Comments','blogger-hub'), __('0 Comments','blogger-hub'), __('% Comments','blogger-hub') ); ?></span> 
					    </div>
						<?php if(has_post_thumbnail()) { ?>
							<hr>
							<div class="feature-box">	
								<img src="<?php the_post_thumbnail_url('full'); ?>" width="100%">
							</div>
							<hr>					
						<?php } 
						the_content();

						wp_link_pages( array(
							'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'blogger-hub' ) . '</span>',
							'after'       => '</div>',
							'link_before' => '<span>',
							'link_after'  => '</span>',
							'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', 'blogger-hub' ) . ' </span>%',
							'separator'   => '<span class="screen-reader-text">, </span>',
						) );
							
						if ( is_singular( 'attachment' ) ) {
							// Parent post navigation.
							the_post_navigation( array(
								'prev_text' => _x( '<span class="meta-nav">Published in</span><span class="post-title">%title</span>', 'Parent post link', 'blogger-hub' ),
							) );
						} elseif ( is_singular( 'post' ) ) {
							// Previous/next post navigation.
							the_post_navigation( array(
								'next_text' => '<span class="meta-nav" aria-hidden="true">' . __( 'Next', 'blogger-hub' ) . '</span> ' .
									'<span class="screen-reader-text">' . __( 'Next post:', 'blogger-hub' ) . '</span> ' .
									'<span class="post-title">%title</span>',
								'prev_text' => '<span class="meta-nav" aria-hidden="true">' . __( 'Previous', 'blogger-hub' ) . '</span> ' .
									'<span class="screen-reader-text">' . __( 'Previous post:', 'blogger-hub' ) . '</span> ' .
									'<span class="post-title">%title</span>',
							) );
						}
		                
		                echo '<div class="clearfix"></div>';
		                
						the_tags(); 

		                // If comments are open or we have at least one comment, load up the comment template.
						if ( comments_open() || get_comments_number() ) {
							comments_template();
						}
		            endwhile; // end of the loop. 
		            wp_reset_postdata();?>
		        </div>
	       	</div>
		<?php }else if($left_right == 'One Column'){ ?>
			<div class="col-md-12 col-sm-12" id="wrapper">
				<div class="feature-box">
		            <div class="bradcrumbs">
		                <?php blogger_hub_the_breadcrumb(); ?>
		            </div>
				</div>
				<div class="feature-box">
					<?php while ( have_posts() ) : the_post(); ?>
						<h1><?php the_title();?></h1>
						<div class="post-info">
					        <i class="fa fa-calendar" aria-hidden="true"></i><span class="entry-date"><?php the_date(); ?></span>
					        <i class="fa fa-user" aria-hidden="true"></i><span class="entry-author"> <?php the_author(); ?></span>
					        <i class="fa fa-comments" aria-hidden="true"></i><span class="entry-comments"> <?php comments_number( __('0 Comments','blogger-hub'), __('0 Comments','blogger-hub'), __('% Comments','blogger-hub') ); ?></span> 
					    </div>
						<?php if(has_post_thumbnail()) { ?>
							<hr>
							<div class="feature-box">	
								<img src="<?php the_post_thumbnail_url('full'); ?>" width="100%">
							</div>
							<hr>					
						<?php } 
						the_content();

						wp_link_pages( array(
							'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'blogger-hub' ) . '</span>',
							'after'       => '</div>',
							'link_before' => '<span>',
							'link_after'  => '</span>',
							'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', 'blogger-hub' ) . ' </span>%',
							'separator'   => '<span class="screen-reader-text">, </span>',
						) );
							
						if ( is_singular( 'attachment' ) ) {
							// Parent post navigation.
							the_post_navigation( array(
								'prev_text' => _x( '<span class="meta-nav">Published in</span><span class="post-title">%title</span>', 'Parent post link', 'blogger-hub' ),
							) );
						} elseif ( is_singular( 'post' ) ) {
							// Previous/next post navigation.
							the_post_navigation( array(
								'next_text' => '<span class="meta-nav" aria-hidden="true">' . __( 'Next', 'blogger-hub' ) . '</span> ' .
									'<span class="screen-reader-text">' . __( 'Next post:', 'blogger-hub' ) . '</span> ' .
									'<span class="post-title">%title</span>',
								'prev_text' => '<span class="meta-nav" aria-hidden="true">' . __( 'Previous', 'blogger-hub' ) . '</span> ' .
									'<span class="screen-reader-text">' . __( 'Previous post:', 'blogger-hub' ) . '</span> ' .
									'<span class="post-title">%title</span>',
							) );
						}
		                
		                echo '<div class="clearfix"></div>';
		                
						the_tags(); 

		                // If comments are open or we have at least one comment, load up the comment template.
						if ( comments_open() || get_comments_number() ) {
							comments_template();
						}
		            endwhile; // end of the loop. 
		            wp_reset_postdata();?>
		        </div>
	       	</div>
	    <?php }else if($left_right == 'Three Columns'){ ?>
	        <div id="sidebar" class="col-md-3 col-sm-3"><?php dynamic_sidebar('sidebar-1');?></div>
			<div class="col-md-6 col-sm-6" id="wrapper">
				<div class="feature-box">
		            <div class="bradcrumbs">
		                <?php blogger_hub_the_breadcrumb(); ?>
		            </div>
				</div>
				<div class="feature-box">
					<?php while ( have_posts() ) : the_post(); ?>
						<h1><?php the_title();?></h1>
						<div class="post-info">
					        <i class="fa fa-calendar" aria-hidden="true"></i><span class="entry-date"><?php the_date(); ?></span>
					        <i class="fa fa-user" aria-hidden="true"></i><span class="entry-author"> <?php the_author(); ?></span>
					        <i class="fa fa-comments" aria-hidden="true"></i><span class="entry-comments"> <?php comments_number( __('0 Comments','blogger-hub'), __('0 Comments','blogger-hub'), __('% Comments','blogger-hub') ); ?></span> 
					    </div>
						<?php if(has_post_thumbnail()) { ?>
							<hr>
							<div class="feature-box">	
								<img src="<?php the_post_thumbnail_url('full'); ?>" width="100%">
							</div>
							<hr>					
						<?php } 
						the_content();

						wp_link_pages( array(
							'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'blogger-hub' ) . '</span>',
							'after'       => '</div>',
							'link_before' => '<span>',
							'link_after'  => '</span>',
							'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', 'blogger-hub' ) . ' </span>%',
							'separator'   => '<span class="screen-reader-text">, </span>',
						) );
							
						if ( is_singular( 'attachment' ) ) {
							// Parent post navigation.
							the_post_navigation( array(
								'prev_text' => _x( '<span class="meta-nav">Published in</span><span class="post-title">%title</span>', 'Parent post link', 'blogger-hub' ),
							) );
						} elseif ( is_singular( 'post' ) ) {
							// Previous/next post navigation.
							the_post_navigation( array(
								'next_text' => '<span class="meta-nav" aria-hidden="true">' . __( 'Next', 'blogger-hub' ) . '</span> ' .
									'<span class="screen-reader-text">' . __( 'Next post:', 'blogger-hub' ) . '</span> ' .
									'<span class="post-title">%title</span>',
								'prev_text' => '<span class="meta-nav" aria-hidden="true">' . __( 'Previous', 'blogger-hub' ) . '</span> ' .
									'<span class="screen-reader-text">' . __( 'Previous post:', 'blogger-hub' ) . '</span> ' .
									'<span class="post-title">%title</span>',
							) );
						}
		                
		                echo '<div class="clearfix"></div>';
		                
						the_tags(); 

		                // If comments are open or we have at least one comment, load up the comment template.
						if ( comments_open() || get_comments_number() ) {
							comments_template();
						}
		            endwhile; // end of the loop. 
		            wp_reset_postdata();?>
		        </div>
	       	</div>
	       	<div id="sidebar" class="col-md-3 col-sm-3"><?php dynamic_sidebar('sidebar-2');?></div>
	    <?php }else if($left_right == 'Four Columns'){ ?>
	        <div id="sidebar" class="col-md-3 col-sm-3"><?php dynamic_sidebar('sidebar-1');?></div>
			<div class="col-md-3 col-sm-3" id="wrapper">
				<div class="feature-box">
		            <div class="bradcrumbs">
		                <?php blogger_hub_the_breadcrumb(); ?>
		            </div>
				</div>
				<div class="feature-box">
					<?php while ( have_posts() ) : the_post(); ?>
						<h1><?php the_title();?></h1>
						<div class="post-info">
					        <i class="fa fa-calendar" aria-hidden="true"></i><span class="entry-date"><?php the_date(); ?></span>
					        <i class="fa fa-user" aria-hidden="true"></i><span class="entry-author"> <?php the_author(); ?></span>
					        <i class="fa fa-comments" aria-hidden="true"></i><span class="entry-comments"> <?php comments_number( __('0 Comments','blogger-hub'), __('0 Comments','blogger-hub'), __('% Comments','blogger-hub') ); ?></span> 
					    </div>
						<?php if(has_post_thumbnail()) { ?>
							<hr>
							<div class="feature-box">	
								<img src="<?php the_post_thumbnail_url('full'); ?>" width="100%">
							</div>
							<hr>					
						<?php } 
						the_content();

						wp_link_pages( array(
							'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'blogger-hub' ) . '</span>',
							'after'       => '</div>',
							'link_before' => '<span>',
							'link_after'  => '</span>',
							'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', 'blogger-hub' ) . ' </span>%',
							'separator'   => '<span class="screen-reader-text">, </span>',
						) );
							
						if ( is_singular( 'attachment' ) ) {
							// Parent post navigation.
							the_post_navigation( array(
								'prev_text' => _x( '<span class="meta-nav">Published in</span><span class="post-title">%title</span>', 'Parent post link', 'blogger-hub' ),
							) );
						} elseif ( is_singular( 'post' ) ) {
							// Previous/next post navigation.
							the_post_navigation( array(
								'next_text' => '<span class="meta-nav" aria-hidden="true">' . __( 'Next', 'blogger-hub' ) . '</span> ' .
									'<span class="screen-reader-text">' . __( 'Next post:', 'blogger-hub' ) . '</span> ' .
									'<span class="post-title">%title</span>',
								'prev_text' => '<span class="meta-nav" aria-hidden="true">' . __( 'Previous', 'blogger-hub' ) . '</span> ' .
									'<span class="screen-reader-text">' . __( 'Previous post:', 'blogger-hub' ) . '</span> ' .
									'<span class="post-title">%title</span>',
							) );
						}
		                
		                echo '<div class="clearfix"></div>';
		                
						the_tags(); 

		                // If comments are open or we have at least one comment, load up the comment template.
						if ( comments_open() || get_comments_number() ) {
							comments_template();
						}
		            endwhile; // end of the loop. 
		            wp_reset_postdata();?>
		        </div>
	       	</div>
	       	<div id="sidebar" class="col-md-3 col-sm-3"><?php dynamic_sidebar('sidebar-2');?></div>
	       	<div id="sidebar" class="col-md-3 col-sm-3"><?php dynamic_sidebar('sidebar-3');?></div>
	    <?php }else if($left_right == 'Grid Layout'){ ?>
	    	<div class="col-md-4 col-sm-4"><?php get_sidebar();?></div>
			<div class="col-md-8 col-sm-8" id="wrapper">
				<div class="feature-box">
		            <div class="bradcrumbs">
		                <?php blogger_hub_the_breadcrumb(); ?>
		            </div>
				</div>
				<div class="feature-box">
					<?php while ( have_posts() ) : the_post(); ?>
						<h1><?php the_title();?></h1>
						<div class="post-info">
					        <i class="fa fa-calendar" aria-hidden="true"></i><span class="entry-date"><?php the_date(); ?></span>
					        <i class="fa fa-user" aria-hidden="true"></i><span class="entry-author"> <?php the_author(); ?></span>
					        <i class="fa fa-comments" aria-hidden="true"></i><span class="entry-comments"> <?php comments_number( __('0 Comments','blogger-hub'), __('0 Comments','blogger-hub'), __('% Comments','blogger-hub') ); ?></span> 
					    </div>
						<?php if(has_post_thumbnail()) { ?>
							<hr>
							<div class="feature-box">	
								<img src="<?php the_post_thumbnail_url('full'); ?>" width="100%">
							</div>
							<hr>					
						<?php } 
						the_content();

						wp_link_pages( array(
							'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'blogger-hub' ) . '</span>',
							'after'       => '</div>',
							'link_before' => '<span>',
							'link_after'  => '</span>',
							'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', 'blogger-hub' ) . ' </span>%',
							'separator'   => '<span class="screen-reader-text">, </span>',
						) );
							
						if ( is_singular( 'attachment' ) ) {
							// Parent post navigation.
							the_post_navigation( array(
								'prev_text' => _x( '<span class="meta-nav">Published in</span><span class="post-title">%title</span>', 'Parent post link', 'blogger-hub' ),
							) );
						} elseif ( is_singular( 'post' ) ) {
							// Previous/next post navigation.
							the_post_navigation( array(
								'next_text' => '<span class="meta-nav" aria-hidden="true">' . __( 'Next', 'blogger-hub' ) . '</span> ' .
									'<span class="screen-reader-text">' . __( 'Next post:', 'blogger-hub' ) . '</span> ' .
									'<span class="post-title">%title</span>',
								'prev_text' => '<span class="meta-nav" aria-hidden="true">' . __( 'Previous', 'blogger-hub' ) . '</span> ' .
									'<span class="screen-reader-text">' . __( 'Previous post:', 'blogger-hub' ) . '</span> ' .
									'<span class="post-title">%title</span>',
							) );
						}
		                
		                echo '<div class="clearfix"></div>';
		                
						the_tags(); 

		                // If comments are open or we have at least one comment, load up the comment template.
						if ( comments_open() || get_comments_number() ) {
							comments_template();
						}
		            endwhile; // end of the loop. 
		            wp_reset_postdata();?>
		        </div>
	       	</div>
	    <?php }?>
        <div class="clearfix"></div>
    </div>
</div>
<?php get_footer(); ?>