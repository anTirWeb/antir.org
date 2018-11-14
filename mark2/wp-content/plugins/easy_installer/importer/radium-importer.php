<?php

/**
 * Class Radium_Theme_Importer
 *
 * This class provides the capability to import demo content as well as import widgets and WordPress menus
 *
 * @since    0.0.2
 *
 * @category RadiumFramework
 * @package  NewsCore WP
 * @author   Franklin M Gitonga
 * @link     http://radiumthemes.com/
 *
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Don't duplicate me!
if ( ! class_exists( 'Radium_Theme_Importer' ) ) {

	class Radium_Theme_Importer {

		/**
		 * Set the theme framework in use
		 *
		 * @since 0.0.3
		 *
		 * @var object
		 */
		public $theme_options_framework = 'radium'; //supports radium framework and option tree

		/**
		 * Holds a copy of the object for easy reference.
		 *
		 * @since 0.0.2
		 *
		 * @var object
		 */
		public $theme_options_file;

		/**
		 * Holds a copy of the object for easy reference.
		 *
		 * @since 0.0.2
		 *
		 * @var object
		 */
		public $widgets;

		/**
		 * Holds a copy of the object for easy reference.
		 *
		 * @since 0.0.2
		 *
		 * @var object
		 */
		public $content_demo;

		/**
		 * Flag imported to prevent duplicates
		 *
		 * @since 0.0.3
		 *
		 * @var array
		 */
		public $flag_as_imported = array(
			'content' => false,
			'menus'   => false,
			'options' => false,
			'widgets' => false
		);

		/**
		 * imported sections to prevent duplicates
		 *
		 * @since 0.0.3
		 *
		 * @var array
		 */
		public $imported_demos = array();

		/**
		 * Flag imported to prevent duplicates
		 *
		 * @since 0.0.3
		 *
		 * @var bool
		 */
		public $add_admin_menu = true;

		/**
		 * Holds a copy of the object for easy reference.
		 *
		 * @since 0.0.2
		 *
		 * @var object
		 */
		private static $instance;

		/**
		 * Constructor. Hooks all interactions to initialize the class.
		 *
		 * @since 0.0.2
		 */
		public function __construct() {

			self::$instance = $this;

			$this->demo_files_path = apply_filters( 'radium_theme_importer_demo_files_path', $this->demo_files_path );

			$this->theme_options_file = apply_filters( 'radium_theme_importer_theme_options_file', $this->demo_files_path . $this->theme_options_file_name );

			$this->widgets = apply_filters( 'radium_theme_importer_widgets_file', $this->demo_files_path . $this->widgets_file_name );

			$this->content_demo = apply_filters( 'radium_theme_importer_content_demo_file', $this->demo_files_path . $this->content_demo_file_name );

			$this->imported_demos = get_option( 'radium_imported_demo' );

			if ( $this->theme_options_framework == 'optiontree' ) {
				$this->theme_option_name = ot_options_id();
			}

			if ( $this->add_admin_menu ) {
				add_action( 'admin_menu', array( $this, 'add_admin' ) );
			}

			add_filter( 'add_post_metadata', array( $this, 'check_previous_meta' ), 10, 5 );

			add_action( 'radium_import_end', array( $this, 'after_wp_importer' ) );

		}

		/**
		 * Add Panel Page
		 *
		 * @since 0.0.2
		 */
		public function add_admin() {

			add_submenu_page( 'themes.php', "Import Demo Data", "Import Demo Data", 'switch_themes', 'radium_demo_installer', array(
				$this,
				'demo_installer'
			) );

		}

		/**
		 * Avoids adding duplicate meta causing arrays in arrays from WP_importer
		 *
		 * @param null    $continue
		 * @param unknown $post_id
		 * @param unknown $meta_key
		 * @param unknown $meta_value
		 * @param unknown $unique
		 *
		 * @since 0.0.2
		 *
		 * @return
		 */
		public function check_previous_meta( $continue, $post_id, $meta_key, $meta_value, $unique ) {

			$old_value = get_metadata( 'post', $post_id, $meta_key );

			if ( count( $old_value ) == 1 ) {

				if ( $old_value[0] === $meta_value ) {

					return false;

				} elseif ( $old_value[0] !== $meta_value ) {

					update_post_meta( $post_id, $meta_key, $meta_value );

					return false;

				}

			}

		}

		/**
		 * Add Panel Page
		 *
		 * @since 0.0.2
		 */
		public function after_wp_importer() {

			do_action( 'radium_importer_after_content_import' );

			update_option( 'radium_imported_demo', $this->flag_as_imported );

		}

		public function intro_html() {

			?>

			<div style="background-color: #F5FAFD; margin:10px 0;padding: 5px 10px;color: #0C518F;border: 2px solid #CAE0F3; clear:both; width:90%; line-height:18px;">
				<p class="tie_message_hint">Importing demo data (post, pages, images, theme settings, ...) is the easiest way to setup your theme. It will
					allow you to quickly edit everything instead of creating content from scratch. When you import the data following things will happen:</p>

				<ul style="padding-left: 20px;list-style-position: inside;list-style-type: square;}">
					<li>No existing posts, pages, categories, images, custom post types or any other data will be deleted or modified .</li>
					<li>No WordPress settings will be modified .</li>
					<li>Posts, pages, some images, some widgets and menus will get imported .</li>
					<li>Images will be downloaded from our server, these images are copyrighted and are for demo use only .</li>
					<li>Please click import only once and wait, it can take a couple of minutes</li>
				</ul>
			</div>

			<div style="background-color: #F5FAFD; margin:10px 0;padding: 5px 10px;color: #0C518F;border: 2px solid #CAE0F3; clear:both; width:90%; line-height:18px;">
				<p class="tie_message_hint">Before you begin, make sure all the required plugins are activated.</p>
			</div>

			<div class="row" style="background-color: #F5FAFD; margin:10px 0;padding: 5px 10px;color: #0C518F;border: 2px solid #CAE0F3; clear:both; width:90%; line-height:18px;">

				<div id="import-type" style="width: 25%; padding: 10px;">
					<label for="demo-style"><?php esc_html_e( 'Select demo style', 'polo_importer' ); ?></label>
					<select class="widefat" name="data_demo" id="demo-style">

						<option class="widefat" value="corporate"><?php esc_html_e( 'Corporate', 'polo_importer' ) ?></option>
						<option class="widefat" value="creative"><?php esc_html_e( 'Creative', 'polo_importer' ) ?></option>
						<option class="widefat" value="niche"><?php esc_html_e( 'Niche', 'polo_importer' ) ?></option>
						<option class="widefat" value="templates"><?php esc_html_e( 'Custom sliders', 'polo_importer' ) ?></option>
						<option class="widefat" value="fashion"><?php esc_html_e( 'Fashion', 'polo_importer' ) ?></option>
						<option class="widefat" value="model"><?php esc_html_e( 'Model', 'polo_importer' ) ?></option>
						<option class="widefat" value="lawyer"><?php esc_html_e( 'Lawyer', 'polo_importer' ) ?></option>
						<option class="widefat" value="taxi"><?php esc_html_e( 'Taxi', 'polo_importer' ) ?></option>
						<option class="widefat" value="estate"><?php esc_html_e( 'Estate', 'polo_importer' ) ?></option>
						<option class="widefat" value="shop"><?php esc_html_e( 'Shop', 'polo_importer' ) ?></option>
						<option class="widefat" value="backery"><?php esc_html_e( 'Backery', 'polo_importer' ) ?></option>
						<option class="widefat" value="cafe"><?php esc_html_e( 'Cafe', 'polo_importer' ) ?></option>
						<option class="widefat" value="restaurant"><?php esc_html_e( 'Restaurant', 'polo_importer' ) ?></option>
						<option class="widefat" value="fitness"><?php esc_html_e( 'Fitness', 'polo_importer' ) ?></option>
						<option class="widefat" value="portfolio"><?php esc_html_e( 'Portfolio', 'polo_importer' ) ?></option>
						<option class="widefat" value="architect"><?php esc_html_e( 'Architect', 'polo_importer' ) ?></option>
						<option class="widefat" value="wine"><?php esc_html_e( 'Wine', 'polo_importer' ) ?></option>
						<option class="widefat" value="magazine"><?php esc_html_e( 'Magazine', 'polo_importer' ) ?></option>
						<option class="widefat" value="onepage"><?php esc_html_e( 'One Page', 'polo_importer' ) ?></option>

					</select>
				</div>

				<div id="import-corporate" style="width: 25%; padding: 10px;">
					<label for="corporate-demo"><?php esc_html_e( 'Corporate style variant', 'polo_importer' ); ?></label>
					<select class="widefat" name="corporate_demo" id="corporate-demo">

						<option class="widefat" value="corporate_v1"><?php esc_html_e( 'Corporate', 'polo_importer' ) ?> v1</option>
						<option class="widefat" value="corporate_v2"><?php esc_html_e( 'Corporate', 'polo_importer' ) ?> v2</option>
						<option class="widefat" value="corporate_v3"><?php esc_html_e( 'Corporate', 'polo_importer' ) ?> v3</option>
						<option class="widefat" value="corporate_v4"><?php esc_html_e( 'Corporate', 'polo_importer' ) ?> v4</option>
						<option class="widefat" value="corporate_v5"><?php esc_html_e( 'Corporate', 'polo_importer' ) ?> v5</option>
						<option class="widefat" value="corporate_v6"><?php esc_html_e( 'Corporate', 'polo_importer' ) ?> v6</option>
						<option class="widefat" value="corporate_v7"><?php esc_html_e( 'Corporate', 'polo_importer' ) ?> v7</option>
						<option class="widefat" value="corporate_v8"><?php esc_html_e( 'Corporate', 'polo_importer' ) ?> v8</option>
						<option class="widefat" value="corporate_home">Home Corporate</option>
						<option class="widefat" value="business">Home Business</option>

					</select>
				</div>

				<div id="import-creative" style="width: 25%; padding: 10px;">
					<label for="creative-demo"><?php esc_html_e( 'Creative style variant', 'polo_importer' ); ?></label>
					<select class="widefat" name="creative_demo" id="creative-demo">

						<option class="widefat" value="creative_v1"><?php esc_html_e( 'Creative', 'polo_importer' ) ?> v1</option>
						<option class="widefat" value="creative_v2"><?php esc_html_e( 'Creative', 'polo_importer' ) ?> v2</option>
						<option class="widefat" value="creative_v3"><?php esc_html_e( 'Creative', 'polo_importer' ) ?> v3</option>
						<option class="widefat" value="creative_v4"><?php esc_html_e( 'Creative', 'polo_importer' ) ?> v4</option>
						<option class="widefat" value="creative_v5"><?php esc_html_e( 'Creative', 'polo_importer' ) ?> v5</option>

					</select>
				</div>

				<div id="import-shop" style="width: 25%; padding: 10px;">
					<label for="shop-demo"><?php esc_html_e( 'Shop style variant', 'polo_importer' ); ?></label>
					<select class="widefat" name="shop_demo" id="shop-demo">

						<option class="widefat" value="shop_v1"><?php esc_html_e( 'Shop', 'polo_importer' ) ?> v1</option>
						<option class="widefat" value="shop_v2"><?php esc_html_e( 'Shop', 'polo_importer' ) ?> v2</option>
						<option class="widefat" value="shop_v3"><?php esc_html_e( 'Shop', 'polo_importer' ) ?> v3</option>
						<option class="widefat" value="shop_v4"><?php esc_html_e( 'Shop', 'polo_importer' ) ?> v4</option>

					</select>
					<span><?php echo 'Please, install <a href="https://wordpress.org/plugins/woocommerce/">Woocommerce</a> for this import type.'; ?></span>
					<span>For maximum compatibility install <a href="https://wordpress.org/plugins/yith-woocommerce-quick-view/">YITH WooCommerce Quick View</a> and <a href="https://wordpress.org/plugins/yith-woocommerce-wishlist/">YITH WooCommerce Wishlist</a></span>
				</div>

				<div id="import-portfolio" style="width: 25%; padding: 10px;">
					<label for="portfolio-demo"><?php esc_html_e( 'Portfolio style variant', 'polo_importer' ); ?></label>
					<select class="widefat" name="portfolio_demo" id="portfolio-demo">

						<option class="widefat" value="portfolio_v1"><?php esc_html_e( 'Portfolio', 'polo_importer' ) ?> v1</option>
						<option class="widefat" value="portfolio_v2"><?php esc_html_e( 'Portfolio', 'polo_importer' ) ?> v2</option>
						<option class="widefat" value="portfolio_v3"><?php esc_html_e( 'Portfolio', 'polo_importer' ) ?> v3</option>
						<option class="widefat" value="portfolio_v4"><?php esc_html_e( 'Portfolio', 'polo_importer' ) ?> v4</option>
						<option class="widefat" value="portfolio_v5"><?php esc_html_e( 'Portfolio', 'polo_importer' ) ?> v5</option>
						<option class="widefat" value="portfolio_v6"><?php esc_html_e( 'Portfolio', 'polo_importer' ) ?> v6</option>
						<option class="widefat" value="portfolio_v7"><?php esc_html_e( 'Portfolio', 'polo_importer' ) ?> v7</option>
						<option class="widefat" value="portfolio_v8"><?php esc_html_e( 'Portfolio', 'polo_importer' ) ?> v8</option>
						<option class="widefat" value="portfolio_v9"><?php esc_html_e( 'Portfolio', 'polo_importer' ) ?> v9</option>
						<option class="widefat" value="portfolio_v10"><?php esc_html_e( 'Portfolio Agency', 'polo_importer' ) ?></option>
						<option class="widefat" value="portfolio_v11"><?php esc_html_e( 'Agency v3', 'polo_importer' ) ?></option>
						<option class="widefat" value="portfolio_v12"><?php esc_html_e( 'Agency v4', 'polo_importer' ) ?></option>
						<option class="widefat" value="portfolio_v13"><?php esc_html_e( 'Developers', 'polo_importer' ) ?></option>

					</select>
				</div>

				<div id="import-hero" style="width: 25%; padding: 10px;">
					<label for="hero-demo"><?php esc_html_e( 'Pages with Custom sliders', 'polo_importer' ); ?></label>
					<select class="widefat" name="hero_demo" id="hero-demo">

						<option class="widefat" value="hero_v1"><?php esc_html_e( 'Youtube video background', 'polo_importer' ) ?> v1</option>
						<option class="widefat" value="hero_v2"><?php esc_html_e( 'Fullscreen parallax', 'polo_importer' ) ?> v2</option>
						<option class="widefat" value="hero_v3"><?php esc_html_e( 'Image carousel', 'polo_importer' ) ?> v3</option>
						<option class="widefat" value="hero_v4"><?php esc_html_e( 'Parallax', 'polo_importer' ) ?> v4</option>
						<option class="widefat" value="hero_v5"><?php esc_html_e( 'Parallax dark', 'polo_importer' ) ?> v5</option>
						<option class="widefat" value="hero_v6"><?php esc_html_e( 'Parallax dark fullwidth', 'polo_importer' ) ?> v6</option>
						<option class="widefat" value="hero_v7"><?php esc_html_e( 'Particles', 'polo_importer' ) ?> v7</option>
						<option class="widefat" value="hero_v8"><?php esc_html_e( 'Text rotator', 'polo_importer' ) ?> v8</option>
						<option class="widefat" value="hero_v9"><?php esc_html_e( 'Text rotator dark', 'polo_importer' ) ?> v9</option>
						<option class="widefat" value="hero_v10"><?php esc_html_e( 'Video background', 'polo_importer' ) ?> v10</option>
						<option class="widefat" value="hero_v11"><?php esc_html_e( 'Video background dark', 'polo_importer' ) ?> v11</option>
						<option class="widefat" value="hero_v12"><?php esc_html_e( 'Video carousel', 'polo_importer' ) ?> v12</option>

					</select>
				</div>

				<div id="import-niche" style="width: 25%; padding: 10px;">
					<label for="corporate-demo"><?php esc_html_e( 'Niche style variant', 'polo_importer' ); ?></label>
					<select class="widefat" name="corporate_demo" id="niche-demo">

						<option class="widefat" value="niche_v1"><?php esc_html_e( 'Application', 'polo_importer' ) ?></option>
						<option class="widefat" value="niche_v2"><?php esc_html_e( 'Branding', 'polo_importer' ) ?></option>
						<option class="widefat" value="niche_v3"><?php esc_html_e( 'Construction', 'polo_importer' ) ?></option>
						<option class="widefat" value="niche_v4"><?php esc_html_e( 'Design studio', 'polo_importer' ) ?></option>
						<option class="widefat" value="niche_v5"><?php esc_html_e( 'Nature', 'polo_importer' ) ?></option>
						<option class="widefat" value="niche_v6"><?php esc_html_e( 'Resume', 'polo_importer' ) ?></option>
						<option class="widefat" value="niche_v7"><?php esc_html_e( 'Web design', 'polo_importer' ) ?></option>

					</select>
				</div>

				<div id="import-magazine" style="width: 25%; padding: 10px;">
					<label for="magazine-demo"><?php esc_html_e( 'Magazine templates style variant', 'polo_importer' ); ?></label>
					<select class="widefat" name="magazine_demo" id="magazine-demo">

						<option class="widefat" value="magazine_1"><?php esc_html_e( 'Home blog', 'polo_importer' ) ?></option>
						<option class="widefat" value="magazine_2"><?php esc_html_e( 'Home blog v2', 'polo_importer' ) ?></option>
						<option class="widefat" value="magazine_3"><?php esc_html_e( 'Home blog v3', 'polo_importer' ) ?></option>
						<option class="widefat" value="magazine_4"><?php esc_html_e( 'Home blog v4', 'polo_importer' ) ?></option>
						<option class="widefat" value="magazine_5"><?php esc_html_e( 'Home blog v5', 'polo_importer' ) ?></option>
						<option class="widefat" value="magazine_6"><?php esc_html_e( 'Home blog v6', 'polo_importer' ) ?></option>
						<option class="widefat" value="magazine_7"><?php esc_html_e( 'Home blog v7', 'polo_importer' ) ?></option>
						<option class="widefat" value="magazine_8"><?php esc_html_e( 'Home blog v8', 'polo_importer' ) ?></option>
						<option class="widefat" value="magazine_9"><?php esc_html_e( 'Home magazine', 'polo_importer' ) ?></option>
						<option class="widefat" value="magazine_10"><?php esc_html_e( 'Home magazine v2', 'polo_importer' ) ?></option>
						<option class="widefat" value="magazine_11"><?php esc_html_e( 'Home magazine v3', 'polo_importer' ) ?></option>
						<option class="widefat" value="magazine_12"><?php esc_html_e( 'Home magazine v4', 'polo_importer' ) ?></option>

					</select>
				</div>

				<div id="import-onepage" style="width: 25%; padding: 10px;">
					<label for="onepage-demo"><?php esc_html_e( 'One Page style variant', 'polo_importer' ); ?></label>
					<select class="widefat" name="onepage_demo" id="onepage-demo">

						<option class="widefat" value="onepage_1"><?php esc_html_e( 'Home One Page', 'polo_importer' ) ?></option>
						<option class="widefat" value="onepage_2"><?php esc_html_e( 'Home One Page v2', 'polo_importer' ) ?></option>
						<option class="widefat" value="onepage_3"><?php esc_html_e( 'Home One Page v3', 'polo_importer' ) ?></option>

					</select>
				</div>
			</div>

			<tbody>

			<tr class="loading-row">
				<td></td>
				<td>
					<div class="import_load">
						<span><?php _e( 'The import process may take some time. Please be patient.', 'qode' ) ?> </span><br />
						<div class="qode-progress-bar-wrapper html5-progress-bar">
							<div class="progress-bar-wrapper">
								<progress id="progressbar" value="0" max="100"></progress>
								<span class="progress-value">0%</span>
							</div>
							<div class="progress-bar-message">
							</div>
						</div>
					</div>
				</td>
			</tr>
			</tbody>

			<?php

			if ( ! empty( $this->imported_demos ) ) { ?>

				<div style="background-color: #FAFFFB; margin:10px 0;padding: 5px 10px;color: #8AB38A;border: 2px solid #a1d3a2; clear:both; width:90%; line-height:18px;">
				<p><?php _e( 'Demo already imported', 'radium' ); ?></p>
				</div><?php
				//return;

			}
		}

		/**
		 * demo_installer Output
		 *
		 * @since 0.0.2
		 *
		 * @return null
		 */
		public function demo_installer() {

			wp_enqueue_script( 'crum-importer-admin' );

			$action = isset( $_REQUEST['action'] ) ? $_REQUEST['action'] : '';

			if ( ! empty( $this->imported_demos ) ) {

				$button_text = __( 'Import Again', 'radium' );

			} else {

				$button_text = __( 'Import Demo Data', 'radium' );

			}

			?>
			<div id="icon-tools" class="icon32"><br></div>
			<h2>Import Demo Data</h2>

			<div class="radium-importer-wrap" data-demo-id="1" data-nonce="<?php echo wp_create_nonce( 'radium-demo-code' ); ?>">

				<form method="post">
					<?php $this->intro_html(); ?>
					<input type="hidden" name="demononce" value="<?php echo wp_create_nonce( 'radium-demo-code' ); ?>" />
					<input id="import_demo_data" name="reset" class="panel-save button-primary radium-import-start" type="submit" value="<?php echo $button_text; ?>" />
					<input type="hidden" name="action" value="demo-data" />

					<br />
					<br />
					<div class="radium-importer-message clear">
						<?php if ( 'demo-data' == $action && check_admin_referer( 'radium-demo-code', 'demononce' ) ) {
							$this->process_imports();
						} ?>
					</div>
				</form>

				<script type="text/javascript">
					(function ($j) {
						$j(document).ready(function () {
							$j(document).on('click', '#import_demo_data', function (e) {
								e.preventDefault();
								if (confirm('Are you sure, you want to import Demo Data now?')) {
									$j('#import_demo_data').attr("disabled", true).attr("value", "In progress");
									$j('.import_load').css('display', 'block');
									var progressbar = $j('#progressbar');
									var p = 0;

									var demo_style = $j("#demo-style").val();
									var corporate_style = $j("#corporate-demo").val();
									var creative_style = $j("#creative-demo").val();
									var portfolio_style = $j("#portfolio-demo").val();
									var hero_style = $j("#hero-demo").val();
									var shop_style = $j("#shop-demo").val();
									var niche_style = $j("#niche-demo").val();
									var magazine_style = $j("#magazine-demo").val();
									var onepage_style = $j("#onepage-demo").val();

									jQuery.ajax({
										url    : ajaxurl,
										data   : {
											action: 'crum_deactivate_installer'
										},
										success: function (data, textStatus, XMLHttpRequest) {
											var str;
											str = 'content.xml';
											$j('.progress-bar-message').html('<br />Importing posts and pages.');
											jQuery.ajax({
												type   : 'POST',
												url    : ajaxurl,
												data   : {
													action: 'crum_dataImport',
													xml   : str,
													demo  : demo_style

												},
												success: function (data, textStatus, XMLHttpRequest) {
													p = 20;
													$j('.progress-value').html((p) + '%');
													progressbar.val(p);
													$j('.progress-bar-message').html('<br />Importing posts and pages.');
													jQuery.ajax({
														type   : 'POST',
														url    : ajaxurl,
														data   : {
															action: 'crum_slidersImport',
															demo  : demo_style

														},
														success: function (data, textStatus, XMLHttpRequest) {
															p = 40;
															$j('.progress-value').html((p) + '%');
															progressbar.val(p);
															$j('.progress-bar-message').html('<br />Importing menus.');
															jQuery.ajax({
																type   : 'POST',
																url    : ajaxurl,
																data   : {
																	action        : 'crum_menusImport',
																	corporate_demo: corporate_style,
																	creative_demo : creative_style,
																	portfolio_demo: portfolio_style,
																	hero_demo     : hero_style,
																	shop_demo     : shop_style,
																	niche_demo    : niche_style,
																	magazine_demo : magazine_style,
																	onepage_demo  : onepage_style,
																	demo          : demo_style

																},
																success: function (data, textStatus, XMLHttpRequest) {
																	p = 60;
																	$j('.progress-value').html((p) + '%');
																	progressbar.val(p);
																	$j('.progress-bar-message').html('<br />Importing demo options.');
																	jQuery.ajax({
																		type   : 'POST',
																		url    : ajaxurl,
																		data   : {
																			action: 'crum_otherImport',
																			demo  : demo_style

																		},
																		success: function (data, textStatus, XMLHttpRequest) {
																			p = 80;
																			$j('.progress-value').html((p) + '%');
																			progressbar.val(p);
																			$j('.progress-bar-message').html('<br />Importing widgets.');
																			jQuery.ajax({
																				type   : 'POST',
																				url    : ajaxurl,
																				data   : {
																					action: 'crum_widgetsImport',
																					demo  : demo_style

																				},
																				success: function (data, textStatus, XMLHttpRequest) {
																					$j('.progress-value').html((100) + '%');
																					progressbar.val(100);
																					$j('.progress-bar-message').html('<br />Import is completed.');
																				},
																				error  : function (MLHttpRequest, textStatus, errorThrown) {
																				}
																			});
																		},
																		error  : function (MLHttpRequest, textStatus, errorThrown) {
																		}
																	});
																},
																error  : function (MLHttpRequest, textStatus, errorThrown) {
																}
															});
														},
														error  : function (MLHttpRequest, textStatus, errorThrown) {
														}
													});
												},
												error  : function (MLHttpRequest, textStatus, errorThrown) {
												}
											});
										},
										error  : function (MLHttpRequest, textStatus, errorThrown) {
										}
									});

								}
								return false;
							});
						});
					})(jQuery);
				</script>

			</div>

			<br />
			<br /><?php

		}

		/**
		 * Process all imports
		 *
		 * @params $content
		 * @params $options
		 * @params $widgets
		 *
		 * @since 0.0.3
		 *
		 * @return null
		 */
		public function process_imports( $content = true, $options = true, $widgets = true ) {

			if ( $content && ! empty( $this->content_demo ) && is_file( $this->content_demo ) ) {
				$this->set_demo_data( $this->content_demo );
			}

			if ( $options && ! empty( $this->theme_options_file ) && is_file( $this->theme_options_file ) ) {
				$this->set_demo_theme_options( $this->theme_options_file );
			}

			if ( $options ) {
				$this->set_demo_menus();
				$this->set_demo_homepage();
				$this->set_demo_sliders();
				$this->crum_say_hello();
			}

			if ( $widgets && ! empty( $this->widgets ) && is_file( $this->widgets ) ) {
				$this->process_widget_import_file( $this->widgets );
			}

			do_action( 'radium_import_end' );

		}

		/**
		 * add_widget_to_sidebar Import sidebars
		 *
		 * @param  string $sidebar_slug    Sidebar slug to add widget
		 * @param  string $widget_slug     Widget slug
		 * @param  string $count_mod       position in sidebar
		 * @param  array  $widget_settings widget settings
		 *
		 * @since 0.0.2
		 *
		 * @return null
		 */
		public function add_widget_to_sidebar( $sidebar_slug, $widget_slug, $count_mod, $widget_settings = array() ) {

			$sidebars_widgets = get_option( 'sidebars_widgets' );

			if ( ! isset( $sidebars_widgets[ $sidebar_slug ] ) ) {
				$sidebars_widgets[ $sidebar_slug ] = array( '_multiwidget' => 1 );
			}

			$newWidget = get_option( 'widget_' . $widget_slug );

			if ( ! is_array( $newWidget ) ) {
				$newWidget = array();
			}

			$count                               = count( $newWidget ) + 1 + $count_mod;
			$sidebars_widgets[ $sidebar_slug ][] = $widget_slug . '-' . $count;

			$newWidget[ $count ] = $widget_settings;

			update_option( 'sidebars_widgets', $sidebars_widgets );
			update_option( 'widget_' . $widget_slug, $newWidget );

		}

		public function set_demo_data( $file ) {

			if ( ! defined( 'WP_LOAD_IMPORTERS' ) ) {
				define( 'WP_LOAD_IMPORTERS', true );
			}

			require_once ABSPATH . 'wp-admin/includes/import.php';

			$importer_error = false;

			if ( ! class_exists( 'WP_Importer' ) ) {

				$class_wp_importer = ABSPATH . 'wp-admin/includes/class-wp-importer.php';

				if ( file_exists( $class_wp_importer ) ) {

					require_once( $class_wp_importer );

				} else {

					$importer_error = true;

				}

			}

			if ( ! class_exists( 'WP_Import' ) ) {

				$class_wp_import = dirname( __FILE__ ) . '/wordpress-importer.php';

				if ( file_exists( $class_wp_import ) ) {
					require_once( $class_wp_import );
				} else {
					$importer_error = true;
				}

			}

			if ( $importer_error ) {

				die( "Error on import" );

			} else {

				if ( ! is_file( $file ) ) {

					echo "The XML file containing the dummy content is not available or could not be read .. You might want to try to set the file permission to chmod 755.<br/>If this doesn't work please use the Wordpress importer and import the XML file (should be located in your download .zip: Sample Content folder) manually ";

				} else {

					$wp_import                    = new WP_Import();
					$wp_import->fetch_attachments = true;
					$wp_import->import( $file );
					$this->flag_as_imported['content'] = true;

				}

			}

			do_action( 'radium_importer_after_theme_content_import' );


		}

		public function set_demo_menus( $demo ) {
		}

		public function set_demo_homepage( $demo, $demo_style ) {
		}

		public function set_demo_sliders( $demo ) {
		}

		public function crum_say_hello() {
		}

		public function set_demo_theme_options( $file ) {

			// Does the File exist?
			if ( file_exists( $file ) ) {

				// Get file contents and decode
				$data = file_get_contents( $file );

				if ( $this->theme_options_framework == 'radium' ) {

					//radium framework
					$data = unserialize( trim( $data, '###' ) );

				} elseif ( $this->theme_options_framework == 'optiontree' ) {

					//option tree import
					$data = $this->optiontree_decode( $data );

					update_option( ot_options_id(), $data );

					$this->flag_as_imported['options'] = true;

				} else {

					//other frameworks
					//$data = json_decode( $data, true );
					//$data = maybe_unserialize( $data );
					$data = cs_decode_string( $data );

				}

				// Only if there is data
				if ( ! empty( $data ) || is_array( $data ) ) {

					// Hook before import
					$data = apply_filters( 'radium_theme_import_theme_options', $data );

					update_option( $this->theme_option_name, $data );

					$this->flag_as_imported['options'] = true;
				}

				do_action( 'radium_importer_after_theme_options_import', $this->active_import, $this->demo_files_path );

			} else {

				wp_die(
					__( 'Theme options Import file could not be found. Please try again.', 'radium' ),
					'',
					array( 'back_link' => true )
				);
			}

		}

		/**
		 * Available widgets
		 *
		 * Gather site's widgets into array with ID base, name, etc.
		 * Used by export and import functions.
		 *
		 * @since 0.0.2
		 *
		 * @global array $wp_registered_widget_updates
		 * @return array Widget information
		 */
		function available_widgets() {

			global $wp_registered_widget_controls;

			$widget_controls = $wp_registered_widget_controls;

			$available_widgets = array();

			foreach ( $widget_controls as $widget ) {

				if ( ! empty( $widget['id_base'] ) && ! isset( $available_widgets[ $widget['id_base'] ] ) ) { // no dupes

					$available_widgets[ $widget['id_base'] ]['id_base'] = $widget['id_base'];
					$available_widgets[ $widget['id_base'] ]['name']    = $widget['name'];

				}

			}

			return apply_filters( 'radium_theme_import_widget_available_widgets', $available_widgets );

		}


		/**
		 * Process import file
		 *
		 * This parses a file and triggers importation of its widgets.
		 *
		 * @since 0.0.2
		 *
		 * @param string  $file Path to .wie file uploaded
		 *
		 * @global string $widget_import_results
		 */
		function process_widget_import_file( $file ) {

			// File exists?
			if ( ! file_exists( $file ) ) {
				wp_die(
					__( 'Widget Import file could not be found. Please try again.', 'radium' ),
					'',
					array( 'back_link' => true )
				);
			}

			// Get file contents and decode
			$data = file_get_contents( $file );
			$data = json_decode( $data );

			// Delete import file
			//unlink( $file );

			// Import the widget data
			// Make results available for display on import/export page
			$this->widget_import_results = $this->import_widgets( $data );

		}


		/**
		 * Import widget JSON data
		 *
		 * @since 0.0.2
		 * @global array $wp_registered_sidebars
		 *
		 * @param object $data JSON widget data from .json file
		 *
		 * @return array Results array
		 */
		public function import_widgets( $data ) {

			global $wp_registered_sidebars;

			// Have valid data?
			// If no data or could not decode
			if ( empty( $data ) || ! is_object( $data ) ) {
				return;
			}

			// Hook before import
			$data = apply_filters( 'radium_theme_import_widget_data', $data );

			// Get all available widgets site supports
			$available_widgets = $this->available_widgets();

			// Get all existing widget instances
			$widget_instances = array();
			foreach ( $available_widgets as $widget_data ) {
				$widget_instances[ $widget_data['id_base'] ] = get_option( 'widget_' . $widget_data['id_base'] );
			}

			// Begin results
			$results = array();

			// Loop import data's sidebars
			foreach ( $data as $sidebar_id => $widgets ) {

				// Skip inactive widgets
				// (should not be in export file)
				if ( 'wp_inactive_widgets' == $sidebar_id ) {
					continue;
				}

				// Check if sidebar is available on this site
				// Otherwise add widgets to inactive, and say so
				if ( isset( $wp_registered_sidebars[ $sidebar_id ] ) ) {
					$sidebar_available    = true;
					$use_sidebar_id       = $sidebar_id;
					$sidebar_message_type = 'success';
					$sidebar_message      = '';
				} else {
					$sidebar_available    = false;
					$use_sidebar_id       = 'wp_inactive_widgets'; // add to inactive if sidebar does not exist in theme
					$sidebar_message_type = 'error';
					$sidebar_message      = __( 'Sidebar does not exist in theme (using Inactive)', 'radium' );
				}

				// Result for sidebar
				$results[ $sidebar_id ]['name']         = ! empty( $wp_registered_sidebars[ $sidebar_id ]['name'] ) ? $wp_registered_sidebars[ $sidebar_id ]['name'] : $sidebar_id; // sidebar name if theme supports it; otherwise ID
				$results[ $sidebar_id ]['message_type'] = $sidebar_message_type;
				$results[ $sidebar_id ]['message']      = $sidebar_message;
				$results[ $sidebar_id ]['widgets']      = array();

				// Loop widgets
				foreach ( $widgets as $widget_instance_id => $widget ) {

					$fail = false;

					// Get id_base (remove -# from end) and instance ID number
					$id_base            = preg_replace( '/-[0-9]+$/', '', $widget_instance_id );
					$instance_id_number = str_replace( $id_base . '-', '', $widget_instance_id );

					// Does site support this widget?
					if ( ! $fail && ! isset( $available_widgets[ $id_base ] ) ) {
						$fail                = true;
						$widget_message_type = 'error';
						$widget_message      = __( 'Site does not support widget', 'radium' ); // explain why widget not imported
					}

					// Filter to modify settings before import
					// Do before identical check because changes may make it identical to end result (such as URL replacements)
					$widget = apply_filters( 'radium_theme_import_widget_settings', $widget );

					// Does widget with identical settings already exist in same sidebar?
					if ( ! $fail && isset( $widget_instances[ $id_base ] ) ) {

						// Get existing widgets in this sidebar
						$sidebars_widgets = get_option( 'sidebars_widgets' );
						$sidebar_widgets  = isset( $sidebars_widgets[ $use_sidebar_id ] ) ? $sidebars_widgets[ $use_sidebar_id ] : array(); // check Inactive if that's where will go

						// Loop widgets with ID base
						$single_widget_instances = ! empty( $widget_instances[ $id_base ] ) ? $widget_instances[ $id_base ] : array();
						foreach ( $single_widget_instances as $check_id => $check_widget ) {

							// Is widget in same sidebar and has identical settings?
							if ( in_array( "$id_base-$check_id", $sidebar_widgets ) && (array) $widget == $check_widget ) {

								$fail                = true;
								$widget_message_type = 'warning';
								$widget_message      = __( 'Widget already exists', 'radium' ); // explain why widget not imported

								break;

							}

						}

					}

					// No failure
					if ( ! $fail ) {

						// Add widget instance
						$single_widget_instances   = get_option( 'widget_' . $id_base ); // all instances for that widget ID base, get fresh every time
						$single_widget_instances   = ! empty( $single_widget_instances ) ? $single_widget_instances : array( '_multiwidget' => 1 ); // start fresh if have to
						$single_widget_instances[] = (array) $widget; // add it

						// Get the key it was given
						end( $single_widget_instances );
						$new_instance_id_number = key( $single_widget_instances );

						// If key is 0, make it 1
						// When 0, an issue can occur where adding a widget causes data from other widget to load, and the widget doesn't stick (reload wipes it)
						if ( '0' === strval( $new_instance_id_number ) ) {
							$new_instance_id_number                             = 1;
							$single_widget_instances[ $new_instance_id_number ] = $single_widget_instances[0];
							unset( $single_widget_instances[0] );
						}

						// Move _multiwidget to end of array for uniformity
						if ( isset( $single_widget_instances['_multiwidget'] ) ) {
							$multiwidget = $single_widget_instances['_multiwidget'];
							unset( $single_widget_instances['_multiwidget'] );
							$single_widget_instances['_multiwidget'] = $multiwidget;
						}

						// Update option with new widget
						update_option( 'widget_' . $id_base, $single_widget_instances );

						// Assign widget instance to sidebar
						$sidebars_widgets                      = get_option( 'sidebars_widgets' ); // which sidebars have which widgets, get fresh every time
						$new_instance_id                       = $id_base . '-' . $new_instance_id_number; // use ID number from new widget instance
						$sidebars_widgets[ $use_sidebar_id ][] = $new_instance_id; // add new instance to sidebar
						update_option( 'sidebars_widgets', $sidebars_widgets ); // save the amended data

						// Success message
						if ( $sidebar_available ) {
							$widget_message_type = 'success';
							$widget_message      = __( 'Imported', 'radium' );
						} else {
							$widget_message_type = 'warning';
							$widget_message      = __( 'Imported to Inactive', 'radium' );
						}

					}

					// Result for widget instance
					$results[ $sidebar_id ]['widgets'][ $widget_instance_id ]['name']         = isset( $available_widgets[ $id_base ]['name'] ) ? $available_widgets[ $id_base ]['name'] : $id_base; // widget name or ID if name not available (not supported by site)
					$results[ $sidebar_id ]['widgets'][ $widget_instance_id ]['title']        = $widget->title ? $widget->title : __( 'No Title', 'radium' ); // show "No Title" if widget instance is untitled
					$results[ $sidebar_id ]['widgets'][ $widget_instance_id ]['message_type'] = $widget_message_type;
					$results[ $sidebar_id ]['widgets'][ $widget_instance_id ]['message']      = $widget_message;

				}

			}

			$this->flag_as_imported['widgets'] = true;

			// Hook after import
			do_action( 'radium_theme_import_widget_after_import' );

			// Return results
			return apply_filters( 'radium_theme_import_widget_results', $results );

		}

		/**
		 * Helper function to return option tree decoded strings
		 *
		 * @return    string
		 *
		 * @access    public
		 * @since     0.0.3
		 * @updated   0.0.3.1
		 */
		public function optiontree_decode( $value ) {

			$func          = 'base64' . '_decode';
			$prepared_data = maybe_unserialize( $func( $value ) );

			return $prepared_data;

		}

	}//class

}//function_exists
