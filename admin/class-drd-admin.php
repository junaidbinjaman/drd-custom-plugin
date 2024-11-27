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
	 * The custom meta keys and field labels of wholesale customer account.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $wholesale_customer_custom_meta_keys = array(
		array(
			'key'        => 'seller_permit',
			'label'      => 'Seller\'s Permit',
			'input_type' => 'text',
		),
		array(
			'key'        => 'practitioner_type',
			'label'      => 'Practitioner Type',
			'input_type' => 'text',
		),
		array(
			'key'        => 'title',
			'label'      => 'Title',
			'input_type' => 'text',
		),
		array(
			'key'        => 'website',
			'label'      => 'Website',
			'input_type' => 'text',
		),
		array(
			'key'        => 'tell_us_about_your_practice',
			'label'      => 'Tell Us ABout Your Practice',
			'input_type' => 'textarea',
		),
		array(
			'key'        => 'wholesale_customer_notes',
			'label'      => 'Notes',
			'input_type' => 'textarea',
		),
	);

	/**
	 * The current user id.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      int    $user_id The current user id.
	 */
	private $user_id;

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

		add_action( 'admin_init', array( $this, 'get_user_id' ) );
	}

	/**
	 * The function extracts the current user id.
	 *
	 * @return void
	 */
	public function get_user_id() {
		$this->user_id = get_current_user_id();
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
		<a href="#" class="drd-application-approval-btn button button-primary">Approve</a>
		<a href="#" class="drd-application-rejection-btn button button-primary">Reject</a>
		<div class="gggg">
		<div class="ggg">
			<span class="loader"></span>
			<p class="drd-approving-message">Approving the account application.</p>

			<div class="drd-approved-message">
				<p>The application has been approved.</p>
				<small>Deleting the application and redirecting to user account!</small>
			</div>

			<div class="drd-rejected-message">
				<p>The application has been rejected.</p>
				<small>Deleting the application and redirecting to all application page.</small>
			</div>
			
			<h3>Please wait...</h3>
		</div>
		</div>
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

		$user_id = $this->register_user( $sanitized_user_data );

		wp_send_json_success(
			array(
				'message' => 'Successfully received data',
				'user_id' => $user_id,
			)
		);

		wp_die();
	}

	/**
	 * The function register the user
	 *
	 * @param array $sanitized_user_data The sanitized user data.
	 * @return int
	 */
	public function register_user( $sanitized_user_data ) {

		$user_data = array(
			'user_nicename' => $sanitized_user_data['first_name'],
			'display_name'  => $sanitized_user_data['first_name'] . $sanitized_user_data['lastName'],
			'nickname'      => $sanitized_user_data['first_name'],
			'first_name'    => $sanitized_user_data['first_name'],
			'last_name'     => $sanitized_user_data['last_name'],
			'role'          => 'wholesale_customer',
			'user_login'    => $sanitized_user_data['first_name'],
			'user_pass'     => 'jwolt65859j',
			'user_email'    => $sanitized_user_data['email'],
			'meta_input'    => array(
				'seller_permit'               => $sanitized_user_data['sellers_permit'],
				'practitioner_type'           => $sanitized_user_data['practitioner_type'],
				'title'                       => $sanitized_user_data['title'],
				'wholesale_customer_notes'    => $sanitized_user_data['wholesale_customer_notes'],
				'tell_us_about_your_practice' => $sanitized_user_data['tell_us_about_your_practice'],
				'country'                     => $sanitized_user_data['country'],
				'website'                     => $sanitized_user_data['website'],
				'billing_first_name'          => $sanitized_user_data['first_name'],
				'billing_last_name'           => $sanitized_user_data['last_name'],
				'billing_address_1'           => $sanitized_user_data['billing_address_line_1'],
				'billing_address_2'           => $sanitized_user_data['billing_address_line_2'],
				'billing_state'               => $sanitized_user_data['billing_country'],
				'billing_city'                => $sanitized_user_data['billing_city'],
				'billing_postcode'            => $sanitized_user_data['billing_postal_code'],
				'billing_phone'               => $sanitized_user_data['phone'],
				'billing_email'               => $sanitized_user_data['email'],
				'shipping_first_name'         => $sanitized_user_data['first_name'],
				'shipping_last_name'          => $sanitized_user_data['last_name'],
				'shipping_address_1'          => $sanitized_user_data['shipping_address_line_1'],
				'shipping_address_2'          => $sanitized_user_data['shipping_address_line_2'],
				'shipping_city'               => $sanitized_user_data['shipping_city'],
				'shipping_postcode'           => $sanitized_user_data['shipping_postal_code'],
				'shipping_country'            => $sanitized_user_data['shipping_country'],
			),
		);

		// The newly created user is or WP_Error is the user creation is not successful.
		$user_id = wp_insert_user( $user_data );

		if ( is_wp_error( $user_id ) ) {
			wp_send_json_error( 'The user is not created' );
			return;
		}

		$this->notify_wholesale_approval( $user_data['user_email'], $user_data['user_pass'] );

		return $user_id;
	}

	/**
	 * The users meta html.
	 *
	 * @return void
	 */
	public function update_custom_user_meta_on_profile_html() {
		$user_id = $_GET['user_id']; //phpcs:ignore;

		if ( ! isset( $user_id ) ) {
			return;
		}

		$user_id = sanitize_text_field( $user_id );
		$user_id = esc_html( $user_id );

		$meta_data = array();

		foreach ( $this->wholesale_customer_custom_meta_keys as $meta_key ) {
			$data                          = get_user_meta( $user_id, $meta_key['key'], true );
			$meta_data[ $meta_key['key'] ] = sanitize_text_field( $data );
		}

		wp_nonce_field( 'wholesale_customer_nonce', '_wholesale_customer_nonce' );
		?>
	<div class="drd-wholesale-customer-meta-data">
		<h1>Wholesale Customer Registration</h1>
		<table>
			<tbody>
				<?php
				foreach ( $this->wholesale_customer_custom_meta_keys as $meta_key ) {
					?>
					<tr>
					<th>
						<label for="seller_permit">
							<?php echo esc_html( $meta_key['label'] ); ?>
						</label>
					</th>
					<td>
						<?php if ( 'text' === $meta_key['input_type'] ) : ?>
						<input
						name="<?php echo esc_html( $meta_key['key'] ); ?>"
						type="text"
						id="<?php echo esc_attr( $meta_key['key'] ); ?>"
						class="regular-text"
						value="<?php echo isset( $meta_data[ $meta_key['key'] ] ) ? esc_html( $meta_data[ $meta_key['key'] ] ) : ''; ?>">
							<?php
						endif;
						if ( 'textarea' === $meta_key['input_type'] ) :
							?>
							<textarea
							name="<?php echo esc_html( $meta_key['key'] ); ?>"
							type="text"
							id="<?php echo esc_attr( $meta_key['key'] ); ?>"
							class="wholesale-customer-notes"
							><?php echo isset( $meta_data[ $meta_key['key'] ] ) ? esc_html( $meta_data[ $meta_key['key'] ] ) : ''; ?></textarea>
							<?php endif; ?>
					</td>
					</tr>
							<?php
				}
				?>
				
			</tbody>
		</table>
	</div>
		<?php
	}

	/**
	 * Update user meta on "Update User" button click
	 *
	 * @param user_id $user_id The user id.
	 * @return mixed
	 */
	public function update_custom_user_meta_on_profile_update( $user_id ) {

		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		check_ajax_referer( 'wholesale_customer_nonce', '_wholesale_customer_nonce' );

		foreach ( $this->wholesale_customer_custom_meta_keys as $meta ) {
			$meta_data = isset( $_POST[ $meta['key'] ] ) ? sanitize_text_field( wp_unslash( $_POST[ $meta['key'] ] ) ) : '';
			update_user_meta( $user_id, $meta['key'], $meta_data );
		}
	}

	/**
	 * Notify a wholesale customer upon approval of their application.
	 *
	 * This function sends an email to the wholesale customer
	 * informing them that their application has been approved.
	 *
	 * @param string $email The user email address.
	 * @param string $password The user password.
	 * @return mixed
	 */
	public function notify_wholesale_approval( $email, $password ) {
		$template_path = plugin_dir_path( __DIR__ ) . 'email-templates/wholesale-approval-email.html';

		$email_template = file_get_contents( $template_path );

		if ( ! $email_template ) {
			return false;
		}

		$email_body = str_replace(
			array( '{{EMAIL}}', '{{PASSWORD}}', '{{ACCOUNT_URL}}' ),
			array( $email, $password, 'https://www.google.com' ),
			$email_template
		);

		$subject = 'Wholesale Account Approval';
		$header  = array(
			'Content-Type: text/html; charset=UTF-8',
			'From: My Company name <no-reply@mail.com>',
		);

		wp_mail( $email, $subject, $email_body, $header );
	}

	/**
	 * Delete a wp post
	 *
	 * The function deletes wp post using post id.
	 *
	 * @return void
	 */
	public function delete_wp_post() {
		check_ajax_referer( 'my-nonce', 'nonce', true );

		$post_id     = isset( $_POST['post_id'] ) ? absint( sanitize_text_field( wp_unslash( $_POST['post_id'] ) ) ) : null;
		$redirect_to = isset( $_POST['redirect_to'] ) ? sanitize_text_field( wp_unslash( $_POST['redirect_to'] ) ) : null;

		$message = array(
			'message' => __( 'Post deleted successfully.', 'drd' ),
		);

		if ( 'post-archive' === $redirect_to ) {
			$message['user_page'] = admin_url( 'edit.php?post_type=wholesale-applicatio' );
		}

		if ( 'user-page' === $redirect_to ) {
			$message['user_page'] = admin_url( 'user-edit.php?user_id=' );
		}

		if ( ! $post_id || ! get_post( $post_id ) ) {
			wp_send_json_error( __( 'Invalid post ID', 'drd' ) );
		}

		if ( ! current_user_can( 'delete_post', $post_id ) ) {
			wp_send_json_error( __( 'You don\'t have', 'drd' ) );
		}

		$result = wp_delete_post( $post_id, false );

		if ( $result ) {
			wp_send_json_success( $message );
		} else {
			wp_send_json_error( __( 'Failed to delete the post.', 'drd' ) );
		}
	}
}
