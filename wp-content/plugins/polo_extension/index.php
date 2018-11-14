<?php
/**
 *
 * @package   Crumina Polo extension
 * @author    Crumina <info@crumina.net>
 * @license   GPL-2.0+
 * @link      http://crumina.net
 * @copyright 2015 Crumina Team
 *
 * @wordpress-plugin
 * Plugin Name: Polo theme extension
 * Plugin URI:  http://crumina.net
 * Description: Extensions for Polo Crumina Theme
 * Version:     1.5
 * Author:      Crumina
 * Author URI:  http://crumina.net
 * Text Domain: polo_extension
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path: /lang
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

$curr_theme = wp_get_theme(get_template());
$theme_name = $curr_theme->get('Name');

if($theme_name == 'Polo' || $theme_name == 'polo') {


    if (!defined('PLUGIN_PATH')) {
        define("PLUGIN_PATH", plugin_dir_path(__FILE__));
    }
    if (!defined('PLUGIN_URL')) {
        define("PLUGIN_URL", plugin_dir_url(__FILE__));
    }

    // Plugin Activation
    function crum_omni_install()
    {
        global $wpdb;
        $table = $wpdb->prefix . "crumsubscribe";
        $structure = "CREATE TABLE $table (
            id INT(9) NOT NULL AUTO_INCREMENT,
            sml_name VARCHAR(200) NOT NULL,
            crum_email VARCHAR(200) NOT NULL,
        UNIQUE KEY id (id)
        );";
        $wpdb->query($structure);
    }

    add_action('init', 'polo_ext_load_textdomain');

    register_activation_hook(__FILE__, 'crum_omni_install');

    require_once(plugin_dir_path(__FILE__) . 'inc/mr-image-resize.php');
    require_once(plugin_dir_path(__FILE__) . 'inc/helpers.php');
    require_once(plugin_dir_path(__FILE__) . 'inc/attachment-categories.php');
    require_once(plugin_dir_path(__FILE__) . 'inc/shortcodes.php');

    //Visual composer row additional options
    require_once(plugin_dir_path(__FILE__) . 'visual-composer-addons/row-parallax.php');
    require_once(plugin_dir_path(__FILE__) . 'visual-composer-addons/crum-addons.php');

    //Portfolio
    require_once(plugin_dir_path(__FILE__) . 'inc/portfolio/crumina-portfolio.php');
    require_once(plugin_dir_path(__FILE__) . 'inc/portfolio/crumina-portfolio-thumbnail.php');
    require_once(plugin_dir_path(__FILE__) . 'inc/portfolio/crumina-portfolio-functions.php');

    add_action('admin_enqueue_scripts', 'crum_plugin_admin_scripts');
    add_action('wp_enqueue_scripts', 'crum_plugin_frontend_scripts');

    function crum_plugin_admin_scripts()
    {
        wp_enqueue_style('extension-admin', PLUGIN_URL . 'assets/css/admin/admin.css');
        wp_enqueue_style('extension-composer', PLUGIN_URL . 'assets/css/admin/crum_composer_styles.css');

        wp_enqueue_script('crum-js-composer-picker', PLUGIN_URL . 'assets/js/admin/image-picker.jquery.min.js', array('jquery'), false, true);
        wp_enqueue_script('crum-js-composer-switcher', PLUGIN_URL . 'assets/js/admin/switcher.min.js', array('jquery'), false, true);
        wp_enqueue_script('crum-extension-admin', PLUGIN_URL . 'assets/js/admin/admin.js', array('jquery'), false, true);
    }

    function crum_plugin_frontend_scripts()
    {
        wp_enqueue_style('extension-frontend', PLUGIN_URL . 'assets/css/frontend/frontend.css');

        wp_register_style('crum-nothing-you-could-do-font', 'http://fonts.googleapis.com/css?family=Nothing+You+Could+Do', array(), false, 'all');
        wp_register_style('crum-author-title', 'http://fonts.googleapis.com/css?family=Damion', array(), false, 'all');
    }

    /**
     * Load plugin textdomain.
     *
     * @since 1.0.0
     */
    function polo_ext_load_textdomain()
    {
        load_plugin_textdomain('polo_extension', false, dirname(plugin_basename(__FILE__)) . '/lang');
    }
}