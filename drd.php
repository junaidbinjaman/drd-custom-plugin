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
// phpcs:disabled


// add_action(
// 	'init',
// 	function () {
// 		$meta_data = array(
// 			'first_name'              => 'John',
// 			'last_name'               => 'Doe',
// 			'email'                   => 'john.doe@example.com',
// 			'phone'                   => '1234567890',
// 			'billing_country'         => 'USA',
// 			'billing_address_line_1'  => '123 Main St',
// 			'billing_address_line_2'  => 'Apt 4B',
// 			'billing_city'            => 'New York',
// 			'billing_postal_code'     => '10001',
// 			'shipping_country'        => 'USA',
// 			'shipping_address_line_1' => '456 Elm St',
// 			'shipping_address_line_2' => 'Suite 5A',
// 			'shipping_city'           => 'Los Angeles',
// 			'shipping_postal_code'    => '90001',
// 			'sellers_type'            => 'Retailer',
// 			'practitioner_type'       => 'Medical',
// 			'title'                   => 'Doctor',
// 			'website'                 => 'https://example.com',
// 			'article'                 => 'I have been practicing for over 10 years.',
// 			'notes'                   => 'This is a sample note.',
// 		);

// 		$post_arr = array(
// 			'post_title'   => 'Wholesale Application Test Post',
// 			'post_content' => 'This is a test application for wholesale customer.',
// 			'post_status'  => 'publish',
// 			'post_type'    => 'wholesaleapplication',
// 			'post_author'  => get_current_user_id(),
// 			'meta_input'   => array(
// 				'wac_meta_fields' => $meta_data,
// 			),
// 		);

// 		wp_insert_post( $post_arr );
// 	}
// );

// function add_new_sendy_form_action( $form_actions_registrar ) {
// 	include_once( __DIR__ . '/admin/partials/elementor-form-actions/insert-new-post-action.php' );

// 	$form_actions_registrar->register( new New_Post_Action_After_Submit() );
// }

// add_action( 'elementor_pro/forms/actions/register', 'add_new_sendy_form_action' );

add_filter('woocommerce_product_tabs', function($tabs) {
	$post_id = get_the_ID();
	$ingredient = get_post_meta( $post_id, 'ingredients', true );
	$directions = get_post_meta( $post_id, 'directions', true );
	$additional_info = get_post_meta( $post_id, '_additional_information', true );

	if (isset( $ingredient ) && ! empty($ingredient)) {
		$tabs['ingredients'] = array(
			'title' => __( 'Ingredients', 'drd' ),
			'priority' => 50,
			'callback' => 'custom_tab_ingredient_content'
		);
	}

	if (isset( $directions ) && ! empty($directions)) {
		$tabs['direction'] = array(
			'title' => __( 'DIrection', 'drd' ),
			'priority' => 51,
			'callback' => 'custom_tab_directions_content'
		);
	}

	if (isset( $additional_info ) && ! empty($additional_info)) {
		$tabs['_additional_information'] = array(
			'title' => __( 'Additional Information', 'drd' ),
			'priority' => 52,
			'callback' => 'custom_tab_additional_info_content'
		);
	}

	unset($tabs['additional_information']);

	return $tabs;
});

function custom_tab_ingredient_content() {
	$post_id = get_the_ID();

	$value = get_post_meta( $post_id, 'ingredients', true );

	echo wp_kses( $value, array(
		'ul' => array(),
		'li' => array(),
		'strong' => array(),
		'hr' => array(),
		'h3' => array(),
		'h2' => array(),
		'h1' => array(),
		'p1' => array(),
	) );
}

function custom_tab_directions_content() {
	$post_id = get_the_ID();

	$value = get_post_meta( $post_id, 'directions', true );

	echo wp_kses( $value, array(
		'ul' => array(),
		'li' => array(),
		'strong' => array(),
		'hr' => array(),
		'h3' => array(),
		'h2' => array(),
		'h1' => array(),
		'p1' => array(),
	) );
}

function custom_tab_additional_info_content() {
	$post_id = get_the_ID();

	$value = get_post_meta( $post_id, '_additional_information', true );

	echo wp_kses( $value, array(
		'ul' => array(),
		'li' => array(),
		'strong' => array(),
		'hr' => array(),
		'h3' => array(),
		'h2' => array(),
		'h1' => array(),
		'p1' => array(),
	) );
}
