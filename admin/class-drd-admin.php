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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/drd-admin.js', array( 'jquery', 'wp-util' ), $this->version, false );
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

		$this->register_user();

		wp_send_json_success( array( 'message' => 'Successfully received data' ) );

		wp_die();
	}

	/**
	 * The function register the user
	 *
	 * @return void
	 */
	public function register_user() {
		$user_data = array(
			'user_nicename' => 'ersome',
			'display_name'  => 'Ersome Rego',
			'nickname'      => 'ersome',
			'first_name'    => 'Ersome',
			'last_name'     => 'Rego',
			'role'          => 'wholesale_customer',
			'user_login'    => 'example',
			'user_pass'     => 'jwolt65859j',
			'user_email'    => 'example65859@gmail.com',
			'meta_input'    => array(
				'seller_permit'               => 'Permitted Seller',
				'practitioner_type'           => 'Practitioner types',
				'title'                       => 'Title',
				'website'                     => 'Website',
				'tell_us_about_your_practice' => 'About your practice',
				'notes'                       => 'Notes',
				'country'                     => 'Bangladesh',
				'billing_first_name'          => 'Billing Ersome',
				'billing_last_name'           => 'Billing Rego',
				'billing_address_1'           => 'House #35, Road 6, Block F, Banasree,',
				'billing_address_2'           => 'Dhaka Bangladesh.',
				'billing_country'             => 'Bangladesh',
				'billing_city'                => 'Dhaka',
				'billing_postcode'            => '1230',
				'billing_phone'               => '01705294083',
				'billing_email'               => 'example65859@gmail.com',
				'shipping_first_name'         => 'Shipping Ersome',
				'shipping_last_name'          => 'Shipping Rego',
				'shipping_company'            => 'Shipping Company',
				'shipping_address_1'          => 'Shipping Address',
				'shipping_address_2'          => 'Shipping Address 2',
				'shipping_city'               => 'Shipping Dhaka',
				'shipping_postcode'           => '1229',
				'shipping_country'            => 'Bangladesh',
				'shipping_phone'              => '00117733',
			),
		);

		wp_insert_user( $user_data );
	}

	/**
	 * The users meta html.
	 *
	 * @return void
	 */
	public function user_meta_html() {
		$user_id = $_GET['user_id']; //phpcs:ignore;

		if ( ! isset( $user_id ) ) {
			return;
		}

		$user_id = sanitize_text_field( $user_id );
		$user_id = esc_html( $user_id );

		$seller_permit               = get_user_meta( $user_id, 'seller_permit', true );
		$practitioner_type           = get_user_meta( $user_id, 'practitioner_type', true );
		$title                       = get_user_meta( $user_id, 'title', true );
		$website                     = get_user_meta( $user_id, 'website', true );
		$tell_us_about_your_practice = get_user_meta( $user_id, 'tell_us_about_your_practice', true );
		$notes                       = get_user_meta( $user_id, 'notes', true );
		$country                     = get_user_meta( $user_id, 'country', true );
		?>
		<div class="drd-wholesale-customer-meta-data">
			<h1>Wholesale Customer Registration</h1>
			<table>
				<tbody>
					<tr>
						<th>
							<label for="seller_permit">Seller's Permit</label>
						</th>
						<td>
							<input
							name="seller_permit" type="text"
							id="seller_permit"
							class="regular-text"
							value="<?php echo isset( $seller_permit ) ? esc_html( $seller_permit ) : ''; ?>"
							>
						</td>
					</tr>
					<tr>
						<th>
							<label for="practitioner_type">Practitioner Type</label>
						</th>
						<td>
							<input
							name="practitioner_type" type="text" 
							id="practitioner_type" 
							class="regular-text"
							value="<?php echo isset( $practitioner_type ) ? esc_html( $practitioner_type ) : ''; ?>">
						</td>
					</tr>
					<tr>
						<th>
							<label for="title">Title</label>
						</th>
						<td>
							<input
							name="title"
							type="text"
							id="title" 
							class="regular-text"
							value="<?php echo isset( $title ) ? esc_html( $title ) : ''; ?>">
						</td>
					</tr>
					<tr>
						<th>
							<label for="website">Website</label>
						</th>
						<td>
							<input
							name="website"
							type="text"
							id="website"
							class="regular-text"
							value="<?php echo isset( $website ) ? esc_html( $website ) : ''; ?>">
						</td>
					</tr>
					<tr>
						<th>
							<label for="tell_us_about_your_practice">Tell Us About Your Practice</label>
						</th>
						<td>
							<input
							name="tell_us_about_your_practice"
							type="text"
							id="tell_us_about_your_practice"
							class="regular-text"
							value="<?php echo isset( $tell_us_about_your_practice ) ? esc_html( $tell_us_about_your_practice ) : ''; ?>">
						</td>
					</tr>
					<tr>
						<th>
							<label for="notes">Notes</label>
						</th>
						<td>
							<input
							name="notes"
							type="text"
							id="notes"
							class="regular-text"
							value="<?php echo isset( $notes ) ? esc_html( $notes ) : ''; ?>">
						</td>
					</tr>
					<tr>
						<th>
							<label for="notes">Country</label>
						</th>
						<td>
							<input
							name="country"
							type="text"
							id="notes"
							class="regular-text"
							value="<?php echo isset( $country ) ? esc_html( $country ) : ''; ?>">
						</td>
					</tr>
				</tbody>
			</table>
			<a href="#" class="button button-primary button-hero yoo">Update Wholesale Customer Data</a>
		</div>
		<?php
	}

	/**
	 * Undocumented function
	 *
	 * @return void
	 */
	public function yoo() {
		$user_id = $_POST['user_id'];

		update_user_meta( $user_id, 'seller_permit', 'Jwolt Junaid Hello' );

		wp_send_json_success( array( 'message' => 'The user id ' . $user_id ) );
	}
}
