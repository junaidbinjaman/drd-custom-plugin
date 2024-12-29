<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://junaidbinjaman.com
 * @since             1.0.0
 * @package           Drd
 *
 * @wordpress-plugin
 * Plugin Name:       DRD Custom Plugin
 * Plugin URI:        https://github.com/junaidbinjaman/drd-custom-plugin
 * Description:       A Custom Plugin Developed for DRD client. All Right Reserved.
 * Version:           1.0.0
 * Author:            Junaid Bin Jaman
 * Author URI:        https://junaidbinjaman.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       drd
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'DRD_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-drd-activator.php
 */
function activate_drd() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-drd-activator.php';
	Drd_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-drd-deactivator.php
 */
function deactivate_drd() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-drd-deactivator.php';
	Drd_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_drd' );
register_deactivation_hook( __FILE__, 'deactivate_drd' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-drd.php';


/**
 * The codestar framework integration.
 * The code bellow integration the codestar framework
 */
require_once plugin_dir_path( __FILE__ ) . 'includes/libraries/codestar-framework/codestar-framework.php';


// The file registers a custom meta box for wholesale application post type.
require_once plugin_dir_path( __FILE__ ) . 'admin/partials/drd-wca-meta.php';

// Monolog handler class.
require_once plugin_dir_path( __FILE__ ) . 'includes/class-drd-logger.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_drd() {

	$plugin = new Drd();
	$plugin->run();
}

run_drd();

add_filter(
	'woocommerce_product_tabs',
	function ( $tabs ) {
		$post_id         = get_the_ID();
		$ingredient      = get_post_meta( $post_id, 'ingredients', true );
		$directions      = get_post_meta( $post_id, 'directions', true );
		$additional_info = get_post_meta( $post_id, '_additional_information', true );

		if ( isset( $ingredient ) && ! empty( $ingredient ) ) {
			$tabs['ingredients'] = array(
				'title'    => __( 'Ingredients', 'drd' ),
				'priority' => 50,
				'callback' => 'custom_tab_ingredient_content',
			);
		}

		if ( isset( $directions ) && ! empty( $directions ) ) {
			$tabs['direction'] = array(
				'title'    => __( 'DIrection', 'drd' ),
				'priority' => 51,
				'callback' => 'custom_tab_directions_content',
			);
		}

		if ( isset( $additional_info ) && ! empty( $additional_info ) ) {
			$tabs['_additional_information'] = array(
				'title'    => __( 'Additional Information', 'drd' ),
				'priority' => 52,
				'callback' => 'custom_tab_additional_info_content',
			);
		}

		unset( $tabs['additional_information'] );

		return $tabs;
	}
);

/**
 * Ingredient tab content.
 *
 * @return void
 */
function custom_tab_ingredient_content() {
	$post_id = get_the_ID();

	$value = get_post_meta( $post_id, 'ingredients', true );

	echo wp_kses(
		$value,
		array(
			'ul'     => array(),
			'li'     => array(),
			'strong' => array(),
			'hr'     => array(),
			'h3'     => array(),
			'h2'     => array(),
			'h1'     => array(),
			'p1'     => array(),
		)
	);
}

/**
 * Direction tab content
 *
 * @return void
 */
function custom_tab_directions_content() {
	$post_id = get_the_ID();

	$value = get_post_meta( $post_id, 'directions', true );

	echo wp_kses(
		$value,
		array(
			'ul'     => array(),
			'li'     => array(),
			'strong' => array(),
			'hr'     => array(),
			'h3'     => array(),
			'h2'     => array(),
			'h1'     => array(),
			'p1'     => array(),
		)
	);
}

/**
 * Additional Info tab content
 *
 * @return void
 */
function custom_tab_additional_info_content() {
	$post_id = get_the_ID();

	$value = get_post_meta( $post_id, '_additional_information', true );

	echo wp_kses(
		$value,
		array(
			'ul'     => array(),
			'li'     => array(),
			'strong' => array(),
			'hr'     => array(),
			'h3'     => array(),
			'h2'     => array(),
			'h1'     => array(),
			'p1'     => array(),
		)
	);
}
