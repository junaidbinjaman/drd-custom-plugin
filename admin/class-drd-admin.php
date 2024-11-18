<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://junaidbinjaman.com
 * @since      1.0.0
 *
 * @package    Drd
 * @subpackage Drd/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Drd
 * @subpackage Drd/admin
 * @author     Junaid Bin Jaman <junaid@allnextver.com>
 */
class Drd_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string $plugin_name       The name of this plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Drd_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Drd_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/drd-admin.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Drd_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Drd_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/drd-admin.js', array( 'jquery' ), $this->version, false );
		wp_localize_script(
			$this->plugin_name,
			'ajax_object',
			array(
				'ajax_url' => admin_url( 'admin-ajax.php' ),
				'nonce'    => wp_create_nonce( 'my-nonce' ),
			)
		);
	}

	/**
	 * The function initializes all the meta boxes on admin screen.
	 *
	 * @return void
	 */
	public function meta_box_init() {
		$screens = array( 'post', 'wholesale-applicatio' );

		foreach ( $screens as $screen ) {
			add_meta_box(
				'wholesale_customer_reg_action',
				__( 'Action', 'drd' ),
				array( $this, 'wholesale_customer_red_action' ),
				$screen,
				'side',
			);
		}
	}

	/**
	 * Wholesale customer registration actions
	 *
	 * @return void
	 */
	public function wholesale_customer_red_action() {
		?>
		<p>Status: <strong>Pending</strong></p>
		<a href="#" class="drd-plugin-btn button button-primary">Approve</a>
		<a href="#" class="button button-primary">Reject</a>
		<?php
	}

	/**
	 * Undocumented function
	 *
	 * @return void
	 */
	public function foobar() {
		if ( ! check_ajax_referer( 'my-nonce', 'nonce', false ) ) {
			wp_send_json_error( 'Invalid nonce' );
		}

		$post_id = isset( $_POST['post_id'] ) ? sanitize_text_field( wp_unslash( $_POST['post_id'] ) ) : null;
		$post_id = intval( $post_id );

		if ( ! $post_id || ! is_numeric( $post_id ) ) {
			wp_send_json_error( array( 'message' => 'Invalid Post ID' ), 400 );
		}

		$user_data = isset( $_POST['user_data'] ) ? $_POST['user_data'] : null; //phpcs:ignore

		if ( ! $user_data ) {
			wp_send_json_error( array( 'message' => 'Invalid User Data' ) );
		}

		$user_data_array_key = array_keys( $user_data );
		$sanitized_user_data = array();

		foreach ( $user_data_array_key as $user_data_key ) {
			$sanitized_user_data[ $user_data_key ] = sanitize_text_field( wp_unslash( $user_data[ $user_data_key ] ) );
		}

		wp_send_json_success( array( 'message' => 'Successfully received data' ) );

		wp_die();
	}
}
