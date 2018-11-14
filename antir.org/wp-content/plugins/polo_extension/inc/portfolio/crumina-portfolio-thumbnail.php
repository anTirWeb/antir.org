<?php
if ( ! ( class_exists( 'Crum_Portfolio_List_thumbnail' ) ) ) {

	/**
	 * Class Crum_Portfolio_List_thumbnail
	 */
	class Crum_Portfolio_List_thumbnail {

		/**
		 *
		 */
		function __construct() {

			add_filter( 'manage_portfolio_posts_columns', array( &$this, 'crum_portfolio_thumbnail_row' ) );

			add_action( 'manage_portfolio_posts_custom_column', array(
					&$this,
					'crum_portfolio_thumbnail_row_content'
				), 10, 2 );

		}

		/**
		 * @param $defaults
		 *
		 * @return mixed
		 */
		function crum_portfolio_thumbnail_row( $defaults ) {
			$defaults['thumb'] = __( 'Thumbnail', 'crum' );

			return $defaults;
		}


		/**
		 * @param $column_name
		 * @param $post_id
		 */
		function crum_portfolio_thumbnail_row_content( $column_name, $post_id ) {
			if ( $column_name == 'thumb' ) {
				if ( has_post_thumbnail( $post_id ) ) {
					$post_thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'full' );
					$thumb          = polo_theme_thumb( $post_thumbnail[0], 100, 100, true );
				} else {
					$thumb = polo_theme_thumb( PLUGIN_URL . 'assets/img/no-image.png', 100, 100, true );
				}

				$output = '<img src="'.$thumb.'" />';

				echo $output;
			}

		}

	}

}

if (class_exists('Crum_Portfolio_List_thumbnail')){
	$Crum_Portfolio_List_thumbnail = new Crum_Portfolio_List_thumbnail;
}